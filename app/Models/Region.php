<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
