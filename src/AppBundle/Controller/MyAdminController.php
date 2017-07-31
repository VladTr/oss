<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MyAdminController extends Controller
{
    /**
     * @Route("/myadmin")
     */
    public function myadminAction(){
        return new Response('<html><body><h3>congratulations!</h3>you got to private area.</body></html>');
    }
}
