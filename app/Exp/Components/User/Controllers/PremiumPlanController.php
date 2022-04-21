<?php
/*
* PremiumPlanController.php - Controller file
*
* This file is part of the Premium Plan User component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\User\Controllers;

use App\Exp\Base\BaseController;
use App\Exp\Components\User\PremiumPlanEngine;
use App\Exp\Support\CommonUnsecuredPostRequest;
// form Requests
use App\Exp\Support\CommonPostRequest;

class PremiumPlanController extends BaseController 
{    
    /**
     * @var  PremiumPlanEngine $premiumPlanEngine - PremiumPlan Engine
     */
    protected $premiumPlanEngine;

    /**
      * Constructor
      *
      * @param  PremiumPlanEngine $premiumPlanEngine - PremiumPlan Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(PremiumPlanEngine $premiumPlanEngine)
    {
        $this->premiumPlanEngine = $premiumPlanEngine;
	}

	/**
     * User Premium Plan View.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function getPremiumPlanView() 
    {
   		$processReaction = $this->premiumPlanEngine->preparePremiumPlanUserData();
       
        return $this->loadPublicView('user.premium-plan.premium', $processReaction['data']);
	}

	/**
     * Handle buy premium plan by user request.
     *
     * @param object CommonUnsecuredPostRequest $request
     * @param string $reminderToken
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function buyPremiumPlans(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->premiumPlanEngine->processBuyPremiumPlan($request->all());

		//if reaction code is 1 then redirect to success page
		if ($processReaction['reaction_code'] == 1) {
			return $this->responseAction(
				$this->processResponse($processReaction, [], [], true),
				$this->redirectTo('user.premium_plan.read.success_view')
			);
		}

        return $this->responseAction(
			$this->processResponse($processReaction, [], [], true)
		);
	}

	/**
     * User Premium Plan Success View.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function getPremiumPlanSuccessView() 
    {       
        return $this->loadPublicView('user.premium-plan.premium-plan-success');
	}
}