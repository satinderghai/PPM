<?php
/*
* FilterController.php - Controller file
*
* This file is part of the Filter component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\Filter\Controllers;

use App\Exp\Base\BaseController; 
use App\Exp\Components\Filter\FilterEngine;
use App\Exp\Support\CommonUnsecuredPostRequest;

class FilterController extends BaseController 
{    
    /**
     * @var  FilterEngine $filterEngine - Filter Engine
     */
    protected $filterEngine;

    /**
      * Constructor
      *
      * @param  FilterEngine $filterEngine - Filter Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(FilterEngine $filterEngine)
    {
        $this->filterEngine = $filterEngine;
    }

    /**
     * Get Filter data and show filter view
     *
     * @param obj CommonUnsecuredPostRequest $request
     * 
     * return view
     *-----------------------------------------------------------------------*/
    public function getFindMatches(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterData($request->all());



//        echo "<pre>";
// print_r($processReaction);
// die();
        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.find-matches', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.filter', $processReaction['data']);
        }
    }
}