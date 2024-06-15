<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoria_id' => fake()->numberBetween(1, 9),
            'nome' => fake()->words(3, true),
            'descricao' => fake()->sentences(3, true),
            'preco' => fake()->randomFloat(2, 50, 900),
        ];
    }
}
