<?php

// src/Controller/AdminController.php
// ...

namespace App\Controller\admin;

use Symfony\Component\BrowserKit\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * Require ROLE_ADMIN only for this action
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminDashboard(): Response
    {
        // ...
    }
}