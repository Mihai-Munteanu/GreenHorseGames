<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Jsonable;

class CompetitionController extends Controller
{
    public function store(Request $request)
    {
        // validate the input
        $validation = Validator::make($request->all(),[
            'name' => 'required|unique:competitions|max:255',
            'player_limit' => 'required|numeric|max:100',
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

        // create competition
        $competition = Competition::create($request->input());

        return response()->json(
            [
                "message" => "Success, the competitions was created!",
                "status" => "success",
                "competition" => $competition
            ]
        );
    }

    public function show(Competition $competition)
    {
        // get all players within this competition, paginated by two per page
        $playersOnCompetition = $competition->players()->orderByDesc('player_score')->paginate(2);

        return response()->json(
            [
                "playersOnCompetition" => $playersOnCompetition,
                "message" => "Show all players from this competition",
                "status" => "success"
            ]
        );
    }
}
