[![Web Core Back-end Tests](https://img.shields.io/github/actions/workflow/status/KennethTrecy/elomocato/back-end.yml?style=for-the-badge)](https://github.com/KennethTrecy/elomocato/actions/workflows/back-end.yml)
![GitHub lines](https://img.shields.io/github/license/KennethTrecy/elomocato?style=for-the-badge)
![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/KennethTrecy/elomocato?style=for-the-badge&display_name=tag&sort=semver)
![GitHub closed issues count](https://img.shields.io/github/issues-closed/KennethTrecy/elomocato?style=for-the-badge)
![GitHub pull request count](https://img.shields.io/github/issues-pr-closed/KennethTrecy/elomocato?style=for-the-badge)
![Commits since latest version](https://img.shields.io/github/commits-since/KennethTrecy/elomocato/latest?style=for-the-badge)
![Lines of code](https://img.shields.io/tokei/lines/github/KennethTrecy/elomocato?style=for-the-badge)
![GitHub code size in bytes](https://img.shields.io/github/repo-size/KennethTrecy/elomocato?style=for-the-badge)

# Elomocato (Eloquent Model Casting Tools)
This repository only contains casting tools to be used with Eloquent models included in [Laravel Framework](https://laravel.com/).

In the future, it may have other classes that can be used with Eloquent models.

## Origin
Some parts of the repository was based from [`plugin`] branch of [Web Template].

## Usage

### Installation
1. Put the following information in the your `composer.json`:
   ```
   {
      // Your specified properties like name, type, license, etc...

      "require": {
         // other dependencies here...

         "kennethtrecy/elomocato": "^0.4.0"
      },

      // Your other properties like require-dev, autoload, etc...
      // Add the repository to instruct where to find the package
      "repositories": [
         {
            "type": "composer",
            "url": "https://raw.githubusercontent.com/KennethTrecy/PHP_packages/master"
         }
      ],

		"config": {
			// Other configurations here...

			"secure-http": true
		}
   }
   ```
2. Run `composer install`
3. Specify the cast of the attribute to your model class.
   Example:
   ```
	use Illuminate\Database\Eloquent\Model;
	use KennethTrecy\Elomocato\Base64String;

	class ExampleModel extends Model {
		protected $fillable = [
			"example_attribute"
		];

		protected $casts = [
			"example_attribute" => Base64String::class
		];
	}
	```

### Initialization
If you want to contibute, the repository should be initialized to adhere in [Conventional Commits specification] for organize
commits and automated generation of change log.

#### Prerequisites
- [Node.js and NPM]
- [pnpm] (optional)

#### Instructions
By running the command below, all your commits will be linted to follow the [Conventional Commits
specification].
```
$ npm install
```

Or if you have installed [pnpm], run the following command:
```
$ pnpm install
```

To generate the change log automatically, run the command below:
```
$ npx changelogen --from=[tag name or branch name or commit itself] --to=master
```

## Available classes
Here are the available classes that can be used to aid in encoding or decoding of attributes:
- `KennethTrecy\Elomocato\Base64String`. Automatically encodes or decodes a string attribute.
- `KennethTrecy\Elomocato\Base64File`. Automatically encodes or decodes a binary attribute.
- `KennethTrecy\Elomocato\ReverseURLString`. Automatically encodes or decodes a binary attribute. By
  reverse, it means what is recorded in the database is the decoded value and what is from model is
  the encoded value.
- `KennethTrecy\Elomocato\FriendlyDateTimeString`. Automatically converts a datetime attribute in
  human-friendly format. However, it does nothing when setting a value. It uses [`diffForHumans`] (default)
  and related methods internally. To customize what method to invoke or arguments to pass, see below.
- `KennethTrecy\Elomocato\AccessibleFile`. Automatically stores an uploaded file and puts the file
  path in the database. If it will get the value, it will return the URL where to access the file.
- `KennethTrecy\Elomocato\TemporaryAccessibleFile`. Like `KennethTrecy\Elomocato\AccessibleFile` but generates temporary URL instead.

### Customizing Output of `FriendlyDateTimeString`
If you want to use the `shortAbsoluteDiffForHumans` and other related methods, you need to implement the `KennethTrecy\Elomocato\CastConfiguration` interface.

Example:
```
<?php

use Illuminate\Database\Eloquent\Model;
use KennethTrecy\Elomocato\FriendlyDateTimeString;
use KennethTrecy\Elomocato\CastConfiguration;

class Post extends Model implements CastConfiguration {
   protected $fillable = [
      "published_datetime"
   ];

   protected $casts = [
      "published_datetime" => FriendlyDateTimeString::class
   ];

   public function getCastConfiguration() {
      return [
         // Contain all `FriendlyDateTimeString` cast configurations
         FriendlyDateTimeString::class => [
            // Put the name of attributes you want to customize here...

            // The only exception is the "default" key.
            // This will be selected for all attributes.
            "default" => [
               "prefix" => "longAbsolute",
               "arguments" => now()
            ],

            // If the attribute name has associated configuration,
            // it will override the default configuration above.
            "published_datetime" => [
               // Prefix of the method use want to use (optional).
               // If null, the method to be called is `diffForHumans`.
               // In this case, it will call `shortAbsoluteDiffForHumans`.
               "prefix" => "shortAbsolute",

               // Arguments to pass to the method
               "arguments" => [
                  now()
               ]
            ]
         ]
      ];
   }
}

```

### Custom cast configurations
For now, only `KennethTrecy\Elomocato\FriendlyDateTimeString`,
`KennethTrecy\Elomocato\AccessibleFile`, and `KennethTrecy\Elomocato\TemporaryAccessibleFile` use
cast configuration. The interface was created to allow other custom cast classes have a
configuration.

The algorithm will resolve configurations in this order:
1. Custom configuration in model specified by attribute name as key.
2. Custom configuration in model specified by `default` key.
3. Default configuration specified in the custom cast classes themselves.

## Documentation
You can generate the documentation offline using [phpDocumentor](https://docs.phpdoc.org/guide/getting-started/installing.html).
1. Choose one of the installation options of [phpDocumentor](https://docs.phpdoc.org/guide/getting-started/installing.html).
2. Run `git clone git@github.com:KennethTrecy/elomocato.git`.
3. Run `cd elomocato`.
4. Run `php phpDocumentor.phar` or `phpDocumentor`, or other commands depending on your installation option.
5. Visit the [hidden_docs/index.html](hidden_docs/index.html) in your preferred browser.

## Notes
If you found a bug, please file an issue.

### License
The repository is licensed under [MIT].

### Want to contribute?
Read the [contributing guide] for different ways to contribute in the project.

### Author
Elomocato was created by Kenneth Trecy Tobias.

[`plugin`]: https://github.com/KennethTrecy/web_template/tree/plugin
[Web Template]: http://github.com/KennethTrecy/web_template
[`diffForHumans`]: https://github.com/briannesbitt/Carbon/blob/1a3b5039ccc524065dea55a732385e5a9c0f03d6/src/Carbon/CarbonInterface.php#L1340
[MIT]: https://github.com/KennethTrecy/elomocato/blob/master/LICENSE
[Node.js and NPM]: https://nodejs.org/en/
[pnpm]: https://pnpm.io/installation
[Conventional Commits specification]: https://www.conventionalcommits.org/en/v1.0.0/
[contributing guide]: ./CONTRIBUTING.md
