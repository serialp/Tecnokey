<?php

namespace Tecnokey\ShopBundle\Controller\Frontend;

use Tecnokey\ShopBundle\Entity\Shop\Brand;
use Tecnokey\ShopBundle\Entity\Shop\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tecnokey\ShopBundle\Entity\Shop\Category;
use Tecnokey\ShopBundle\Form\Shop\CategoryType;
use Doctrine\ORM\EntityManager;
use Exception;
use Tecnokey\ShopBundle\Entity\Shop\ShoppingCart;

/**
 * Frontend\Default controller.
 *
 * @Route("/tienda")
 */
class DefaultController extends Controller {

    /**
     * Frontend demo
     *
     * @Route("/", name="TKShopFrontendIndex")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        //Grab categories  from db
        $categories = $em->getRepository('TecnokeyShopBundle:Shop\Category')->findRandomFamilies();
        //End grabbing cats from db
        
        return array(
            'entities' => $categories,
        );
        
    }
    
    /**
     * Frontend demo
     *
     * @Route("/index2", name="TKShopFrontendIndex2")
     * @Template()
     */
    public function index2Action() {
        $blog = (object) array(
            'title' => 'Test',
            'body' => 'Main body'            
        );
        
        $container = array(
            'blog' => $blog
        );
        return array('blog_entries' => $container);
    }

}
