<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Teams list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Team::all());
    }

    /**
     * Get a team with users
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Team $team)
    {
        // Join users with asked team
        $team = Team::with("users")->findOrFail($team->id);

        return response()->json($team);
    }

    /**
     * Create a team
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        // Restrict the data you require to avoid errors
        $data = $request->only("name");

        // Create team using the array of data
        $team = Team::create($data);

        // if team isset, then return team, else return error
        return ($team) ? response()->json($team) : response("cannot create model", 500);
    }

    /**
     * Update a team
     * @param Team $team
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Team $team, Request $request)
    {
        $data = $request->only("name");

        return ($team->update($data)) ? response()->json($team) : response("cannot update model", 500);
    }

    /**
     * Delete a team
     * @param Team $team
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Team $team)
    {
        return ($team->delete()) ? response(null, 200) : response("cannot delete model", 500);
    }
}
