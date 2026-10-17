<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Super Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('nasruddin@#321@#'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Default App Settings
        AppSetting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => 'Technician\'s Toolkit']
        );

        AppSetting::updateOrCreate(
            ['key' => 'whatsapp_support'],
            ['value' => '8860400956']
        );

        AppSetting::updateOrCreate(
            ['key' => 'whatsapp_group_url'],
            ['value' => 'https://chat.whatsapp.com/IQPkYqRl5bxLniZGmLFBdZ']
        );

        AppSetting::updateOrCreate(
            ['key' => 'min_version'],
            ['value' => '1.0.0']
        );

        AppSetting::updateOrCreate(
            ['key' => 'current_version'],
            ['value' => '1.0.0']
        );
    }
}
