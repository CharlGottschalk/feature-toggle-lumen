<?php

namespace CharlGottschalk\FeatureToggleLumen\Transformers\Drivers;

use CharlGottschalk\FeatureToggleLumen\Transformers\FeatureTransformer;

class DbTransformer implements TransformerInterface {

    public function transformResults($results) {
        return (object) [
            'data' => $this->transformFeatures($results->items()),
            'pagination' => $this->transformPagination($results)
        ];
    }

    public function transformFeature($result) {
        return FeatureTransformer::transformSingle($result);
    }

    public function transformFeatures($data) {
        return FeatureTransformer::transformMany($data);
    }

    public function transformPagination($results) {
        return [
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
            'taken' => $results->perPage(),
            'total' => $results->total(),
            'urls' => [
                'previous_page' => $results->previousPageUrl(),
                'next_page' => $results->nextPageUrl(),
            ]
        ];
    }
}
