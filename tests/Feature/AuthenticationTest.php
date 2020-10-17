<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                "message" => "La información recibida no es valida.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "last_name" => ["The last name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => "John",
            "last_name" => "Doe",
            "email" => "doe@example.com",
            "password" => "psicol2020"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                "message" => "La información recibida no es valida.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John",
            "last_name" => "Doe",
            "email" => "doe@example.com",
            "password" => "psicol2020",
            "password_confirmation" => "psicol2020"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "user" => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                "message"
            ]);
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "La información recibida no es valida.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = factory(User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);


        $loginData = ['email' => 'prueba@nuevaprueba.com', 'password' => 'psicol2020'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
               "user" => [
                   'id',
                   'name',
                   'email',
                   'email_verified_at',
                   'created_at',
                   'updated_at',
               ],
                "access_token",
                "token_type",
                "expires_in"
            ]);

        $this->assertAuthenticated();
    }

    public function testFailedLogin()
    {
        $user = factory(User::class)->create([
           'email' => 'prueba@nuevaprueba.com',
           'password' => bcrypt('psicol2020'),
        ]);


        $loginData = ['email' => 'prueba@nuevaprueba.com', 'password' => 'psicol2021'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "error" => "No autorizado."
            ]);
    }
}
