<?php

namespace Database\Factories;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'client_id' => (string) Str::uuid(),
            'site_key' => config('tracker.site_key', 'amopoint-demo-key'),
            'page_url' => 'http://localhost/tracker/demo',
            'page_host' => 'localhost',
            'referrer' => 'http://localhost',
            'ip' => '127.0.0.1',
            'country' => 'Local environment',
            'city' => 'Local environment',
            'device_type' => 'desktop',
            'browser' => 'Chrome',
            'platform' => 'Windows',
            'user_agent' => fake()->userAgent(),
            'language' => 'ru-RU',
            'screen_width' => 1920,
            'screen_height' => 1080,
            'timezone' => 'Europe/Moscow',
            'visited_at' => now(),
        ];
    }
}
