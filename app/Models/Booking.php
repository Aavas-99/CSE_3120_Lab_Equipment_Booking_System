<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const STATUSES = ['Pending', 'Approved', 'Issued', 'Return Requested', 'Returned', 'Closed', 'Rejected', 'Overdue'];
    public const LATE_FINE_PER_DAY = 20;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'borrow_date',
        'expected_return_date',
        'actual_return_date',
        'status',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'expected_return_date' => 'date',
            'actual_return_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    public function damageReports()
    {
        return $this->hasMany(DamageReport::class);
    }

    public function daysLate(?Carbon $returnDate = null): int
    {
        $returnDate ??= now();

        if ($returnDate->lte($this->expected_return_date)) {
            return 0;
        }

        return (int) $this->expected_return_date->diffInDays($returnDate);
    }
}
