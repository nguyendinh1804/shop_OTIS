<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'BS. Nguyễn Minh An',
                'phone' => '0901002003',
                'bio' => 'Hơn 10 năm kinh nghiệm trong điều trị các bệnh lý nha khoa phức tạp.',
                'avatar' => null,
                'specialty' => 'Nha khoa',
            ],
            [
                'name' => 'BS. Trần Thị Hoa',
                'phone' => '0909008007',
                'bio' => 'Chuyên gia can thiệp tim mạch với nhiều ca phẫu thuật thành công.',
                'avatar' => null,
                'specialty' => 'Tim mạch',
            ],
            [
                'name' => 'BS. Lê Hồng Phát',
                'phone' => '0912003004',
                'bio' => 'Tư vấn và điều trị các bệnh về da liễu mãn tính.',
                'avatar' => null,
                'specialty' => 'Da liễu',
            ],
            [
                'name' => 'BS. Phạm Văn Nam',
                'phone' => '0987654321',
                'bio' => 'Bác sĩ chuyên khoa nhi với hơn 8 năm kinh nghiệm.',
                'avatar' => null,
                'specialty' => 'Nhi khoa',
            ],
            [
                'name' => 'BS. Võ Thị Mai',
                'phone' => '0976543210',
                'bio' => 'Chuyên gia phẫu thuật răng hàm mặt và chỉnh nha.',
                'avatar' => null,
                'specialty' => 'Răng hàm mặt',
            ],
        ];

        foreach ($doctors as $doctor) {
            $specialtyId = Specialty::where('name', $doctor['specialty'])->value('id');

            if (! $specialtyId) {
                continue;
            }

            Doctor::updateOrCreate(
                ['phone' => $doctor['phone']],
                [
                    'specialty_id' => $specialtyId,
                    'name' => $doctor['name'],
                    'bio' => $doctor['bio'],
                    'avatar' => $doctor['avatar'],
                ]
            );
        }
    }
}
