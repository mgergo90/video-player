<?php

namespace Tests\Feature\PlayList;

use App\Models\User;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class CreatePlayListTest extends ApiTestBase
{
    public function testCantCreatePlayListLoggedOut()
    {
        $data = [
            'data' => [
                'type' => 'play-lists',
                'attributes' => [
                    'name' => 'name',
                    'user_id' => 1,
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('play-lists.store'), $data);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function testCantCreatePlaySuccess()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $data = [
            'data' => [
                'type' => 'play-lists',
                'attributes' => [
                    'name' => 'name',
                    'user_id' => $user->id,
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('play-lists.store'), $data);
        $response->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonFragment([
                'attributes' => [
                    'name' => 'name',
                    'user_id' => $user->id,
                ]
            ]);
    }
}
