<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHubUserController extends Controller
{
    public function getInfoByUsername(Request $request): \Illuminate\Http\JsonResponse
    {
        $usernames = $request->input('usernames');
        $results = [];

        if (!empty($usernames) && is_string($usernames)) {
            $usernames = explode(',', $usernames);
            $usernames = array_unique($usernames);

            foreach ($usernames as $username) {
                try {
                    //move url to config or make constant
                    $response = Http::get("https://api.github.com/users/$username");

                    if ($response->successful()) {
                        $user = $response->json();
                        $userInfo = [
                            'name' => $user['name'],
                            'login' => $user['login'],
                            'company' => $user['company'],
                            'followers' => $user['followers'],
                            'public_repos' => $user['public_repos'],
                            'average_public_repo_followers' => $user['public_repos'] > 0 ? $user['followers'] / $user['public_repos'] : 0
                        ];
                        $results[] = $userInfo;
                    } else {
                        // Handle non-successful API response
                        // Log the error or take appropriate action
                    }
                } catch (\Exception $e) {
                    return response()->json("There was a problem fetching users");
                }
            }
        }

        $responseArr = $results;
        if(!empty($responseArr)) {
            $collection = collect($responseArr);
            $sortedCollection = $collection->sortBy('name');
            $responseArr = $sortedCollection->values()->all();
        }
        
        return response()->json($responseArr);
    }
}
