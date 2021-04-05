<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pool = '0123456789';

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin@123');
        $user->document = substr(str_shuffle(str_repeat($pool, 11)), 0, 11);
        $user->user_type_id = 1;
        $user->save();

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@user.com';
        $user->password = bcrypt('user@123');
        $user->document = substr(str_shuffle(str_repeat($pool, 11)), 0, 11);
        $user->user_type_id = 1;
        $user->save();

        User::factory(30)->create();

    }
}
