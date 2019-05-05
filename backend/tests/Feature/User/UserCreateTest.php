<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class UserApiTest extends ApiTestBase
{
    public function testCreateUser()
    {
        $userData = [
            'data' => [
                'type' => 'user',
                'attributes' => [
                    'email' => 'test@example.com',
                    'name' => 'name',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('user.store'), $userData);
        $response->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonFragment([
                'attributes' => [
                    'email' => 'test@example.com',
                    'name' => 'name',
                ]
            ]);
    }

    public function testCreateUserWithFalseData()
    {
        $userData = [
            'data' => [
                'type' => 'user',
                'attributes' => [
                    'email' => 'test@example.com',
                    'name' => 'name',
                    'name2' => 'name',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('user.store'), $userData);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }
}
