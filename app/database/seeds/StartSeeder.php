<?php

use Reportr\Entities\Account;
use Reportr\Entities\User;

class StartSeeder extends Seeder {

    public function run()
    {
        DB::table('accounts')->delete();
        DB::table('users')->delete();

        $account = Account::create([
            'name' => 'Z Computers'
        ]);

        User::create([
            'username' => 'zcomputers',
            'email' => 'admin@zcomputers.org',
            'password' => Hash::make('syedm9495'),
            'account_id' => $account->id
        ]);

        $account = Account::create([
            'name' => 'Teamwork Packaging'
        ]);

        User::create([
            'username' => 'twpackaging',
            'email' => 'zainab@twpackaging.com',
            'password' => Hash::make('twpack494'),
            'account_id' => $account->id
        ]);
    }
}