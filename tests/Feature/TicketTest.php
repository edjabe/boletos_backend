<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetTickets()
    {
        $ticket = factory(\App\Ticket::class, 5)->create();

        $user = factory(\App\User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);

        $token = \JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('GET', '/api/tickets');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "results",
            "tickets",
        ]);
    }

    public function testNotAvalibleTickets()
    {
        $ticket = factory(\App\Ticket::class, 3)->create([
            'quantity' => 0
        ]);

        $user = factory(\App\User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);

        $token = \JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('GET', '/api/tickets');

        $response->assertStatus(200);
        $response->assertJson([
            "results" => 0,
            "tickets" => []
        ]);
        $response->assertJsonStructure([
            "results",
            "tickets",
        ]);
    }
}
