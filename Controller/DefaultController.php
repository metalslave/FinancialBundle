<?php

namespace Metalslave\FinancialBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @Route("/financial", name="financial_homepage")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('@MetalslaveFinancial/default/show.html.twig');
    }
}
