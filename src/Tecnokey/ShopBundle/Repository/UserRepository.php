<?php
namespace Tecnokey\ShopBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Tecnokey\ShopBundle\Entity\Shop\User;
use \Tecnokey\ShopBundle\Entity\Shop\Order;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryDAO
 *
 * @author MQMTECH
 */
class UserRepository extends EntityRepository{
    
    const RECENT_MAX_RESULTS = 10;
    const RECENT_ORDER_BY = 'DESC';
    
    const USER_PERMISSION_TYPE = 'ROLE_USER';
    
    
    public function findRecentClients($max = self::RECENT_MAX_RESULTS){

        $em = $this->getEntityManager();

        //Grab categories from db
        $em = $this->getEntityManager();
        $q = $em->createQuery("select user from TecnokeyShopBundle:Shop\\User user WHERE user.permissionType = '". self::USER_PERMISSION_TYPE ."' ORDER BY user.createdAt ".self::RECENT_ORDER_BY);
        $q->setMaxResults($max);
        $users = $q->getResult();

        return $users;
        //End grabbing cats from db
    }
    
    /**
     * 
     * return array
     */
    public function findDeliveredOrders(User $user){

        //Grab categories from db
        $em = $this->getEntityManager();
        $q = $em->createQuery("select o from TecnokeyShopBundle:Shop\\Order o JOIN o.user u WHERE o.status LIKE '" . Order::STATUS_2_DELIVERED . "' AND u.id ='". $user->getId() . "'");
        $orders = $q->getResult();
        //End grabbing cats from db
        
        if($orders == NULL){
            return NULL;
        }
        
        return $orders;
    }
    
        /**
     * 
     * return array
     */
    public function findInProcessOrders(User $user){

        //Grab categories from db
        $em = $this->getEntityManager();
        $q = $em->createQuery("select o from TecnokeyShopBundle:Shop\\Order o JOIN o.user u WHERE o.status <> '" . Order::STATUS_2_DELIVERED . "' AND u.id ='". $user->getId() . "'");
        $orders = $q->getResult();
        //End grabbing cats from db
        
        if($orders == NULL){
            return NULL;
        }
        
        return $orders;
    }
}

?>
