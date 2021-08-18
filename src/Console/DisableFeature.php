<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DisableFeature extends Command
{
    protected $signature = 'feature:disable {feature}';

    protected $description = 'Disable the given feature';

    public function handle()
    {
        $feature = $this->argument('feature');

        $featureModel = FeatureManager::disableByName($feature);

        if (!empty($featureModel)) {
            $this->info("Feature ({$feature}) disabled");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
