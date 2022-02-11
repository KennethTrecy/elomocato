<?php

namespace Tests\Mocks\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public $factory = PictureFactory::class;

    protected $table = "pictures";

    protected $fillable = [
        "name",
        "path"
    ];
}
