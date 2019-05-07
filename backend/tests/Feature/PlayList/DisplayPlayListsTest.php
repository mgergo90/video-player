<?php

namespace Tests\Feature\PlayList;

use App\Models\User;
use App\Models\PlayList;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;

class DisplayPlayListTest extends ApiTestBase
{

    public function testListPlayLists()
    {
        $user = factory(User::class)->create([
            'email' => $this->email,
        ]);
        $this->login();
        $numberOfPlayLists = 5;
        factory(PlayList::class, $numberOfPlayLists)->create();

        $response = $this->getJsonRequest(route('play-lists.index'));
        $response->assertStatus(JsonResponse::HTTP_OK);
        $jsonArray = $response->decodeResponseJson();
        $this->assertCount($numberOfPlayLists, $jsonArray['data']);
    }

    public function testOnlyLoggedInUserCAnList()
    {
        $numberOfPlayLists = 5;
        factory(PlayList::class, $numberOfPlayLists)->create();

        $response = $this->getJsonRequest(route('play-lists.index'));
        $response->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
