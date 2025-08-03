<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class UpdateBusinessTransliterations extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'business:update-transliterations {--force : Force update even if transliterations exist}';

    /**
     * The console command description.
     */
    protected $description = 'Update transliterations for all existing businesses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $this->info('Starting transliteration update for businesses...');
        
        $businesses = Business::all();
        $updated = 0;
        $skipped = 0;
        
        foreach ($businesses as $business) {
            $needsUpdate = $force || 
                           empty($business->owner_first_name_cyrillic) || 
                           empty($business->owner_last_name_cyrillic) ||
                           empty($business->business_name_cyrillic) ||
                           empty($business->description_cyrillic);
            
            if ($needsUpdate) {
                $this->line("Updating: {$business->business_name} (ID: {$business->id})");
                
                // Generate transliterations
                $business->generateTransliterations();
                $business->save();
                
                $updated++;
            } else {
                $skipped++;
            }
        }
        
        $this->info("Transliteration update completed!");
        $this->info("Updated: {$updated} businesses");
        $this->info("Skipped: {$skipped} businesses");
        
        if ($skipped > 0 && !$force) {
            $this->info("Use --force option to update all businesses regardless of existing transliterations");
        }
        
        return 0;
    }
}