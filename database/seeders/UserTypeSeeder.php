<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userType = new UserType();
        $userType->name = 'Usuário';
        $userType->save();

        $userType = new UserType();
        $userType->name = 'Lojista';
        $userType->save();
    }
}
