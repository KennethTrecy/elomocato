<?php

namespace Tests\Mocks\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
	protected $table = "files";

	protected $fillable = [
		"name",
		"content"
	];

	function __constructor($casts) {
		$this->casts = $casts;
	}
}
