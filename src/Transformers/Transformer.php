<?php

namespace CharlGottschalk\FeatureToggleLumen\Transformers;

use CharlGottschalk\FeatureToggleLumen\Drivers\Db;

class Transformer {

    public static function transformResults($results) {
        return Db::transformer()->transformResults($results);
    }

    public static function transformFeature($result) {
        return Db::transformer()->transformFeature($result);
    }
}
