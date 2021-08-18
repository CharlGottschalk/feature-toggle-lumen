<?php

namespace CharlGottschalk\FeatureToggleLumen\Transformers;

class FeatureTransformer {

    public static function transformMany($results) {
        $return = [];

        foreach ($results as $result) {
            $return[] = self::transformSingle($result);
        }

        return $return;
    }

    public static function transformSingle($result) {
        if(!empty($result->feature)) {
            return (object) [
                'id' => $result->feature->id,
                'name' => $result->feature->name,
                'enabled' => $result->feature->enabled,
                'roles' => self::transformRoles($result->linkedRoles ?? [], true)
            ];
        }

        return (object) [
            'id' => $result->id,
            'name' => $result->name,
            'enabled' => $result->enabled,
            'roles' => self::transformRoles($result->roles)
        ];
    }

    protected static function transformRoles($roles, $linked = false) {
        $return = [];

        $column = config('features.roles.column');

        foreach ($roles as $role) {
            if ($linked) {
                $return[] = (object) [
                    'linked' => empty($role->linked) ? false : $role->linked,
                    'name' => $role->role->$column,
                    'id' => $role->role->id
                ];
            } else {
                $return[] = (object) [
                    'linked' => empty($role->linked) ? false : $role->linked,
                    'name' => $role->$column,
                    'id' => $role->id
                ];
            }
        }

        return $return;
    }
}
