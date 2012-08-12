<?php
class OsStudios_Triage_Helper_Data extends Mage_Core_Helper_Data
{
    
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
    
}