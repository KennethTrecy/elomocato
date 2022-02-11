<?php

namespace Tests\Mocks\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
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
        return [
            "name" => $this->faker->word()." ".$this->faker->word(),
            "content" => $this->faker->paragraph()
        ];
    }

    public function transform(array $transformers)
    {
        return $this->state(function ($values) use ($transformers) {
            foreach ($transformers as $attribute_name => $transformer) {
                $values[$attribute_name] = $transformer($values[$attribute_name]);
            }
            return $values;
        });
    }
}
