<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Competition;
use App\Models\CompetitionPlayer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CompetitionPlayerController extends Controller
{
    public function store(Competition $competition, Request $request)
    {
        // verify the competition and the player limit
        if($competition->players()->count() >= $competition->player_limit) {
            // player cannot join the competition
            return response()->json(
                [
                    "message" => "Player limit reached",
                    "status" => "error"
                ]
            );
        }

        // verify player's name
        $validation = Validator::make($request->all(),[
            'name' => [
                'required',
                'max:255',
                Rule::unique('players', 'name')
                    ->where(static function ($query) use($competition) {
                        return $query->whereIn('id', $competition->players->pluck('id'));
                    })
            ]
        ]);

        //  if validation fails
        if ($validation->fails()) {
            $errors = $validation->errors();

            return response()->json(
                [
                    "errors" => $errors,
                    "message" => "Error, player validation fails",
                    "status" => "success"
                ]
            );

        }

        // create player + sync with competition
        $player = $competition->players()->create($request->input());

        return response()->json(
            [
                "message" => "Success, player joined this competition",
                "status" => "success",
                "player" => $player
            ]
        );
    }

    public function increment(Competition $competition, Player $player, Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|exists:players',
        ]);

        //  if validation fails
        if ($validation->fails()) {
            $errors = $validation->errors();

            return response()->json([
                "errors" => $errors,
                "message" => "Error, validation fails",
                "status" => "error"
            ]);
        }

        // verify if player is on this competition
        if($player->competitions()->where('id', $competition->id)->doesntExist()) {
            // no player on this competition
            return response()->json(
                [
                    "message" => "Error, no such user on this competition",
                    "status" => "error",
                ]
            );
        }

        // increment player's score
        $playerScore = $competition->players()->where('id', $player->id)->first()->pivot->increment('player_score', 1);

        return response()->json(
            [
                "message" => "Success, player's score points is updated",
                "status" => "success",
                "playerScore" => $playerScore
                ]
            );
    }

}
