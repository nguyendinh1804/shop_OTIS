<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'specialty_id',
        'name',
        'phone',
        'bio',
        'avatar',
    ];

    /**
     * @return BelongsTo<Specialty, Doctor>
     */
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * @return HasMany<Appointment>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * @return HasMany<DoctorSchedule>
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
