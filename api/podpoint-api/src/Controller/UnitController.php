<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Helper\UnitHelper;

/**
 * Class UnitController
 */
class UnitController extends AbstractFOSRestController
{
    /**
     * @param  string     $unitId
     * @param  Request    $request
     * @param  UnitHelper $unitHelper
     *
     * @return View
     */
	public function setAction(string $unitId, Request $request, UnitHelper $unitHelper)
    {
        $unitHelperResult = $unitHelper->setUnit($unitId, $request);

        return View::create(
            $unitHelperResult["return"], 
            $unitHelperResult["response"], 
            $unitHelperResult["header"]
        );
    }

    /**
     * @param  string     $unitId
     * @param  string     $chargeId
     * @param  Request    $request
     * @param  UnitHelper $unitHelper
     *
     * @return View
     */
    public function patchAction($unitId, $chargeId, Request $request, UnitHelper $unitHelper)
    {
        $unitHelperResult = $unitHelper->patchUnit($unitId, $chargeId, $request);

        return View::create(
            $unitHelperResult["return"], 
            $unitHelperResult["response"], 
            $unitHelperResult["header"]
        );
    }

    /**
     * @param  UnitHelper $unitHelper
     *
     * @return View
     */
    public function listAction(UnitHelper $unitHelper)
    {
        $unitHelperResult = $unitHelper->getListUnits();
        
    	return View::create(
            $unitHelperResult["return"], 
            $unitHelperResult["response"], 
            $unitHelperResult["header"]
        );
    }

    /**
     * @param  string     $unitId
     * @param  UnitHelper $unitHelper
     *
     * @return View
     */
    public function getAction($unitId, UnitHelper $unitHelper)
    {
        $unitHelperResult = $unitHelper->getUnit($unitId);

        return View::create(
            $unitHelperResult["return"], 
            $unitHelperResult["response"], 
            $unitHelperResult["header"]
        );
    }
}
