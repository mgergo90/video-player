<?php

namespace Tests\Feature\PlayList;

use App\Models\User;
use App\Models\PlayList;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class UpdatePlayListTest extends ApiTestBase
{
    public function testCantChangeUserId()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $playList = factory(PlayList::class)->create([
            'user_id' => $user->id,
        ]);
        $data = [
            'data' => [
                'type' => 'play-lists',
                'attributes' => [
                    'name' => 'name',
                    'user_id' => $user->id + 1,
                ],
            ],
        ];
        $response = $this->putJsonRequest(route('play-lists.update', ['playList' => $playList->id]), $data);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testSuccessUpdatePlayList()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $playList = factory(PlayList::class)->create([
            'user_id' => $user->id,
        ]);
        $data = [
            'data' => [
                'type' => 'play-lists',
                'attributes' => [
                    'name' => 'Update name',
                    'user_id' => $user->id,
                ],
            ],
        ];
        $response = $this->putJsonRequest(route('play-lists.update', ['playList' => $playList->id]), $data);
        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonFragment([
                'attributes' => [
                    'name' => 'Update name',
                    'user_id' => $user->id,
                ],
            ]);
    }
}
