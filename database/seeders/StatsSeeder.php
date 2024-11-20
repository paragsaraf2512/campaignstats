<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stat;
use App\Models\Campaign;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = Campaign::all();
        $terms = Term::all();

        foreach ($campaigns as $campaign) {
            foreach ($terms as $term) {
                DB::table('stats')->insert([
                    'campaign_id' => $campaign->id,
                    'term_id' => $term->id,
                    'monetization_timestamp' => Carbon::now()->subHours(rand(1, 100)),
                    'revenue' => rand(10, 100) / 100000,
                ]);
            }
        }
    }
}
