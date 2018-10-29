<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    public function getEagerLoads(Request $request)
    {
        $requestedIncludes = $request->input('include', null);;

        if (!is_array($requestedIncludes)) {
            $requestedIncludes = explode(',', $requestedIncludes);
        }

        $availableRequestedIncludes = array_intersect($this->getAvailableIncludes(), $requestedIncludes);
        $defaultIncludes = $this->getDefaultIncludes();

        $includes = array_merge($availableRequestedIncludes, $defaultIncludes);

        $eagerLoads = array();

        foreach ($includes as $includeKey => $includeName) {
            if (gettype($includeKey) === "string") {
                unset($includes[$includeKey]);
                array_push($eagerLoads, $includeKey);
            } else {
                array_push($eagerLoads, $includeName);
            }
        }

        return $eagerLoads;
    }
}
