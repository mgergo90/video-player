<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\Feature\ApiTestBase;
use Illuminate\Http\JsonResponse;
use JWTAuth;

class UserLoginTest extends ApiTestBase
{
    public function testLoginUser()
    {
        $user = factory(User::class)->create();
        $response = $this->postJsonRequest(route('auth.login'), [
            'data' => [
                'attributes' => [
                    'email' => $user->email,
                    'password' => 'password',
                ],
            ],
        ]);
        $response->assertSuccessful();
        $this->assertAuthenticatedAs($user);
    }
}
