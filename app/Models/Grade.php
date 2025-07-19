<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;

    protected $fillable = [
        'application_id',
        'qualification_id',
        'subject',
        'score' // or grade|average depending on whether it's technical of general
    ];

    public function applicant()
    {
        return $this->belongsTo(Application::class);
    }
}
