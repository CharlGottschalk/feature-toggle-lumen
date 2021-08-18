<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RemoveRoleFromFeature extends Command
{
    protected $signature = 'feature:remove:role {feature} {role}';

    protected $description = 'Remove a role to the given feature';

    public function handle()
    {
        $feature = Str::of($this->argument('feature'))->lower()->snake();
        $role = $this->argument('role');

        $featureRole = config('features.roles.model')::where(config('features.roles.column'), $role)->first();

        if (FeatureManager::detachRoleByName($feature, $featureRole->id)) {
            $this->info("Role ({$role}) removed from feature ({$feature})");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
