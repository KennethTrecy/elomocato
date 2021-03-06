# Elomocato (Eloquent Model Casting Tools)
This repository only contains casting tools to be used with Eloquent models included in [Laravel Framework](https://laravel.com/).

In the future, it may have other classes that can be used with Eloquent models.

## Origin
The repository was based from [`plugin`] branch of [Web Template].

## Installation
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
This is a newly-created project which may have bugs. If you found one, please file an issue.

## Author
Elomocato was created by Kenneth Trecy Tobias.

[`plugin`]: https://github.com/KennethTrecy/web_template/tree/plugin
[Web Template]: http://github.com/KennethTrecy/web_template
[`diffForHumans`]: https://github.com/briannesbitt/Carbon/blob/1a3b5039ccc524065dea55a732385e5a9c0f03d6/src/Carbon/CarbonInterface.php#L1340
