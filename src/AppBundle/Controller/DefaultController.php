<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app.auth.login');
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app.admin.index');
        }

        return $this->redirectToRoute('app.workbench.index');
    }
}
