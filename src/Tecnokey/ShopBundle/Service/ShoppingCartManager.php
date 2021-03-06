<?php

/**
 * ShoppingCartManager makes crud of a shopping cart 
 *
 * @author mqmtech
 */
namespace Tecnokey\ShopBundle\Service;

use Tecnokey\ShopBundle\Entity\Shop\ShoppingCart;
use Tecnokey\ShopBundle\Entity\Shop\ShoppingCartItem;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Tecnokey\ShopBundle\Entity\Shop\Product;

class ShoppingCartManager {
    
    const entityName = 'TecnokeyShopBundle:Shop\ShoppingCart';

    /**
     *
     * @var RegistryInterface
     */
    private $doctrine;
    
    public function __construct(RegistryInterface $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    /**
     * Clear the items in the Shopping Cart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     *
     * @param ShoppingCart $shoppingCart
     */
    public function removeAllItems(ShoppingCart $shoppingCart){
        if($shoppingCart == NULL){
            return NULL;
        }
        $items = $shoppingCart->getItems();
        
        //clear the items in database
        foreach ($items as $item) {
            $this->getEntityManager()->remove($item);
        }
        
        //clear the items in the array itself
        $items->clear();
    }
    
    /**
     * Remove an items by its id in the Shopping Cart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     *
     * @param $itemId
     */
    public function removeItem(ShoppingCart $shoppingCart, $id){
        if($shoppingCart == NULL){
            return NULL;
        }
        $items = $shoppingCart->getItems();
        
        //clear the items in database
        foreach ($items as $item) {
            if($item->getId() == $id){
                $this->getEntityManager()->remove($item);
                $items->removeElement($item);
                return true;
            }
            
        }
        return false;
    }
    
    /**
     * Check the quantity of the items and delete every item with quantity = 0
     * @param ShoppingCart $shoppingCart 
     */
    public function removeItemsWithoutProducts(ShoppingCart $shoppingCart){
        $items = $shoppingCart->getItems();
        
        if($items == NULL){
            return $shoppingCart;
        }
        
        foreach ($items as $item) {
            if($item->getQuantity() < 1){
                $this->getEntityManager()->remove($item);
                
                $items->removeElement($item);
            }
        }
        return $shoppingCart;
    }
    
    /**
     * Add a Product to the ShoppingCart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     * 
     * @param ShoppingCart $shoppingCart
     * @param Product $product
     * @return ShoppingCart 
     */
    public function addProductToCart(ShoppingCart $shoppingCart, Product $product){
        if($shoppingCart == NULL || $product == NULL){
            return NULL;
        }
        $foundItem = NULL;
        $items = $shoppingCart->getItems();
        foreach ($items as $item) {
            $itemProduct = $item->getProduct();

            if($itemProduct->getId() == $product->getId()){
               $foundItem = $item;
               break;
            }
        }
        
        if($foundItem == NULL){
            $foundItem = new ShoppingCartItem();
            $foundItem->setProduct($product);
            $shoppingCart->addItem($foundItem);
        }
        
        //Update quantity
        $foundItem->setQuantity($foundItem->getQuantity() + 1);
        return $shoppingCart;
    }
    
    /**
     *
     * @return Registry
     */
    private function getEntityManager(){
        if($this->doctrine != NULL){
            return $this->doctrine->getEntityManager();            
        }
        else{
            throw new \Exception("Custom Exception: No DatabaseManager has been setted in ShoppingCartManager");
        }
    }
}

?>
