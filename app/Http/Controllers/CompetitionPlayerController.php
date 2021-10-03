<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CompetitionPlayerController extends Controller
{
    public function store(Competition $competition, Request $request)
    {
        // verify the competition and the player limit
        $playerLimit = $competition->player_limit;
        $playerJoinedCompetition = $competition->players()->count();

        if($playerJoinedCompetition < $playerLimit) {
            // player can join the competition

            // verify the provided player's input
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

            //  if validation does not pass
            if ($validation->fails()) {
                $errors = $validation->errors();

                return $errors->toJson();
            }else{

                // if validation pass
                $player = Player::create([
                    'name' => $request->input('name'),
                ]);

                $competition->players()->syncWithoutDetaching([$player->id]);
            }

            return response()->json(
                [
                    "message" => "Success, player joined this competition",
                    "status" => "Success",
                    "player" => $player
                ]
            );

        } else {
            // player cannot join the competition
            return response()->json(
                [
                    "message" => "Player limit reached",
                    "status" => "error"
                ]
            );
        }
    }
}
