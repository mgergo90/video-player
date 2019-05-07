<?php

namespace Tests\Feature\Video;

use App\Models\User;
use App\Models\PlayList;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class CreateVideoTest extends ApiTestBase
{
    public function testCantAddVideoLoggedOut()
    {
        $data = [
            'data' => [
                'type' => 'video',
                'attributes' => [
                    'video_id' => 'name',
                    'play_list_id' => 1,
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('videos.store'), $data);
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    public function testCanAddVideoToPlayList()
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
                'type' => 'video',
                'attributes' => [
                    'video_id' => 'name',
                    'play_list_id' => $playList->id,
                ],
            ],
        ];
        $response = $this->postJsonRequest(route('videos.store'), $data);
        $response->assertStatus(JsonResponse::HTTP_CREATED);
    }
}
