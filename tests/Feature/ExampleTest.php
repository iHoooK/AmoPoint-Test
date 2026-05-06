<?php

namespace Tests\Feature;

use App\Models\Joke;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_welcome_page_is_available(): void
    {
        $this->get('/')
            ->assertOk();
    }

    public function test_the_jokes_api_returns_the_latest_100_records(): void
    {
        Joke::factory()->count(101)->create();

        $this->getJson('/api/jokes')
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

        $this->get('/jokes')
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
        $this->get('/test-task-2')
            ->assertOk()
            ->assertSeeText('Задание 2. Динамическое отображение полей')
            ->assertSeeText('Посмотреть сниппет');
    }

    public function test_the_task_two_script_can_be_downloaded(): void
    {
        $this->get('/test-task-2/download')
            ->assertOk()
            ->assertHeader('content-type', 'application/javascript; charset=UTF-8')
            ->assertDownload('testlist-fields.js');
    }

    public function test_the_tracker_demo_requires_consent(): void
    {
        $this->get('/tracker/demo')
            ->assertRedirectToRoute('tracker.consent', ['redirect' => '/tracker/demo']);
    }

    public function test_the_tracker_consent_page_is_available(): void
    {
        $this->get('/tracker/consent')
            ->assertOk()
            ->assertSeeText('Согласие на обработку данных')
            ->assertSeeText('AmoPoint');
    }

    public function test_the_tracker_demo_is_available_after_consent_cookie(): void
    {
        $this->withCookie(config('tracker.consent_cookie'), 'accepted')
            ->get('/tracker/demo')
            ->assertOk()
            ->assertSeeText('Демо-страница счётчика посещений');
    }

    public function test_the_tracker_api_stores_a_visit_for_allowed_domains(): void
    {
        $clientId = (string) Str::uuid();

        $this->withHeader('Origin', 'http://localhost')
            ->post('/api/tracker/visits', [
                'client_id' => $clientId,
                'site_key' => config('tracker.site_key'),
                'page_url' => 'http://localhost/tracker/demo',
                'referrer' => 'http://localhost',
                'device_type' => 'desktop',
                'browser' => 'Chrome',
                'platform' => 'Windows',
                'user_agent' => 'Test Agent',
                'language' => 'ru-RU',
                'screen_width' => 1920,
                'screen_height' => 1080,
                'timezone' => 'Europe/Moscow',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('visits', [
            'client_id' => $clientId,
            'page_host' => 'localhost',
            'site_key' => config('tracker.site_key'),
            'city' => 'Local environment',
        ]);
    }

    public function test_the_tracker_api_rejects_unknown_domains(): void
    {
        $this->withHeader('Origin', 'https://evil.example')
            ->post('/api/tracker/visits', [
                'client_id' => (string) Str::uuid(),
                'site_key' => config('tracker.site_key'),
                'page_url' => 'https://evil.example/page',
            ])
            ->assertForbidden();
    }

    public function test_the_statistics_dashboard_requires_authentication(): void
    {
        $this->get('/admin/statistics')
            ->assertRedirectToRoute('login');
    }

    public function test_an_authenticated_user_can_open_the_statistics_dashboard(): void
    {
        Visit::factory()->count(2)->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/statistics')
            ->assertOk()
            ->assertSeeText('Статистика посещений')
            ->assertSeeText('Уникальные посещения по часам');
    }
}
