<?php

namespace Database\Seeders;

use App\Laravue\Models\User;
use App\Models\Referral;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $data = [
            'name' => 'Администратор',
            'email' => 'admin@test.ru',
            'active'=> true,
            'password'=> Hash::make('1q23ty3io'),
			'telegram_id' => 0,
			'referral_token' => 'reftok',
        ];

        $admin= User::create($data);

        $admin->assignRole($role);
    }
}
