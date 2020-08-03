<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StatusController
 */
class StatusController extends AbstractController
{
    /**
     * @return View
     */
    public function getAction()
    {
        return View::create([
            'status' => 'ok'
        ], Response::HTTP_OK, []);
    }
}
