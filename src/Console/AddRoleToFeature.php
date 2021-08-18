<?php

namespace CharlGottschalk\FeatureToggleLumen\Console;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddRoleToFeature extends Command
{
    protected $signature = 'feature:add:role {feature} {role}';

    protected $description = 'Add a role to the given feature';

    public function handle()
    {
        $feature = $this->argument('feature');
        $role = $this->argument('role');

        $featureRole = config('features.roles.model')::where(config('features.roles.column'), $role)->first();

        if (FeatureManager::attachRoleByName($feature, $featureRole->id)) {
            $this->info("Role ({$role}) added to feature ({$feature})");
        } else {
            $this->error("Feature ({$feature}) does not exist");
        }
    }
}
