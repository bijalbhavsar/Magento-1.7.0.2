<?php
class OsStudios_Triage_Model_System_Config_Source_Groups
{
    public function toOptionArray()
    {
        $groups = Mage::getModel('customer/group')->getCollection();
        
        $result = array();
        foreach($groups as $group) {
            $result[] = array(
                'value' => $group->getId(),
                'label' => $group->getCustomerGroupCode()
            );
        }
        
        return $result;
    }
}
