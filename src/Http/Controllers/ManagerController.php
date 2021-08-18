<?php

namespace CharlGottschalk\FeatureToggleLumen\Http\Controllers;

use CharlGottschalk\FeatureToggleLumen\FeatureManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerController extends BaseController
{
    public function index(Request $request)
    {
        $features = FeatureManager::index(20, $request->input('page'));

        return response()->json($features);
    }

    public function show(Request $request)
    {
        $result = null;

        if ($request->has('id')) {
            $result = FeatureManager::show($request->input('id'));
        }

        if ($request->has('name')) {
            $result = FeatureManager::showByName($request->input('name'));
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $rules = FeatureManager::validationRules();

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed']);
        }

        $enabled = $request->has('enabled');

        $feature = FeatureManager::store($request->input('name'), $enabled);

        if(!empty($feature)) {
            return response()->json(['feature' => $feature]);
        }

        return response()->json(['error' => 'Error storing feature']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_ids' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed']);
        }

        $result = FeatureManager::update($id, $request->input('role_ids'));

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $result = null;

        if ($request->has('id')) {
            $result = FeatureManager::delete($request->input('id'));
        }

        if ($request->has('name')) {
            $result = FeatureManager::deleteByName($request->input('name'));
        }

        return response()->json($result);
    }

    public function enable(Request $request)
    {
        $result = null;

        if ($request->has('id')) {
            $result = FeatureManager::enable($request->input('id'));
        }

        if ($request->has('name')) {
            $result = FeatureManager::enableByName($request->input('name'));
        }

        return response()->json($result);
    }

    public function disable(Request $request)
    {
        $result = null;

        if ($request->has('id')) {
            $result = FeatureManager::disable($request->input('id'));
        }

        if ($request->has('name')) {
            $result = FeatureManager::disableByName($request->input('name'));
        }

        return response()->json($result);
    }

    public function toggle(Request $request)
    {
        $result = null;

        if ($request->has('id')) {
            $result = FeatureManager::toggle($request->input('id'));
        }

        if ($request->has('name')) {
            $result = FeatureManager::toggleByName($request->input('name'));
        }

        return response()->json($result);
    }

    public function attach(Request $request)
    {
        $result = null;

        $role = $request->input('role_id');

        if ($request->has('id')) {
            $result = FeatureManager::attachRole($request->input('id'), $role);
        }

        if ($request->has('name')) {
            $result = FeatureManager::attachRoleByName($request->input('name'), $role);
        }

        return response()->json($result);
    }

    public function detach(Request $request)
    {
        $result = null;

        $role = $request->input('role_id');

        if ($request->has('id')) {
            $result = FeatureManager::detachRole($request->input('id'), $role);
        }

        if ($request->has('name')) {
            $result = FeatureManager::detachRoleByName($request->input('name'), $role);
        }

        return response()->json($result);
    }

    public function sync(Request $request)
    {
        $result = null;

        $roles = $request->input('role_ids');

        if ($request->has('id')) {
            $result = FeatureManager::syncRoles($request->input('id'), $roles);
        }

        if ($request->has('name')) {
            $result = FeatureManager::syncRolesByName($request->input('name'), $roles);
        }

        return response()->json($result);
    }
}
