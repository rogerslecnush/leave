<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamAssignTest extends TestCase
{
    use DatabaseTransactions;

    protected $teams;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        // Create 3 teams with 3 users each, also created in DB
        $this->teams = factory(\App\Team::class, 3)->create()
            ->each(function ($t) {
                $t->users()->saveMany(factory(\App\User::class, 3)->create());
            }
        );
        $this->user = factory(\App\User::class)->create();
    }

    /**
     * Check the members are correctly inserted in GET
     *
     * @test
     * @return void
     */
    public function get_team_contains_members()
    {
        $this->assertTrue(true);
    }

    /**
     * Get a team (with users)
     *
     * @test
     * @return void
     */
    public function get_a_team()
    {
        $response = $this->call("GET", "api/teams/" . $this->teams->first()->id);
        $response->assertSuccessful();
        $response->assertJsonFragment(["users"]);
        $response->assertJsonCount(3, "users");
    }

    /**
     * Assign an User to a team
     *
     * @test
     * @return void
     */
    public function assigns_a_member_to_a_team()
    {
        $response = $this->call("GET", "api/teams/" . $this->teams->first()->id . "/users/" . $this->user->id);

        $response->assertSuccessful();
        $this->assertDatabaseHas("team_user", ["user_id" => $this->user->id, "team_id" => $this->teams->first()->id]);
    }

    public function unassign_a_member_to_a_team()
    {
        $response = $this->call("GET", "api/teams/" . $this->teams->first()->id . "/users/" . $this->user->id);
        $response = $this->delete("api/teams/" . $this->teams->first()->id . "/users/" . $this->user->id);

        $response->assertSuccessful();
        $this->assertDatabaseMissing("team_user", ["user_id" => $this->user->id, "team_id" => $this->teams->first()->id]);
    }

    /**
     * Reset team members
     *
     * @test
     * @return void
     */
    public function reset_team_members()
    {
        $response = $this->delete("api/teams/" . $this->teams->first()->id . "/users");

        $response->assertSuccessful();
        $this->assertDatabaseMissing("team_user", ["team_id" => $this->teams->first()->id]);
    }
}
