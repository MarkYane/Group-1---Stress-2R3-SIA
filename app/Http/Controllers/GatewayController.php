<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;
use App\Services\BookService;
use App\Services\MusicService;
use App\Models\User;
use App\Models\Favorite;

class GatewayController extends Controller
{
    protected $movieService;
    protected $bookService;
    protected $musicService;

    public function __construct(MovieService $movieService, BookService $bookService, MusicService $musicService)
    {
        $this->movieService = $movieService;
        $this->bookService = $bookService;
        $this->musicService = $musicService;
    }

    public function handleRequest(Request $request)
    {
        $action = $request->input('action');
        $username = $request->input('username');
        $password = $request->input('password');

        if (!$this->authenticate($username, $password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $title = $request->input('title');

        switch ($action) {
            case 'getmovie':
                $result = $this->movieService->search($title);
                break;
            case 'getbook':
                $result = $this->bookService->search($title);
                break;
            case 'getmusic':
                $result = $this->musicService->search($title);
                break;
            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }

        if ($request->input('add_to_favorites') === 'yes') {
            $this->addToFavorites($username, $action, $title);
        }

        return response()->json($result);
    }

    private function authenticate($username, $password)
    {
        $user = User::where('username', $username)->first();
        return $user && password_verify($password, $user->password);
    }

    // app/Http/Controllers/GatewayController.php

    private function addToFavorites($username, $action, $title)
    {
        $type = '';

        // Determine the type based on the action
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
                return;
        }

        // Store the favorite
        Favorite::create([
            'username' => $username,
            'title' => $title,
            'type' => $type,
        ]);
    }

    public function removeFavorite(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $type = $request->input('type');
        $title = $request->input('title');

        // Authenticate the user
        if (!$this->authenticate($username, $password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $favorite = Favorite::where('username', $username)
            ->where('type', $type)
            ->where('title', $title)
            ->first();

        if (!$favorite) {
            return response()->json(['error' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Favorite removed successfully'], 200);
    }

}
