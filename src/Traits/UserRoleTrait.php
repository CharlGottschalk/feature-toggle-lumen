<?php

namespace CharlGottschalk\FeatureToggleLumen\Traits;

use Illuminate\Support\Str;

trait UserRoleTrait
{
    public static function getUserRole($user)
    {
        if (empty($user)) {
            return null;
        }

        $roleProp = config('features.roles.property');

        if (property_exists($user, $roleProp)) {
            $roleValue = $user->$roleProp;
        } elseif (method_exists($user, $roleProp)) {
            $roleValue = $user->$roleProp();
        } else {
            $roleValue = null;
        }

        return $roleValue;
    }
}
