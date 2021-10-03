<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

class CompetitionPlayerIncrementController extends Controller
{

    public function index(Competition $competition)
    {
        $playersOnCompetition = $competition->players()->orderByDesc('player_score')->paginate(2);

        return response()->json(
            [
                "message" => "Success, all players from this competition",
                "status" => "Success",
                "playersOnCompetition" => $playersOnCompetition
            ]
        );
    }

    public function store(Competition $competition, Player $player)
    {

        // verify if player is on this competition
        if($player->competitions()->where('id', $competition->id)->exists()) {

            // verify the player's score and add 1 point
            $playerScore = $competition->players()->where('id', $player->id)->first()->pivot->player_score + 1;

            // update the player's score
            $competition->players()->syncWithoutDetaching([$player->id => ['player_score' => $playerScore]]);

            return response()->json(
                [
                    "message" => "Success, player's score points is updated",
                    "status" => "Success",
                    "playerScore" => $playerScore
                    ]
                );
        } else {
            return response()->json(
                [
                    "message" => "Error, no such user on this competition",
                    "status" => "error",
                ]
            );
        }
    }
}
