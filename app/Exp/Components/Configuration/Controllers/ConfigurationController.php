<?php
/*
* ConfigurationController.php - Controller file
*
* This file is part of the Configuration component.
*-----------------------------------------------------------------------------*/

namespace App\Exp\Components\Configuration\Controllers;
use App\Exp\Support\CommonPostRequest;
use App\Exp\Base\BaseController; 
use App\Exp\Components\Configuration\Requests\ConfigurationRequest;
use App\Exp\Components\Configuration\ConfigurationEngine;
use Artisan;

class ConfigurationController extends BaseController 
{    
    /**
     * @var  ConfigurationEngine $configurationEngine - Configuration Engine
     */
    protected $configurationEngine;

    /**
      * Constructor
      *
      * @param  ConfigurationEngine $configurationEngine - Configuration Engine
      *
      * @return  void
      *-----------------------------------------------------------------------*/

    function __construct(ConfigurationEngine $configurationEngine)
    {
        $this->configurationEngine = $configurationEngine;
    }
    
    /**
     * Get Configuration Data.
     *
     * @param string $pageType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function getConfiguration($pageType) 
    {  
        $processReaction = $this->configurationEngine->prepareConfigurations($pageType);
        
        return $this->loadManageView('configuration.settings', $processReaction['data']);   
    }

     /**
     * Get Configuration Data.
     *
     * @param string $pageType
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreConfiguration(ConfigurationRequest $request, $pageType) 
    {
        $processReaction = $this->configurationEngine->processConfigurationsStore($pageType, $request->all());
      
        return $this->responseAction($this->processResponse($processReaction, [], [], true));
	}

    /**
     * Clear system cache
     *
     * @param ManageItemAddRequest $request
     *
     * @return void
     *---------------------------------------------------------------- */
    public function clearSystemCache(ConfigurationRequest $request)
    {
        $homeRoute = route('manage.dashboard');
        $cacheClearCommands = array(
            'route:clear',
            'config:clear',
            'cache:clear',
            'view:clear',
            'clear-compiled'
        );

        foreach ($cacheClearCommands as $cmd) {
            Artisan::call('' . $cmd . '');
        }
         if ($request->has('redirectTo')) {
            header('Location: '.base64_decode($request->get('redirectTo')));
        } else {
            header('Location: '.$homeRoute);
        }

        exit();
    }
}