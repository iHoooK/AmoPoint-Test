<?php

namespace Tests\Feature;

use App\Models\Joke;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_welcome_page_is_available(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_jokes_api_returns_the_latest_100_records(): void
    {
        Joke::factory()->count(101)->create();

        $response = $this->getJson('/api/jokes');

        $response
            ->assertOk()
            ->assertJsonCount(100);
    }

    public function test_the_jokes_table_page_is_available(): void
    {
        Joke::factory()->create([
            'type' => 'general',
            'setup' => 'Test setup',
            'punchline' => 'Test punchline',
        ]);

        $response = $this->get('/jokes');

        $response
            ->assertOk()
            ->assertSeeText('Сохранённые шутки')
            ->assertSeeText('Test setup');
    }

    public function test_the_fetch_random_joke_command_saves_a_record(): void
    {
        Http::fake([
            'https://official-joke-api.appspot.com/random_joke' => Http::response([
                'id' => 321,
                'type' => 'general',
                'setup' => 'Why?',
                'punchline' => 'Because.',
            ]),
        ]);

        $this->artisan('jokes:fetch-random')
            ->expectsOutput('Joke #321 was saved.')
            ->assertSuccessful();

        $this->assertDatabaseHas('jokes', [
            'external_id' => 321,
            'type' => 'general',
            'setup' => 'Why?',
            'punchline' => 'Because.',
        ]);
    }

    public function test_the_task_two_demo_page_is_available(): void
    {
        $response = $this->get('/test-task-2');

        $response
            ->assertOk()
            ->assertSeeText('Задание 2. Динамическое отображение полей')
            ->assertSeeText('Посмотреть сниппет');
    }

    public function test_the_task_two_script_can_be_downloaded(): void
    {
        $response = $this->get('/test-task-2/download');

        $response
            ->assertOk()
            ->assertHeader('content-type', 'application/javascript; charset=UTF-8')
            ->assertDownload('testlist-fields.js');
    }
}
