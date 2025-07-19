<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualificationType extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'name'];

    public static $levels = [
        'secondary and high',
        'hnd',
        'degree',
    ];

    public static $qualifications = [
        1 => 'Secondary School',
        2 => 'High School',
        3 => 'HND',
        4 => 'First Degree',
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }
}
