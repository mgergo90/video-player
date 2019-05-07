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
    protected $email = 'admin@example.test';

    /**
     * User password
     * @var string
     */
    protected $password = 'password';

    /**
     * Token
     * @var string
     */
    protected $loggedToken;

    /**
     * Login test user.
     * @param string $name
     * @param integer $memberId
     */
    protected function login($email = null, $password = null)
    {
        $credential = ['email' => $email ?? $this->email, 'password' => $password ?? $this->password];
        auth()->attempt($credential);
        $this->loggedToken = JWTAuth::fromUser(auth()->user());
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
