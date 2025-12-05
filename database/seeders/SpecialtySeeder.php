<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            [
                'name' => 'Nha khoa',
                'description' => 'Chăm sóc sức khỏe răng miệng và điều trị các bệnh lý nha khoa.',
            ],
            [
                'name' => 'Tim mạch',
                'description' => 'Chẩn đoán và điều trị các bệnh lý liên quan đến tim và hệ tuần hoàn.',
            ],
            [
                'name' => 'Da liễu',
                'description' => 'Điều trị các vấn đề về da, tóc và móng.',
            ],
            [
                'name' => 'Nhi khoa',
                'description' => 'Chăm sóc sức khỏe toàn diện cho trẻ em.',
            ],
            [
                'name' => 'Răng hàm mặt',
                'description' => 'Phẫu thuật và chỉnh hình răng hàm mặt.',
            ],
        ];

        foreach ($specialties as $specialty) {
            Specialty::updateOrCreate(
                ['name' => $specialty['name']],
                ['description' => $specialty['description']]
            );
        }
    }
}
