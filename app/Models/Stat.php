<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['campaign_id', 'term_id', 'monetization_timestamp', 'revenue'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}