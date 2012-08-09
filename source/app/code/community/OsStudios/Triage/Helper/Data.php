<?php
class OsStudios_Triage_Helper_Data extends Mage_Core_Helper_Data
{
    
    public function isEnabled()
    {
        return Mage::getStoreConfig('triage/general/enabled');
    }
    
}