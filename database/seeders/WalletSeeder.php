<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach($users as $user){
            $wallet = new Wallet();
            $wallet = $wallet->create(['value' => mt_rand(100, 100000000)/100]);

            $user->wallets()->attach($user->id);
        }
    }
}
