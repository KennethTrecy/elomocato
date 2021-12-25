# Elomocato (Eloquent Model Casting Tools)
This repository only contains casting tools to be used with Eloquent models included in [Laravel Framework](https://laravel.com/).

## Installation
1. Put the following information in the your `composer.json`:
   ```
	{
		// Your specified properties like name, type, license, etc...

		"require": {
			// other dependencies here...

			"kennethtrecy/elomocato": "0.1.0"
		},

		// Your other properties like require-dev, autoload, etc...

		// Add the repository to instruct where to find the package
		"repositories": [
			{
				"type": "vcs",
				"url": "git@repo.kennethtrecy:KennethTrecy/elomocato.git"
			}
		]
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
- `KennethTrecy\Elomocato\Base64String`. Automatics encodes or decodes a string attribute.
- `KennethTrecy\Elomocato\Base64File`. Automatics encodes or decodes a binary attribute.

## Documentation
You can generate the documentation offline using [phpDocumentor](https://docs.phpdoc.org/guide/getting-started/installing.html).
1. Choose one of the installation options of [phpDocumentor](https://docs.phpdoc.org/guide/getting-started/installing.html).
2. Run `git clone git@repo.kennethtrecy:KennethTrecy/elomocato.git`.
3. Run `cd elomocato`.
4. Run `php phpDocumentor.phar` or `phpDocumentor`, or other commands depending on your installation option.

## Notes
This is a newly-created project which may have bugs. If you found one, please file an issue.

## Author
Elomocato was created by Kenneth Trecy Tobias.
