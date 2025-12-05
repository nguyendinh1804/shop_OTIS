<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Null nếu admin đặt cho khách hàng walk-in
        'doctor_id',
        'patient_name',
        'patient_phone',
        'patient_email',
        'date',
        'time',
        'status',
        'note',
    ];

    /**
     * @return BelongsTo<Doctor, Appointment>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * @return BelongsTo<User, Appointment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
