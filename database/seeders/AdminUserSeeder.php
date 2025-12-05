<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::updateOrCreate(
            ['email' => 'admin@otis.vn'],
            [
                'name' => 'Admin OTIS',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Tạo tài khoản khách hàng demo
        User::updateOrCreate(
            ['email' => 'customer@otis.vn'],
            [
                'name' => 'Nguyễn Văn A',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );

        $this->command->info('✅ Đã tạo tài khoản Admin và Customer demo');
        $this->command->info('📧 Admin: admin@otis.vn / password123');
        $this->command->info('📧 Customer: customer@otis.vn / password123');
    }
}
