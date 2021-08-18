<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class EnableFeature extends Command
{
    protected $signature = 'feature:enable {feature}';

    protected $description = 'Enable the given feature';

    public function handle()
    {
        $feature = Str::of($this->argument('feature'))->lower()->snake();

        $featureModel = FeatureManager::enableByName($feature);

        if (!empty($featureModel)) {
            $this->info("Feature ({$feature}) enabled");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
