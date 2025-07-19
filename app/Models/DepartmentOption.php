<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentOption extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'level'];

    // Define the available levels
    public const LEVELS = [
        'year_1' => 'Year 1',
        'year_3' => 'Year 3',
        'year_4' => 'Year 4',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Accessor to get formatted level display
    public function getLevelDisplayAttribute(): string
    {
        return self::LEVELS[$this->level] ?? $this->level;
    }

    // Scope to filter by level
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}