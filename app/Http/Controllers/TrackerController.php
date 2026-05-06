<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Services\VisitLocationResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TrackerController extends Controller
{
    public function __construct(
        private readonly VisitLocationResolver $locationResolver,
    ) {
    }

    public function options(Request $request): Response
    {
        if (! $this->requestIsAllowed($request)) {
            return response('', Response::HTTP_FORBIDDEN);
        }

        return response('', Response::HTTP_NO_CONTENT)
            ->withHeaders($this->corsHeaders($request));
    }

    public function store(Request $request): JsonResponse
    {
        if (! $this->requestIsAllowed($request)) {
            return response()->json([
                'message' => 'Tracking is not allowed for this origin.',
            ], Response::HTTP_FORBIDDEN, $this->corsHeaders($request));
        }

        $validator = Validator::make($request->all(), [
            'client_id' => ['required', 'uuid'],
            'site_key' => ['required', 'string'],
            'page_url' => ['required', 'url'],
            'referrer' => ['nullable', 'url'],
            'device_type' => ['nullable', 'string', 'max:50'],
            'browser' => ['nullable', 'string', 'max:100'],
            'platform' => ['nullable', 'string', 'max:100'],
            'user_agent' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:50'],
            'screen_width' => ['nullable', 'integer', 'min:0'],
            'screen_height' => ['nullable', 'integer', 'min:0'],
            'timezone' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid tracking payload.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY, $this->corsHeaders($request));
        }

        if ($request->string('site_key')->toString() !== (string) config('tracker.site_key')) {
            return response()->json([
                'message' => 'Invalid site key.',
            ], Response::HTTP_FORBIDDEN, $this->corsHeaders($request));
        }

        $location = $this->locationResolver->resolve($request->ip());
        $pageUrl = $request->string('page_url')->toString();

        Visit::query()->create([
            'client_id' => $request->string('client_id')->toString(),
            'site_key' => $request->string('site_key')->toString(),
            'page_url' => $pageUrl,
            'page_host' => parse_url($pageUrl, PHP_URL_HOST),
            'referrer' => $request->filled('referrer') ? $request->string('referrer')->toString() : null,
            'ip' => $request->ip(),
            'country' => $location['country'],
            'city' => $location['city'],
            'device_type' => $request->string('device_type')->toString() ?: null,
            'browser' => $request->string('browser')->toString() ?: null,
            'platform' => $request->string('platform')->toString() ?: null,
            'user_agent' => $request->string('user_agent')->toString() ?: $request->userAgent(),
            'language' => $request->string('language')->toString() ?: null,
            'screen_width' => $request->integer('screen_width') ?: null,
            'screen_height' => $request->integer('screen_height') ?: null,
            'timezone' => $request->string('timezone')->toString() ?: null,
            'visited_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Visit stored.',
        ], Response::HTTP_CREATED, $this->corsHeaders($request));
    }

    private function requestIsAllowed(Request $request): bool
    {
        $origin = $request->headers->get('Origin');
        $referer = $request->headers->get('Referer');
        $pageUrl = $request->input('page_url');

        $candidates = array_filter([
            $origin,
            $referer,
            $pageUrl,
        ]);

        if ($candidates === []) {
            return false;
        }

        foreach ($candidates as $candidate) {
            if ($this->candidateIsAllowed((string) $candidate)) {
                return true;
            }
        }

        return false;
    }

    private function candidateIsAllowed(string $candidate): bool
    {
        $parts = parse_url($candidate);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = strtolower($parts['host'] ?? '');

        if ($scheme === 'file') {
            return (bool) config('tracker.allow_local_file');
        }

        if ($host === '') {
            return false;
        }

        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }

        return in_array($host, config('tracker.allowed_domains', []), true);
    }

    private function corsHeaders(Request $request): array
    {
        $origin = $request->headers->get('Origin');

        if (! $origin || ! $this->candidateIsAllowed($origin)) {
            return [];
        }

        return [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => 'POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Vary' => 'Origin',
        ];
    }
}
