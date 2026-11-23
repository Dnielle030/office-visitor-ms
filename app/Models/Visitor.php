<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact_number', 'purpose', 'person_to_visit',
        'department', 'time_in', 'time_out', 'registered_by', 'checked_out_by',
    ];

    protected function casts(): array
    {
        return ['time_in' => 'datetime', 'time_out' => 'datetime'];
    }

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    public function scopeInside($query)
    {
        return $query->whereNull('time_out');
    }

    /** Data privacy: receptionists only see the last 4 digits. */
    protected function maskedContact(): Attribute
    {
        return Attribute::get(fn () => str_repeat('*', max(strlen($this->contact_number) - 4, 0))
            . substr($this->contact_number, -4));
    }

    public function contactFor(User $user): string
    {
        return $user->isAdmin() ? $this->contact_number : $this->masked_contact;
    }

    public function getHostAttribute(): string
    {
        return collect([$this->person_to_visit, $this->department])->filter()->implode(' / ');
    }
}
