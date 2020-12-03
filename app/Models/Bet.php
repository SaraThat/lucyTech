<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = ['stake_amount'];


    public function betSelection()
    {
        return $this->hasMany('App\Models\BetSelection');
    }
}
