<?php

namespace CharlGottschalk\FeatureToggleLumen;

use CharlGottschalk\FeatureToggleLumen\Drivers\Db;
use CharlGottschalk\FeatureToggleLumen\Transformers\Transformer;

class FeatureManager
{
    public static function index($take, $page)
    {
        $results = Db::index($take, $page);
        return Transformer::transformResults($results);
    }

    public static function show($id)
    {
        $feature = Db::show($id);
        return Transformer::transformFeature($feature);
    }

    public static function store($name, $enabled)
    {
        $feature = Db::store($name, $enabled);
        return Transformer::transformFeature($feature);
    }

    public static function update($id, $roleIds)
    {
        $feature = Db::update($id, $roleIds);
        return Transformer::transformFeature($feature);
    }

    public static function delete($id)
    {
        return Db::delete($id);
    }

    public static function enable($id)
    {
        $feature = Db::enable($id);
        return Transformer::transformFeature($feature);
    }

    public static function disable($id)
    {
        $feature = Db::disable($id);
        return Transformer::transformFeature($feature);
    }

    public static function toggle($id)
    {
        $feature = Db::toggle($id);
        return Transformer::transformFeature($feature);
    }

    public static function showByName($name)
    {
        $feature = Db::showByName($name);
        return Transformer::transformFeature($feature);
    }

    public static function deleteByName($name)
    {
        return Db::deleteByName($name);
    }

    public static function enableByName($name)
    {
        $feature = Db::enableByName($name);
        return Transformer::transformFeature($feature);
    }

    public static function disableByName($name)
    {
        $feature = Db::disableByName($name);
        return Transformer::transformFeature($feature);
    }

    public static function toggleByName($name)
    {
        $feature = Db::toggleByName($name);
        return Transformer::transformFeature($feature);
    }

    public static function attachRole($featureId, $roleId)
    {
        $feature = Db::attachRole($featureId, $roleId);
        return Transformer::transformFeature($feature);
    }

    public static function attachRoleByName($featureName, $roleId)
    {
        $feature = Db::attachRoleByName($featureName, $roleId);
        return Transformer::transformFeature($feature);
    }

    public static function detachRole($featureId, $roleId)
    {
        $feature = Db::detachRole($featureId, $roleId);
        return Transformer::transformFeature($feature);
    }

    public static function detachRoleByName($featureName, $roleId)
    {
        $feature = Db::detachRoleByName($featureName, $roleId);
        return Transformer::transformFeature($feature);
    }

    public static function syncRoles($featureId, $roleIds)
    {
        $feature = Db::syncRoles($featureId, $roleIds);
        return Transformer::transformFeature($feature);
    }

    public static function syncRolesByName($featureName, $roleIds)
    {
        $feature = Db::syncRolesByName($featureName, $roleIds);
        return Transformer::transformFeature($feature);
    }
}