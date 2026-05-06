<?php

namespace App\Console\Commands;

use App\Services\AlertsService;
use Illuminate\Console\Command;

class CheckAcademicAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for academic alerts and send notifications to students and parents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for academic alerts...');

        try {
            $alerts = AlertsService::checkAndNotifyAlerts();

            $this->info('Process completed successfully!');
            $this->line('');
            $this->line("Total alerts triggered: " . count($alerts));

            foreach ($alerts as $alert) {
                $this->line("  - {$alert['type']}: {$alert['message']}");
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error checking alerts: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
