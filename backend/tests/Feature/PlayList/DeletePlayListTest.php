<?php

namespace Tests\Feature\PlayList;

use App\Models\User;
use App\Models\PlayList;
use App\Models\Video;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class DeletePlayListTest extends ApiTestBase
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
        $this->assertCount(1, PlayList::all());
        $response = $this->deleteJsonRequest(route('play-lists.destroy', ['playList' => $playList->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertCount(0, PlayList::all());
    }

    public function testOnlyOwnPlayListCanBeDestroyed()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $playList = factory(PlayList::class)->create();
        $this->assertCount(1, PlayList::all());
        $response = $this->deleteJsonRequest(route('play-lists.destroy', ['playList' => $playList->id]));
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
        $this->assertCount(1, PlayList::all());
    }

    public function testDeleteSuccessfullRemovesVideos()
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
        $response = $this->deleteJsonRequest(route('play-lists.destroy', ['playList' => $playList->id]));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $this->assertCount(0, PlayList::all());
        $this->assertCount(0, Video::all());
    }
}
