<?php

namespace App\Console\Commands;

use App\Models\Joke;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class FetchRandomJokeCommand extends Command
{
    protected $signature = 'jokes:fetch-random';

    protected $description = 'Fetch a random joke from the external API and store it in the database';

    public function handle(): int
    {
        try {
            $response = Http::baseUrl(config('services.official_joke_api.base_url'))
                ->withOptions([
                    'verify' => filter_var(config('services.official_joke_api.verify'), FILTER_VALIDATE_BOOL),
                ])
                ->timeout(10)
                ->acceptJson()
                ->get('/random_joke');
        } catch (ConnectionException $exception) {
            $this->error('Failed to connect to the external API.');
            $this->newLine();
            $this->line($exception->getMessage());
            $this->newLine();
            $this->warn('If this is a local Windows SSL certificate issue, set OFFICIAL_JOKE_API_VERIFY=false in your .env file.');

            return self::FAILURE;
        }

        if ($response->failed()) {
            $this->error('Failed to fetch a joke from the external API.');

            return self::FAILURE;
        }

        $payload = $response->json();

        Joke::query()->create([
            'external_id' => $payload['id'],
            'type' => $payload['type'],
            'setup' => $payload['setup'],
            'punchline' => $payload['punchline'],
        ]);

        $this->info(sprintf('Joke #%s was saved.', $payload['id']));

        return self::SUCCESS;
    }
}
