<?php
/**
 * Os Studios Design Serviços Digitais LTDA
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Os Studios
 * @package     OsStudios_Triage
 * @copyright   Copyright (c) 2012 Os Studios Design Serviços Digitais LTDA. (http://www.osstudios.com.br/)
 * @license     Information not Available
 */
class OsStudios_Triage_Model_Checkout_Cart extends Mage_Checkout_Model_Cart
{
    /**
     * Rewrites the addProduct method in Mage_Checkout_Model_Cart
     * 
     * @param type $productInfo
     * @param type $requestInfo
     * @return type
     */
    public function addProduct($productInfo, $requestInfo = null)
    {
        if(Mage::helper('triage')->isEnabled()) {
            
            $collection = $productInfo->getCategoryCollection();
            $allowed = explode(',', $this->_getConfig('categories'));
            
            foreach( $collection as $category ) {
                
                if(!Mage::helper('customer')->isLoggedin()) {
                    $message = Mage::helper('triage')->getOfflineMessage();
                    Mage::throwException($message);
                } else {
                    
                    $customer = Mage::getSingleton('customer/session')->getCustomer();
                    $allowed_groups = explode(',', $this->_getConfig('groups'));
                    
                    if( in_array($category->getEntityId(), $allowed) && !in_array($customer->getGroupId(), $allowed_groups)) {
                        $message = Mage::helper('triage')->getNotInGroupMessage();
                        Mage::throwException($message);
                    }
                }
            }
        }
        
        return parent::addProduct($productInfo, $requestInfo);
    }
    
    private function _getConfig($field = null)
    {
        return Mage::getStoreConfig("triage/general/{$field}");
    }
}
