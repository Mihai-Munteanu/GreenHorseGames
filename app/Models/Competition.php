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

    public function canTakeMorePlayers()
    {
        if($this->players()->count() >= $this->player_limit) {
            // player cannot join the competition
            return response()->json([
                "message" => "Player limit reached",
                "status" => "error"
            ]);
        }
    }

    public function hasPlayer($player)
    {
        if($player->competitions()->where('id', $this->id)->doesntExist()) {
            // no player on this competition
            return response()->json([
                "message" => "Player not in competition",
                "status" => "error",
            ]);
        }
    }
}
