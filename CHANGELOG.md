# Changelog

## v0.3.3-RC0
- Add `TemporaryAccessibleFile` and `AceessibleFile` classes can now be configured. See the
  documentation comments in each classes for available configurations.

## v0.3.2
- Add `TemporaryAccessibleFile` class that acts like `AccessibleFile`  generates temporary URL.

## v0.3.1
- Add `AccessibleFile` class to store files automatically and convert into URL when getting them.

## v0.3.0
- Add `NullableCaster` abstract class to make all custom cast classes to cast/uncast only if value
  being set or get is not null. This is to support the behavior in Laravel Framework v9. See its
  [upgrade guide](https://laravel.com/docs/9.x/upgrade#custom-casts-and-null) for more info.

## v0.2.0
- Add `CastConfiguration` interface to get configuration flexibly.
- Add `FriendlyDateTimeString` class to convert datetime automatically.
- Fix the URL in README

## v0.1.1
- It is now open-source.
