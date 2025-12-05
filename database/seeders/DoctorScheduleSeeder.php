<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả bác sĩ
        $doctors = Doctor::all();

        // Định nghĩa các khung giờ làm việc mẫu
        $scheduleTemplates = [
            // Template 1: Làm việc cả tuần
            [
                ['day' => 'monday', 'start' => '08:00', 'end' => '17:00'],
                ['day' => 'tuesday', 'start' => '08:00', 'end' => '17:00'],
                ['day' => 'wednesday', 'start' => '08:00', 'end' => '17:00'],
                ['day' => 'thursday', 'start' => '08:00', 'end' => '17:00'],
                ['day' => 'friday', 'start' => '08:00', 'end' => '17:00'],
            ],
            // Template 2: Làm việc thứ 2, 4, 6
            [
                ['day' => 'monday', 'start' => '09:00', 'end' => '18:00'],
                ['day' => 'wednesday', 'start' => '09:00', 'end' => '18:00'],
                ['day' => 'friday', 'start' => '09:00', 'end' => '18:00'],
            ],
            // Template 3: Làm việc thứ 3, 5, 7
            [
                ['day' => 'tuesday', 'start' => '08:00', 'end' => '16:00'],
                ['day' => 'thursday', 'start' => '08:00', 'end' => '16:00'],
                ['day' => 'saturday', 'start' => '08:00', 'end' => '12:00'],
            ],
            // Template 4: Ca chiều tối
            [
                ['day' => 'monday', 'start' => '13:00', 'end' => '21:00'],
                ['day' => 'tuesday', 'start' => '13:00', 'end' => '21:00'],
                ['day' => 'wednesday', 'start' => '13:00', 'end' => '21:00'],
                ['day' => 'thursday', 'start' => '13:00', 'end' => '21:00'],
                ['day' => 'friday', 'start' => '13:00', 'end' => '21:00'],
            ],
        ];

        // Gán lịch làm việc cho từng bác sĩ
        foreach ($doctors as $index => $doctor) {
            $template = $scheduleTemplates[$index % count($scheduleTemplates)];

            foreach ($template as $schedule) {
                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'day_of_week' => $schedule['day'],
                    'start_time' => $schedule['start'],
                    'end_time' => $schedule['end'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
