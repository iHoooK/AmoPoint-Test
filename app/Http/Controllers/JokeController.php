<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JokeController extends Controller
{
    public function index(): JsonResponse
    {
        $jokes = Joke::query()
            ->latest()
            ->limit(100)
            ->get();

        return response()->json($jokes);
    }

    public function table(Request $request): View
    {
        $allowedSorts = ['id', 'external_id', 'type'];
        $sort = $request->string('sort')->toString();
        $direction = $request->string('direction')->toString();

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $jokes = Joke::query()
            ->orderBy($sort, $direction)
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('jokes.index', compact('jokes', 'sort', 'direction'));
    }
}
