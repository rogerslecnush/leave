<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamApiTest extends TestCase
{
    use DatabaseTransactions;

    protected $team;
    protected $teamCount;

    public function setUp()
    {
        parent::setUp();

        // Since we are doing this on our current database, take into account existing objects
        $this->teamCount = \App\Team::all()->count();

        // Create tests data
        factory(\App\Team::class, 2)->create();
        $this->team = factory(\App\Team::class)->create();
    }

    /**
     * List the teams
     *
     * @test
     * @return void
     */
    public function get_all_teams()
    {
        $response = $this->call("GET", "api/teams");
        $response->assertSuccessful();
        $response->assertJsonCount($this->teamCount + 3, null);
    }

    /**
     * Get a team (with users)
     *
     * @test
     */
    public function get_a_team()
    {
        $response = $this->call("GET", "api/teams/" . $this->team->id);
        $response->assertSuccessful();
        $response->assertJsonFragment(["name"]);
        $response->assertJsonFragment(["slug"]);
        $response->assertJsonFragment(["users"]);
    }

    /**
     * Store a team
     *
     * @test
     */
    public function store_a_team()
    {
        $response = $this->post("api/teams", ["name" => "Twimm"]);

        // Returns created object
        $response->assertSuccessful();
        $response->assertJsonFragment(["name"]);
        $response->assertJsonFragment(["slug"]);

        // Saves object
        $this->assertDatabaseHas("teams", ["name" => "Twimm"]);
    }

    /**
     * Update a team
     *
     * @test
     */
    public function update_a_team()
    {
        $response = $this->patch("api/teams/" . $this->team->id, ["name" => "Twimm"]);

        $response->assertSuccessful();
        $response->assertJsonFragment(["name"]);
        $response->assertJsonFragment(["slug"]);
    }

    /**
     * SoftDelete a team
     *
     * @test
     */
    public function delete_a_team()
    {
        $response = $this->delete("api/teams/" . $this->team->id);

        $response->assertSuccessful();

        $this->assertSoftDeleted("teams", ["id" => $this->team->id]);
    }
}
