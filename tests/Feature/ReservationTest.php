<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNotAvalibleReservation()
    {
        $ticket = factory(\App\Ticket::class)->create([
            'quantity' => 0
        ]);

        $user = factory(\App\User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);

        $data = ['user_id' => $user->id, 'ticket_id' => $ticket->id];

        $token = \JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('POST', '/api/reservations/register', $data);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => 'La información recibida no es valida.',
            "errors" => [
                "ticket_id" => [
                    "The selected ticket id is invalid."
                ]
            ]
        ]);
    }

    public function testSuccessfulReservation()
    {
        $ticket = factory(\App\Ticket::class)->create([
            'quantity' => 8
        ]);

        $user = factory(\App\User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);

        $data = ['user_id' => $user->id, 'ticket_id' => $ticket->id];

        $token = \JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('POST', '/api/reservations/register', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "message",
            "reservation",
        ]);
        $response->assertJson([
            "message" => "Su boleta a sido reservada correctamente."
        ]);
    }
}
