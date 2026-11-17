# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.0 - 2023-04-04

### Added

- Added return type declarations to all interfaces as per the PSR-7 errata (#95).

### Deprecated

- Nothing.

### Removed

- Removed `declare(strict_types=1);` from interface files (#95).

### Fixed

- Nothing.

## 1.1 - 2023-04-04

### Added

- Added parameter type declarations to all interfaces as per the PSR-7 errata (#94).
- Added PSR-7 interfaces method list (`docs/PSR7-Interfaces.md`) and usage guide (`docs/PSR7-Usage.md`) (#79).

### Changed

- Updated minimum PHP version requirement to `^7.2 || ^8.0` (#94).

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.1 - 2016-08-06

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Updated all `@return self` annotation references in interfaces to use
  `@return static`, which more closelly follows the semantics of the
  specification.
- Updated the `MessageInterface::getHeaders()` return annotation to use the
  value `string[][]`, indicating the format is a nested array of strings.
- Updated the `@link` annotation for `RequestInterface::withRequestTarget()`
  to point to the correct section of RFC 7230.
- Updated the `ServerRequestInterface::withUploadedFiles()` parameter annotation
  to add the parameter name (`$uploadedFiles`).
- Updated a `@throws` annotation for the `UploadedFileInterface::moveTo()`
  method to correctly reference the method parameter (it was referencing an
  incorrect parameter name previously).

## 1.0.0 - 2016-05-18

Initial stable release; reflects accepted PSR-7 specification.
