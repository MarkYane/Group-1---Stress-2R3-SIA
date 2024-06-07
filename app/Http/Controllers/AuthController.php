<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json($user, 201);
    }

    public function addToFavorites(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $title = $request->input('title');
        $action = $request->input('action');

        if (!$this->authenticate($username, $password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $type = '';
        switch ($action) {
            case 'getmovie':
                $type = 'Movie';
                break;
            case 'getbook':
                $type = 'Book';
                break;
            case 'getmusic':
                $type = 'Music';
                break;
            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }

        $favorite = Favorite::updateOrCreate(
            ['username' => $username, 'title' => $title, 'type' => $type]
        );

        return response()->json($favorite, 200);
    }

    private function authenticate($username, $password)
    {
        $user = User::where('username', $username)->first();
        return $user && password_verify($password, $user->password);
    }
}
