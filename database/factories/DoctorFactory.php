<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'especialidad' => $this->faker->randomElement([
                'Cardiología',
                'Pediatría',
                'Dermatología',
                'Neurología',
                'Ginecología',
                'Psiquiatría',
                'Ortopedia',
                'Medicina General'
            ]),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'foto_perfil' => 'fotos/doctores/default.webp', // Ruta estática y fija
        ];
    }
}
