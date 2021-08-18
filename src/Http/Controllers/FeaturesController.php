<?php

namespace CharlGottschalk\FeatureToggleLumen\Http\Controllers;

use CharlGottschalk\FeatureToggleLumen\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeaturesController extends BaseController
{
    public function enabled(Request $request)
    {
        $enabled = config('features.default');

        $enabled = Feature::enabled($request->input('name'));

        return response()->json($enabled);
    }

    public function enabledFor(Request $request)
    {
        $enabled = config('features.default');
        $roles = $request->input('roles');

        $enabled = Feature::enabledFor($request->input('name'), $roles);

        return response()->json($enabled);
    }
}
