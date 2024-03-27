<?php

namespace App\Models;

use App\Observers\MedicalRecordObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([MedicalRecordObserver::class])]
class MedicalRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prescription',
        'weight',
        'attachments',
        'appointment_id',
        'pet_id',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    /**
     * Get the pet associated with the medical record.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the appointment associated with the medical record.
     */
    public function appointmentScheduling(): BelongsTo
    {
        return $this->belongsTo(AppointmentScheduling::class);
    }
}
