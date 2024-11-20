<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Term;
use App\Models\Stat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stats {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stats from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');

        // Ensure the file exists in the storage path
        $filePath = storage_path($filename);
        if (!file_exists($filePath)) {
            $this->error("File {$filename} not found.");
            return 1;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        // Use the first row as headers
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        // Number of rows to process at a time
        $chunkSize = 5000;
        $recordChunks = collect(iterator_to_array($records))->chunk($chunkSize);

        foreach ($recordChunks as $chunk) {
            DB::transaction(function () use ($chunk) {
                $stats = [];
                foreach ($chunk as $record) {
                    // Validate the row
                    if (
                        empty($record['utm_campaign']) 
                        || empty($record['utm_term']) 
                        || ($record['utm_campaign'] === 'NULL') 
                        || ($record['utm_term'] === 'NULL')
                    ) {
                        continue;
                    }

                    // Insert or find the campaign
                    $campaign = Campaign::firstOrCreate(
                        ['utm_campaign' => $record['utm_campaign']],
                        [
                            'utm_campaign' => $record['utm_campaign'],
                            'name' => 'Campaign: ' . $record['utm_campaign'],
                        ]
                    );

                    // Insert or find the term
                    $term = Term::firstOrCreate(
                        ['utm_term' => $record['utm_term']],
                        [
                            'utm_term' => $record['utm_term'],
                            'name' => 'Term: ' . $record['utm_term'],
                        ]
                    );

                    $now = now();
                    $stats[] = [
                        'campaign_id' => $campaign->id,
                        'term_id' => $term->id,
                        'monetization_timestamp' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record['monetization_timestamp']),
                        'revenue' => (float)$record['revenue'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                // Bulk insert for the chunk
                Stat::insert($stats);
            });

            $this->info("Processed chunk of {$chunkSize} records.");
        }

        $this->info('Import completed successfully.');
        return 0;
    }
}
