<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TestTaskController extends Controller
{
    public function taskTwo(): View
    {
        $script = file_get_contents(public_path('js/testlist-fields.js'));

        return view('test-tasks.task-two', [
            'script' => $script,
        ]);
    }

    public function downloadTaskTwoScript(): BinaryFileResponse
    {
        return response()->download(
            public_path('js/testlist-fields.js'),
            'testlist-fields.js',
            ['Content-Type' => 'application/javascript; charset=UTF-8']
        );
    }
}
