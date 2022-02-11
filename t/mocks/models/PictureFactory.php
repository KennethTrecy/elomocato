<?php

namespace Tests\Mocks\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class PictureFactory extends Factory
{
    public function __construct($model = null)
    {
        $this->model = $model;
        parent::__construct();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = UploadedFile::fake()->image("picture.png")->store("/");
        return [
            "name" => $this->faker->word(),
            "path" => $path
        ];
    }
}
