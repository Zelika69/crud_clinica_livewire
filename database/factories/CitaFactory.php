<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cita::class;
    public function definition(): array
    {
        return [
            // 'paciente_id' => Paciente::factory(),   // Crea un paciente automáticamente
            // 'doctor_id' => Doctor::factory(),       // Crea un doctor automáticamente
            'paciente_id' => Paciente::inRandomOrder()->first()->id ?? Paciente::factory(), // Usa un paciente existente o crea uno nuevo
            'doctor_id' => Doctor::inRandomOrder()->first()->id ?? Doctor::factory(), // Usa un doctor existente o crea uno nuevo
            'fecha_hora' => $this->faker->dateTimeBetween('now', '+2 months'),
            'estado' => $this->faker->randomElement([
                'programada',
                'confirmada',
                'cancelada',
                'atendida'
            ]),
            'motivo' => $this->faker->sentence(8),
        ];
    }
}
