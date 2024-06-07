<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;

class FavoritesController extends Controller
{
    public function getFavorites(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Authenticate the user
        if (!$this->authenticate($username, $password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get all favorites for the authenticated user
        $favorites = Favorite::where('username', $username)->get();

        if ($favorites->isEmpty()) {
            return response()->json(['error' => 'No favorites found'], 404);
        } else {
            return response()->json($favorites);
        }
    }

    private function authenticate($username, $password)
    {
        $user = User::where('username', $username)->first();
        return $user && password_verify($password, $user->password);
    }
}
