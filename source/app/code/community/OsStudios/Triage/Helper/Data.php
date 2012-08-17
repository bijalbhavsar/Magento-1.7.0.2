<?php
class OsStudios_Triage_Helper_Data extends Mage_Core_Helper_Data
{
    
	protected $_error = null;
	
	public function __construct(){
		$this->_error = new Varien_Object();
	}
	
	public function getConfig($field, $store = null, $group = 'general', $section = 'triage') {
		if(is_null($store)) {
			$store = MAge::app()->getStore();
		}
		return Mage::getStoreConfig(implode('/', array($section, $group, $field)), $store);
	}
	
	public function getOfflineMessage()
	{
		return $this->getConfig('offline_message');
	}
	
	public function getNotInGroupMessage()
	{
		return $this->getConfig('notingroup_message');
	}
	
    public function isEnabled()
    {
        return $this->getConfig('enabled');
    }
    
    protected function getRedirectUrl()
    {
    	return Mage::getUrl('contacts');
    }
    
    protected function getButtonText()
    {
    	return $this->__('Get a Quote');
    }
    
    protected function getLinkText()
    {
    	return $this->__('Get a Quote');
    }
    
    public function getButtonBlock()
    {
    	$button  = '<button type="button" title="'.$this->getButtonText().'" class="button btn-cart protected-button" onclick="setLocation(\''.$this->getRedirectUrl().'\')">';
    	$button .= '<span>';
    	$button .= '<span>'.$this->getButtonText().'</span>';
    	$button .= '</span>';
    	$button .= '</button>';
    	
    	return $button; 
    }
    
    public function getLinkBlock()
    {
    	$link = '<a href="'.$this->getRedirectUrl().'" class="link-cart protected-link">'.getLinkText().'</a>';
    	return $link;
    }
    
    public function isProductAllowed(Mage_Catalog_Model_Product $product)
    {
    	if($this->isEnabled()) {
    		
    		$result = (bool) true;
    		
    		$collection = $product->getCategoryCollection();
    		$allowed = explode(',', $this->getConfig('categories'));
    		
    		foreach($collection as $category) {    			
    			if(!Mage::helper('customer')->isLoggedin()) {
    				$this->_setError($this->getOfflineMessage());
    				$result = (bool) false;
    				break;
    			} else {
    				
    				$customer = Mage::getSingleton('customer/session')->getCustomer();
    				$allowed_groups = explode(',', $this->getConfig('groups'));
    				
    				if(in_array($category->getEntityId(), $allowed) && !in_array($customer->getGroupId(), $allowed_groups)) {
    					$this->_setError($this->getNotInGroupMessage());
    					$result = (bool) false;
    					break;
    				}
    			}
    		}
    		
    		return $result;
    	} else {
    		return true;
    	}
    }
    
    public function getError()
    {
    	return $this->_error;
    }
    
    protected function _setError($message = null)
    {
    	if(!is_null($message)) {
    		$this->getError()->setErrorMessage($message);
    	}
    	return $this;
    }
}