<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'player_limit'];


    public function players()
    {
        return $this->belongsToMany(Player::class)
            ->withPivot('player_score');
    }
}
