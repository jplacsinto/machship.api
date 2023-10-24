<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHubUserController extends Controller
{
    public function getInfoByUsername(Request $request)
    {
        $usernames = $request->input('usernames');
        $results = [];

        if (!empty($usernames)) {
            $usernames = explode(',', $usernames);

            foreach ($usernames as $username) {
                $response = Http::get("https://api.github.com/users/$username");
                if ($response->successful()) {
                    $user = $response->json();
                    $userInfo = [
                        'name' => $user['name'],
                        'login' => $user['login'],
                        'company' => $user['company'],
                        'followers' => $user['followers'],
                        'public_repos' => $user['public_repos'],
                        'average_public_repo_followers' => $user['followers'] / $user['public_repos']
                    ];
                    $results[] = $userInfo;
                } else {
                    $results[] = ['error' => 'User not found'];
                }
            }
        }

        return response()->json($results);
    }
}
