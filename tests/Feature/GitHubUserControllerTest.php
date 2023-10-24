<?php

namespace Tests\Feature;

use Tests\TestCase;

class GitHubUserControllerTest extends TestCase
{
    /**
     * Test the getInfoByUsername method.
     *
     * @return void
     */
    public function testGetInfoByUsername()
    {
        $usernames = 'username1,username2'; // Replace with your test usernames
        $response = $this->json('GET', 'api/github/user/info', ['usernames' => $usernames]);

        $response->assertStatus(200); // Assuming a successful response code

        $responseData = $response->json();
        
        // write more specific assertions based on your expected data
        $this->assertIsArray($responseData);
    }
}
