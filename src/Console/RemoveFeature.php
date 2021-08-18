<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RemoveFeature extends Command
{
    protected $signature = 'feature:remove {feature}';

    protected $description = 'Remove the given feature';

    public function handle()
    {
        $feature = Str::of($this->argument('feature'))->lower()->snake();

        if (FeatureManager::deleteByName($feature)) {
            $this->info("Feature ({$feature}) and associated roles removed");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
