<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

class TeamUserController extends Controller
{
    /**
     * Team's all users
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Team $team)
    {
        return response()->json($team->users);
    }

    /**
     * Assign an user to a team
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Team $team, User $user)
    {
        $team->users()->attach($user);
        return response(null, 200);
    }

    /**
     * Unassign an user to a team
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function undo(Team $team, User $user)
    {
      $team->users()->detach($user);
      return response(null, 200);
    }

    /**
     * Unassign all users from a team
     * @param Team $team
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Team $team)
    {
      // When no users are specified in detach() then it will delete all existing relations
      $team->users()->detach();
      return response(null, 200);
    }
}
