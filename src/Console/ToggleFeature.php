<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ToggleFeature extends Command
{
    protected $signature = 'feature:toggle {feature}';

    protected $description = 'Toggle the given feature';

    public function handle()
    {
        $feature = Str::of($this->argument('feature'))->lower()->snake();

        $featureModel = FeatureManager::toggleByName($feature);

        if (!empty($featureModel)) {
            $state = $featureModel->enabled ? 'enabled' : 'disabled';
            $this->info("Feature ({$feature}) {$state}");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
