<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ['utm_term', 'name'];

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }
}