<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;

class AddFeature extends Command
{
    protected $signature = 'feature:add {feature} {enabled=true}';

    protected $description = 'Add a new feature toggle';

    public function handle()
    {
        $feature = $this->argument('feature');
        $enabled = $this->argument('enabled') == 'true';

        $feature = FeatureManager::store([
            'feature' => $feature,
            'enabled' => $enabled
        ]);

        if(empty($feature)) {
            $this->error("Error storing feature");
        } else {
            $state = $enabled ? 'enabled' : 'disabled';

            $this->info("Feature ({$feature}) created and {$state}");
        }
    }
}
