<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class MyAdminController extends Controller
{
    /**
     * @Route("/myadmin")
     */
    public function myadminAction(){
        return new Response('<html><body>Admin page!</body></html>');
    }
}