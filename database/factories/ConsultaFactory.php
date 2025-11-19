<?php

namespace Database\Factories;

use App\Models\Consulta;
use App\Models\Cita;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consulta>
 */
class ConsultaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Consulta::class;
    public function definition(): array
    {
        return [
            // 'cita_id' => Cita::factory(), // crea una cita automáticamente si no existe
            'cita_id' => Cita::inRandomOrder()->first()->id ?? Cita::factory(),  // Usa una cita existente o crea una nueva
            'diagnostico' => $this->faker->sentence(12),
            'tratamiento' => $this->faker->sentence(10),
            'notas' => $this->faker->paragraph(2),
        ];
    }
}
