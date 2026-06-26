<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public const STATUSES = ['Available', 'Reserved', 'Issued', 'Maintenance', 'Damaged'];

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'serial_number',
        'quantity',
        'available_quantity',
        'status',
        'location',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isBookable(): bool
    {
        return $this->status === 'Available' && $this->available_quantity > 0;
    }

    public function refreshStatusFromQuantity(): void
    {
        if (in_array($this->status, ['Maintenance', 'Damaged'], true)) {
            return;
        }

        $this->status = $this->available_quantity > 0 ? 'Available' : 'Reserved';
    }
}
