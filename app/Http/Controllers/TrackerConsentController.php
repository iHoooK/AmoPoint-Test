<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackerConsentController extends Controller
{
    public function show(Request $request): View
    {
        $redirect = $request->query('redirect', route('tracker.demo'));

        return view('tracker.consent', [
            'redirect' => $redirect,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'accepted' => ['accepted'],
            'redirect' => ['required', 'string'],
        ]);

        $redirect = $validated['redirect'];

        if (! str_starts_with($redirect, '/')) {
            $redirect = route('tracker.demo');
        }

        return redirect($redirect)->cookie(
            (string) config('tracker.consent_cookie'),
            'accepted',
            60 * 24 * 30,
        );
    }
}
