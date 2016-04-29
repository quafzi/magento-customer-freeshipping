<?php
$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$installer->addAttribute('customer', 'freeshipping', [
    'default'  => 0,
    'input'    => 'select',
    'label'    => 'Freeshipping allowed',
    'note'     => 'Created by Quafzi_CustomerFreeShipping',
    'required' => false,
    'source'   => 'eav/entity_attribute_source_boolean',
    'type'     => 'int',
    'unique'   => false,
    'visible'  => false
]);

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'freeshipping');

$setup->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'customattribute',
    '999'  //sort_order
);

$used_in_forms = [];

$used_in_forms[]='adminhtml_customer';
//$used_in_forms[]='checkout_register';
//$used_in_forms[]='customer_account_create';
//$used_in_forms[]='customer_account_edit';
$used_in_forms[]='adminhtml_checkout';
$attribute->setData('used_in_forms', $used_in_forms)
    ->setData('is_used_for_customer_segment', true)
    ->setData('is_system', 1)
    ->setData('is_user_defined', 0)
    ->setData('is_visible', 0)
    ->setData('sort_order', 999)
    ;
$attribute->save();

$installer->endSetup();
