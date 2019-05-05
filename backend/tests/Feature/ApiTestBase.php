<?php

/**
 * Test APIs.
 */

namespace Tests\Feature;

use App\Models\Delegation;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class ApiTestBase extends TestCase
{
    use RefreshDatabase;

    /**
     * User email address
     * @var string
     */
    protected $email = 'admin@auction.test';
    protected $memberEmail = 'member@example.com';

    /**
     * User name
     * @var string
     */
    protected $name = 'admin';

    /**
     * User password
     * @var string
     */
    protected $password = 'secret';
    protected $loggedToken;

    protected function auth($name, $password)
    {
        $credential = ['name' => $name, 'password' => $password];
        auth()->attempt($credential);
        $this->loggedToken = JWTAuth::fromUser(auth()->user());
    }

    protected function createUser($attributes, $role, $memberAttributes = null): User
    {
        if ($memberAttributes) {
            $member = factory(Member::class)->create($memberAttributes);
            $attributes['member_id'] = $member->id;
        }
        $user = factory(User::class)->create($attributes);
        $user->assignRole($role);
        return $user;
    }

    /**
     * Login test user.
     * @param string $name
     * @param integer $memberId
     */
    protected function login($name = null, $memberId = null, $password = null)
    {
        $this->password = $password ?: $this->password;
        $this->createUser([
            'name' => $name ?: $this->name,
            'email' => $this->memberEmail,
            'password' => Hash::make($this->password),
            'active' => 1,
            'member_id' => $memberId,
        ], 'AUTHENTICATED_USER');
        $this->auth($name ?: $this->name, $this->password);
    }

    /**
     * Login admin test user.
     */
    protected function loginAdmin()
    {
        $this->createUser([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => 1,
        ], 'SYSTEM_ADMINISTRATOR');
        $this->auth($this->name, $this->password);
    }

    /**
     * Login head of delegation test user.
     */
    protected function loginDelegation($delegation = null)
    {
        $this->createUser([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'active' => 1,
            'delegation_id' => $delegation ?
                $delegation->id :
                factory(Delegation::class)->create(['member_code' => 'XX'])->id,
        ], 'HEAD_OF_DELEGATION');
        $this->auth($this->name, $this->password);
    }

    /**
     * Logout test user.
     */
    protected function logout()
    {
        auth()->logout();
    }

    /**
     * Create a json request.
     *
     * @param string $type
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function jsonRequest($type, $url, $jsonData = [], $header = [])
    {
        $header = $header + $this->getHeaderData();
        $response = $this->json(
            $type,
            $url,
            $jsonData,
            $header
        );

        // If response with content.
        if ($response->getStatusCode() != Response::HTTP_NO_CONTENT) {
            $this->assertValidJsonResponse($response->content());
        }
        return $response;
    }

    /**
     * Create a json post request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function postJsonRequest($url, $jsonData, $header = [])
    {
        return $this->jsonRequest('POST', $url, $jsonData, $header);
    }

    /**
     * Create a json put request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function putJsonRequest($url, $jsonData, $header = [])
    {
        return $this->jsonRequest('PUT', $url, $jsonData, $header);
    }

    /**
     * Create a json put request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function getJsonRequest($url, $jsonData = [], $header = [])
    {
        return $this->jsonRequest('GET', $url, $jsonData, $header);
    }

    /**
     * Create a json delete request.
     *
     * @param string $url
     * @param array $jsonData
     * @param array $header
     */
    protected function deleteJsonRequest($url, $jsonData = [], $header = [])
    {
        return $this->jsonRequest('DELETE', $url, $jsonData, $header);
    }

    /**
     * Get default header data.
     *
     * @return array
     */
    protected function getHeaderData()
    {
        $header = [
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
        ];
        if (!empty($this->loggedToken)) {
            $header['Authorization'] = 'Bearer ' . $this->loggedToken;
        }

        return $header;
    }

    /**
     * Upload a fake file.
     *
     * @param string $visibility
     * @return \App\Models\File\File
     */
    protected function getFakeUploadedFile($visibility = 'public')
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $type = explode('/', $file->getClientMimeType())[0];
        return factory(\App\Models\File\File::class)->create(
            [
                'name' => $file->getClientOriginalName(),
                'type' => $type,
                'path' => $file->store($type, $visibility),
                'visibility' => $visibility,
            ]
        );
    }
}
