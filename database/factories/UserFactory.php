<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email  = $this->faker->unique()->safeEmail;
        $password = explode('@', $email);
        $password = bcrypt($password[0] . '@123');
        $user_type_id = $this->faker->numberBetween(1,2);

        $pool = '0123456789';
        $length = ($user_type_id === 1? 9 : 8);
        $document = substr(str_shuffle(str_repeat($pool, 11)), 0, $length);
        $digit = substr(str_shuffle(str_repeat($pool, 11)), 0, 2);
        $document = $document . ($user_type_id === 1? '' : '0001') . $digit;

        return [
            'name' => $this->faker->name,
            'email' => $email,
            'email_verified_at' => now(),
            //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password' => $password, // password
            'document' => $document, 
            'user_type_id' => $user_type_id,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
