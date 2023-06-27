# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

<a name="unreleased"></a>
## [Unreleased]


<a name="1.8.1"></a>
## [1.8.1] - 2023-06-12
### Fixed
- Make `id` nullable and `statusCode` configurable


<a name="1.8.0"></a>
## [1.8.0] - 2023-06-11
### Added
- Error document responding for validaton errors


<a name="1.7.0"></a>
## [1.7.0] - 2023-06-11
### Changed
- Make the paginator configurable per entity


<a name="1.6.0"></a>
## [1.6.0] - 2023-06-11
### Added
- Form requests for storing and updating payloads
- Basic testing utilities to start testing controller requests

### Changed
- Extracted route interactions from controller into `Route` class


<a name="1.5.1"></a>
## [1.5.1] - 2023-06-09
### Added
- Support for using form requests for request validation


<a name="1.5.0"></a>
## [1.5.0] - 2023-06-09
### Changed
- Specify relationships as data objects


<a name="1.4.0"></a>
## [1.4.0] - 2023-06-09
### Added
- Call `authorize` in controller to enforce ACL


<a name="1.3.0"></a>
## [1.3.0] - 2023-06-09
### Changed
- Store `Implementation` instance in `Server`


<a name="1.2.2"></a>
## [1.2.2] - 2023-06-09
### Fixed
- Resource links with nested parents


<a name="1.2.1"></a>
## [1.2.1] - 2023-06-09
### Changed
- Use prefixed keys for route defaults to avoid conflicts


<a name="1.2.0"></a>
## [1.2.0] - 2023-06-09
### Added
- Automatic route discovery and registration


<a name="1.1.1"></a>
## [1.1.1] - 2023-06-09
### Fixed
- Namespaces for model and resource guessing


<a name="1.1.0"></a>
## [1.1.0] - 2023-06-09
### Added
- Initial `Proof of Concept` for servers, entities and controllers


<a name="1.0.1"></a>
## [1.0.1] - 2023-06-08
### Added
- Support for `title` and `describedby` properties for links


<a name="1.0.0"></a>
## 1.0.0 - 2023-06-08

[Unreleased]: https://github.com/BombenProdukt/package_slug/compare/1.8.1...HEAD
[1.8.1]: https://github.com/BombenProdukt/package_slug/compare/1.8.0...1.8.1
[1.8.0]: https://github.com/BombenProdukt/package_slug/compare/1.7.0...1.8.0
[1.7.0]: https://github.com/BombenProdukt/package_slug/compare/1.6.0...1.7.0
[1.6.0]: https://github.com/BombenProdukt/package_slug/compare/1.5.1...1.6.0
[1.5.1]: https://github.com/BombenProdukt/package_slug/compare/1.5.0...1.5.1
[1.5.0]: https://github.com/BombenProdukt/package_slug/compare/1.4.0...1.5.0
[1.4.0]: https://github.com/BombenProdukt/package_slug/compare/1.3.0...1.4.0
[1.3.0]: https://github.com/BombenProdukt/package_slug/compare/1.2.2...1.3.0
[1.2.2]: https://github.com/BombenProdukt/package_slug/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/BombenProdukt/package_slug/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/BombenProdukt/package_slug/compare/1.1.1...1.2.0
[1.1.1]: https://github.com/BombenProdukt/package_slug/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/BombenProdukt/package_slug/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/BombenProdukt/package_slug/compare/1.0.0...1.0.1
