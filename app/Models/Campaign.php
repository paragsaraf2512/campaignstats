<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['utm_campaign', 'name'];

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }
}
