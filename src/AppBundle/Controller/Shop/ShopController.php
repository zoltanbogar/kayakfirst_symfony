<?php
/**
 * Created by PhpStorm.
 * User: zoltanbogar
 * Date: 2018. 07. 06.
 * Time: 10:41
 */

namespace AppBundle\Controller\Shop;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class ShopController extends Controller
{
    /**
     * @Route("/shop", name="shop")
     */
    public function indexAction(Request $request)
    {


        return $this->render(':shop:home.html.twig');
    }
}