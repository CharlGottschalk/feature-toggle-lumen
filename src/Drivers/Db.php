<?php

namespace CharlGottschalk\FeatureToggleLumen\Drivers;

use CharlGottschalk\FeatureToggleLumen\Models\Feature;
use CharlGottschalk\FeatureToggleLumen\Traits\SnakeTrait;
use CharlGottschalk\FeatureToggleLumen\Traits\UserRoleTrait;
use CharlGottschalk\FeatureToggleLumen\Transformers\Drivers\DbTransformer;

class Db implements DriverInterface
{
    use SnakeTrait, UserRoleTrait;

    protected static function getFeature($id)
    {
        return Feature::on(config('features.connection', config('database.default')))
                        ->with('roles')
                        ->find($id);
    }

    protected static function getFeatureByName($name)
    {
        $name = self::snake($name);

        return Feature::on(config('features.connection', config('database.default')))
                    ->with('roles')
                    ->where('name', $name)
                    ->first();
    }

    protected static function getRoles($feature)
    {
        $roles = config('features.roles.model')::orderBy(config('features.roles.column'))->get();

        $linkedRoles = [];
        foreach ($roles as $role) {
            $linked = false;

            if($feature->roles->contains(function ($value) use ($role) {
                return $role->id == $value->id;
            })) {
                $linked = true;
            }

            $linkedRoles[] = (object) [
                'linked' => $linked,
                'role' => $role
            ];
        }

        return $linkedRoles;
    }

    protected static function checkRoles($feature, $roles)
    {
        $featureRoles = $feature->roles->pluck(config('features.roles.column'))->toArray();

        info($featureRoles);
        info($roles);

        if (empty($roles)) {
            $roles = self::getUserRole(auth()->user());
        }

        if(is_array($roles)) {
            $roleAllowed = false;
            foreach ($featureRoles as $featureRole) {
                if(in_array($featureRole, $roles)) {
                    $roleAllowed = true;
                }
            }
            return $roleAllowed;
        } else {
            return in_array($roles, $featureRoles);
        }
    }

    public static function index($take, $page)
    {
        return Feature::on(config('features.connection', config('database.default')))
                    ->with('roles')
                    ->orderBy('name')
                    ->paginate($take, ['*'], 'page', $page);
    }

    public static function show($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return null;
        }

        return (object) [
            'feature' => $feature,
            'linkedRoles' => self::getRoles($feature)
        ];
    }

    public static function store($name, $enabled)
    {
        $name = self::snake($name);

        return Feature::on(config('features.connection', config('database.default')))
                    ->create([
                        'name' => $name,
                        'enabled' => $enabled
                    ]);
    }

    public static function update($id, $roleIds)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return null;
        }

        $feature->roles()->sync($roleIds);

        return $feature;
    }

    public static function delete($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return false;
        }

        $feature->roles()->detach();
        $feature->delete();

        return true;
    }

    public static function enable($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return null;
        }

        $feature->enable();

        return $feature;
    }

    public static function disable($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return null;
        }

        $feature->disable();

        return $feature;
    }

    public static function toggle($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return null;
        }

        $feature->toggle();

        return $feature;
    }

    public static function enabled($id)
    {
        $feature = self::getFeature($id);

        if (empty($feature)) {
            return config('features.default');
        }

        return $feature->enabled;
    }

    public static function showByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return null;
        }

        return [
            'feature' => $feature,
            'linkedRoles' => self::getRoles($feature)
        ];
    }

    public static function deleteByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return false;
        }

        $feature->roles()->detach();

        $feature->delete();

        return true;
    }

    public static function enableByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return null;
        }

        $feature->enable();

        return $feature;
    }

    public static function disableByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return null;
        }

        $feature->disable();

        return $feature;
    }

    public static function toggleByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return null;
        }

        $feature->toggle();

        return $feature;
    }

    public static function enabledByName($name)
    {
        $feature = self::getFeatureByName($name);

        if (empty($feature)) {
            return config('features.default');
        }

        return $feature->enabled;
    }

    public static function attachRole($featureId, $roleId)
    {
        $feature = self::getFeature($featureId);

        if (!empty($feature)) {
            $feature->roles()->attach($roleId);
            return true;
        }

        return false;
    }

    public static function attachRoleByName($featureName, $roleId)
    {
        $feature = self::getFeatureByName($featureName);

        if (!empty($feature)) {
            $feature->roles()->attach($roleId);
            return true;
        }

        return false;
    }

    public static function detachRole($featureId, $roleId)
    {
        $feature = self::getFeature($featureId);

        if (!empty($feature)) {
            $feature->roles()->detach($roleId);
            return true;
        }

        return false;
    }

    public static function detachRoleByName($featureName, $roleId)
    {
        $feature = self::getFeatureByName($featureName);

        if (!empty($feature)) {
            $feature->roles()->detach($roleId);
            return true;
        }

        return false;
    }

    public static function syncRoles($featureId, $roleIds)
    {
        $feature = self::getFeature($featureId);

        if (!empty($feature)) {
            $feature->roles()->sync($roleIds);
            return true;
        }

        return false;
    }

    public static function syncRolesByName($featureName, $roleIds)
    {
        $feature = self::getFeatureByName($featureName);

        if (!empty($feature)) {
            $feature->roles()->sync($roleIds);
            return true;
        }

        return false;
    }

    public static function enabledFor($id, $roles)
    {
        $feature = self::getFeature($id);

        if(empty($feature)) {
            return config('features.default');
        }

        if (!$feature->enabled) {
            return false;
        }

        return self::checkRoles($feature, $roles);
    }

    public static function enabledForByName($name, $roles)
    {
        $feature = self::getFeatureByName($name);

        if(empty($feature)) {
            return config('features.default');
        }

        if (!$feature->enabled) {
            return false;
        }

        return self::checkRoles($feature, $roles);
    }

    public static function transformer()
    {
        return new DbTransformer;
    }
}
