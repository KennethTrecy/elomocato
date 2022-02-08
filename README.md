# Elomocato (Eloquent Model Casting Tools)
This repository only contains casting tools to be used with Eloquent models included in [Laravel Framework](https://laravel.com/).

In the future, it may have other classes that can be used with Eloquent models. For now, it only supports casting related to base64 encoding.

## Origin
The repository was based from [`plugin`] branch of [Web Template].

## Installation
1. Put the following information in the your `composer.json`:
   ```
   {
      // Your specified properties like name, type, license, etc...

      "require": {
         // other dependencies here...

         "kennethtrecy/elomocato": "^0.2.0"
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
