<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTimeslotStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timeslots:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all court timeslots status to available (template should not store booking status)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting all court timeslots status to available...');
        
        $count = DB::table('court_timeslots')->update(['status' => 'available']);
        
        $this->info("✓ Successfully reset {$count} timeslot(s) to available status.");
        $this->line('');
        $this->comment('Note: Booking availability is now checked from slots table based on specific dates.');
        
        return Command::SUCCESS;
    }
}
