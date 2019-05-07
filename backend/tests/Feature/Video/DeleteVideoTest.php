<?php

namespace Tests\Feature\PlayList;

use App\Models\User;
use App\Models\PlayList;
use App\Models\Video;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class DeletVideoTest extends ApiTestBase
{
    public function testDeleteSuccessfull()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $playList = factory(PlayList::class)->create([
            'user_id' => $user->id,
        ]);
        $video = factory(Video::class)->create([
            'play_list_id' => $playList->id,
        ]);

        $this->assertCount(1, PlayList::all());
        $this->assertCount(1, Video::all());
        $response = $this->deleteJsonRequest(route('videos.destroy', ['video' => $video->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertCount(1, PlayList::all());
        $this->assertCount(0, Video::all());
    }
}
