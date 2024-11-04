<?php

declare(strict_types=1);

namespace BaseCodeOy\JsonApi\Http\Request;

use BaseCodeOy\JsonApi\Data\ErrorObjectCollection;
use BaseCodeOy\JsonApi\Exception\ValidationException;
use BaseCodeOy\JsonApi\Route\RouteParameter;
use BaseCodeOy\JsonApi\Route\RouterInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LogicException;

abstract class AbstractFormRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isStoringResource()) {
            $rules = $this->rulesForStoringResource();
        }

        if ($this->isUpdatingResource()) {
            $rules = $this->rulesForUpdatingResource();
        }

        if ($this->isUpdatingRelationship()) {
            $rules = $this->rulesForUpdatingRelationship();
        }

        if ($this->isAttachingRelationship()) {
            $rules = $this->rulesForAttachingRelationship();
        }

        if ($this->isDetachingRelationship()) {
            $rules = $this->rulesForDetachingRelationship();
        }

        return collect($this->rulesForAttributes())
            ->mapWithKeys(fn (array $rules, string $attribute) => ["data.attributes.{$attribute}" => $rules])
            ->merge($rules)
            ->toArray();
    }

    public function getAttributes(): array
    {
        return $this->validated('data.attributes');
    }

    public function hasAttributes(): bool
    {
        return \count($this->getAttributes()) > 0;
    }

    public function getRelations(): array
    {
        return $this->validated('data.relationships');
    }

    public function hasRelationships(): bool
    {
        return \count($this->getRelations()) > 0;
    }

    public function isViewingResources(): bool
    {
        if (!$this->isMethod('GET')) {
            return false;
        }

        if ($this->hasResourceName()) {
            return false;
        }

        return $this->isNotRelationship();
    }

    public function isViewingResource(): bool
    {
        if (!$this->isMethod('GET')) {
            return false;
        }

        return $this->hasResourceName() && $this->isNotRelationship();
    }

    public function isViewingRelated(): bool
    {
        if (!$this->isMethod('GET')) {
            return false;
        }

        if ($this->urlContainsRelationships()) {
            return false;
        }

        return $this->isRelationship();
    }

    public function isViewingRelationship(): bool
    {
        if (!$this->isMethod('GET')) {
            return false;
        }

        return $this->isRelationship() && $this->urlContainsRelationships();
    }

    public function isStoringResource(): bool
    {
        if (!$this->isMethod('POST')) {
            return false;
        }

        return $this->isNotRelationship();
    }

    public function isUpdatingResource(): bool
    {
        if (!$this->isMethod('PATCH')) {
            return false;
        }

        return $this->isNotRelationship();
    }

    public function isDeletingResource(): bool
    {
        if (!$this->isMethod('DELETE')) {
            return false;
        }

        return $this->isNotRelationship();
    }

    public function isUpdatingRelationship(): bool
    {
        if (!$this->isMethod('PATCH')) {
            return false;
        }

        return $this->isRelationship();
    }

    public function isAttachingRelationship(): bool
    {
        if (!$this->isMethod('POST')) {
            return false;
        }

        if (!$this->isRelationship()) {
            return false;
        }

        if ($this->isToOne()) {
            throw new LogicException('Cannot detach a to-one relationship');
        }

        return true;
    }

    public function isDetachingRelationship(): bool
    {
        if (!$this->isMethod('DELETE')) {
            return false;
        }

        if (!$this->isRelationship()) {
            return false;
        }

        if ($this->isToOne()) {
            throw new LogicException('Cannot detach a to-one relationship');
        }

        return true;
    }

    public function isRelationship(): bool
    {
        return $this->currentRoute()->hasResourceRelationship();
    }

    public function isNotRelationship(): bool
    {
        return !$this->isRelationship();
    }

    protected function relationshipTypes(): array
    {
        return [];
    }

    protected function rulesForAttributes(): array
    {
        return [];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException(ErrorObjectCollection::fromValidator($validator));
    }

    private function rulesForStoringResource(): array
    {
        return [
            'data' => ['required', 'array'],
            'data.type' => ['required', 'string'],
            'data.relationships' => ['nullable', 'array'],
            'data.relationships.*' => ['required', 'array'],
            'data.relationships.*.type' => ['required', Rule::in($this->relationshipTypes())],
            'data.relationships.*.id' => ['required', 'alpha_num'],
        ];
    }

    private function rulesForUpdatingResource(): array
    {
        return [
            ...$this->rulesForStoringResource(),
            'data.id' => ['required', Rule::exists($this->route(RouteParameter::RESOURCE_TYPE), 'id')],
        ];
    }

    private function rulesForUpdatingRelationship(): array
    {
        if ($this->isToMany()) {
            return [
                'data' => ['present', 'nullable', 'array'],
                'data.*.type' => ['required', 'string'],
                'data.*.id' => ['required', 'alpha_num'],
            ];
        }

        return [
            'data' => ['present', 'nullable', 'array'],
            'data.type' => ['required', 'string'],
            'data.id' => ['required', 'alpha_num'],
        ];
    }

    private function rulesForAttachingRelationship(): array
    {
        if ($this->isToMany()) {
            return [
                'data' => ['required', 'array'],
                'data.*.type' => ['required', 'string'],
                'data.*.id' => ['required', 'alpha_num'],
            ];
        }

        return [
            'data' => ['required', 'array'],
            'data.type' => ['required', 'string'],
            'data.id' => ['required', 'alpha_num'],
        ];
    }

    private function rulesForDetachingRelationship(): array
    {
        return $this->rulesForAttachingRelationship();
    }

    private function hasResourceName(): bool
    {
        return $this->currentRoute()->hasResourceName();
    }

    private function urlContainsRelationships(): bool
    {
        return Str::of($this->url())->contains('/relationships/');
    }

    private function currentRoute(): RouterInterface
    {
        return App::get(RouterInterface::class);
    }
}
