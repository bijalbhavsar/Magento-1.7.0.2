<?php
class OsStudios_Triage_Model_System_Config_Source_Categories
{
    public function toOptionArray()
    {
        $categories = Mage::getModel('catalog/category')->getCollection()
                                                        ->addAttributeToSelect('name')
                                                        ->addAttributeToFilter('parent_id', array('gt' => 1));
        
        $result = array();
        foreach($categories as $category) {
            $result[] = array(
                'value' => $category->getId(),
                'label' => $category->getName()
            );
        }
        
        return $result;
    }
}
