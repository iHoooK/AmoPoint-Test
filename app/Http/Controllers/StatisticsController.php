<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request): View
    {
        $start = now()->subHours(23)->startOfHour();
        $end = now()->endOfHour();

        $visits = Visit::query()
            ->whereBetween('visited_at', [$start, $end])
            ->orderBy('visited_at')
            ->get(['client_id', 'city', 'visited_at']);

        $hourlyLabels = collect(range(0, 23))
            ->map(fn (int $offset): Carbon => $start->copy()->addHours($offset));

        $hourlyStats = $hourlyLabels->map(function (Carbon $hour) use ($visits): int {
            return $visits
                ->filter(fn (Visit $visit): bool => $visit->visited_at->copy()->startOfHour()->equalTo($hour))
                ->pluck('client_id')
                ->unique()
                ->count();
        });

        $cityStats = Visit::query()
            ->get(['client_id', 'city'])
            ->groupBy(fn (Visit $visit): string => $visit->city ?: 'Unknown')
            ->map(fn ($group): int => $group->pluck('client_id')->unique()->count())
            ->sortDesc()
            ->take(10);

        $baseUrl = $request->getSchemeAndHttpHost();

        $trackerSnippet = implode("\n", [
            '<script',
            '    src="'.$baseUrl.'/js/visit-tracker.js"',
            '    data-endpoint="'.$baseUrl.'/api/tracker/visits"',
            '    data-site-key="'.config('tracker.site_key').'"',
            '></script>',
        ]);

        return view('admin.statistics', [
            'hourlyLabels' => $hourlyLabels->map(fn (Carbon $hour): string => $hour->format('H:00'))->values(),
            'hourlyStats' => $hourlyStats->values(),
            'cityLabels' => $cityStats->keys()->values(),
            'cityStats' => $cityStats->values(),
            'totalVisits' => Visit::query()->count(),
            'uniqueClients' => Visit::query()->distinct('client_id')->count('client_id'),
            'latestVisit' => Visit::query()->latest('visited_at')->value('visited_at'),
            'trackerSnippet' => $trackerSnippet,
        ]);
    }
}
