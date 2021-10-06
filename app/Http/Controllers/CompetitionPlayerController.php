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
        // verify the competition limit
        $competition->canTakeMorePlayers();

        // verify player's name
        $validation = Validator::make($request->all(), [
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
            return response()->json([
                "errors" => $validation->errors(),
                "message" => "Validation errors",
                "status" => "error"
            ]);
        }

        // create player + sync with competition
        $player = $competition->players()->create($request->input());

        return response()->json([
            "message" => "Player joined",
            "status" => "success",
            "player" => $player
        ]);
    }

    public function increment(Competition $competition, Player $player, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|exists:players',
        ]);

        //  if validation fails
        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors(),
                "message" => "Validation error",
                "status" => "error"
            ]);
        }

        // verify if player is on this competition
        $competition->hasPlayer($player);

        // increment player's score
        $playerScore = $player->incrementScore($competition);

        return response()->json([
            "message" => "Player score incremented",
            "status" => "success",
            "playerScore" => $playerScore
        ]);
    }
}
