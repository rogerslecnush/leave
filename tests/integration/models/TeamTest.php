<?php

namespace Tests\Feature;

use App\Team;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Will run before tests.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $team = Team::create(['name' => 'Twimm']);
    }

    /**
     * Check slug field.
     *
     * @test
     *
     * @return void
     */
    public function it_has_a_slug()
    {
        $this->assertDatabaseHas('teams', ['name' => 'Twimm', 'slug' => 'twimm']);
    }
}
