<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetSelection extends Model
{
    use HasFactory;

    protected $fillable = ['selection_id','odds'];

    public function bet()
    {
        return $this->belongsTo('App\Models\Bet');
    }
}
