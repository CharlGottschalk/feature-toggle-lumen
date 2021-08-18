<?php

namespace CharlGottschalk\FeatureToggleLumen\Drivers;

interface DriverInterface
{
    public static function rules();
    public static function transformer();
    public static function index($take, $page);
    public static function show($id);
    public static function showByName($name);
    public static function store($name, $enabled);
    public static function update($id, $roleIds);
    public static function delete($id);
    public static function deleteByName($name);
    public static function enable($id);
    public static function enableByName($name);
    public static function disable($id);
    public static function disableByName($name);
    public static function toggle($id);
    public static function toggleByName($name);
    public static function enabled($id);
    public static function enabledByName($name);
    public static function enabledFor($id, $roles);
    public static function enabledForByName($name, $roles);
    public static function attachRole($featureId, $roleId);
    public static function attachRoleByName($featureName, $roleId);
    public static function detachRole($featureId, $roleId);
    public static function detachRoleByName($featureName, $roleId);
    public static function syncRoles($featureId, $roleIds);
    public static function syncRolesByName($featureName, $rolesIds);
}
