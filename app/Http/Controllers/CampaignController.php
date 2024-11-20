<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CampaignController extends Controller
{
    /**
     * Display list of campaigns and aggregate revenue for each campaign
     */
    public function index()
    {
        // Fetch campaigns with aggregated revenue, 20 campaigns per page
        $campaigns = Campaign::withSum('stats as total_revenue', 'revenue')
            ->paginate(20);

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Display a specific campaign with a hourly breakdown of all revenue
     */
    public function show(Campaign $campaign)
    {
        // Fetch hourly revenue breakdown for the campaign
        $stats = Stat::select(
                DB::raw('DATE(monetization_timestamp) as date'),
                DB::raw('HOUR(monetization_timestamp) as hour'),
                DB::raw('SUM(revenue) as total_revenue')
            )
            ->where('campaign_id', $campaign->id)
            ->groupBy('date', 'hour')
            ->orderBy('date')
            ->orderBy('hour')
            ->paginate(20);

        return view('campaigns.show', compact('campaign', 'stats'));
    }

    /**
     * Display a specific campaign with the aggregate revenue by utm_term
     */
    public function publishers(Campaign $campaign)
    {
        // Fetch revenue grouped by utm_term for the campaign
        $terms = Stat::select('terms.name', 'terms.utm_term', DB::raw('SUM(stats.revenue) as total_revenue'))
            ->join('terms', 'stats.term_id', '=', 'terms.id')
            ->where('stats.campaign_id', $campaign->id)
            ->groupBy('terms.name', 'terms.utm_term')
            ->orderBy('total_revenue', 'desc')
            ->paginate(20);

        return view('campaigns.publishers', compact('campaign', 'terms'));
    }
}
