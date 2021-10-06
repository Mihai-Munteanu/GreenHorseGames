<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    public function competitions()
    {
        return $this->belongsToMany(Competition::class)
            ->withPivot('player_score');
    }

    public function incrementScore($competition)
    {
        $competition->players()->where('id', $this->id)->first()->pivot->increment('player_score', 1);

        return $competition->players()->where('id', $this->id)->first()->pivot->player_score;
    }
}
