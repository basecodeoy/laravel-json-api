<?php

declare(strict_types=1);

namespace Tests\Application;

use BaseCodeOy\PackagePowerPack\TestBench\AbstractAnalysisTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class AnalysisTest extends AbstractAnalysisTestCase
{
    protected static function getIgnored(): array
    {
        return [
            'Pest\Laravel\assertDatabaseHas',
            'Pest\Laravel\assertDatabaseMissing',
            'Pest\Laravel\delete',
            'Pest\Laravel\get',
            'Pest\Laravel\patch',
            'Pest\Laravel\post',
            'Pest\Laravel\put',
            'Pest\Laravel\withoutExceptionHandling',
        ];
    }
}
