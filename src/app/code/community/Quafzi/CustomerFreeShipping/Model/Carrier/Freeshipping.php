<?php
/**
 * Quafzi_CustomerFreeShipping
 *
 * This file is part of the Quafzi_CustomerFreeShipping extension.
 * Please do not edit or add to this file if you wish to upgrade it to newer
 * versions in the future.
 *
 * @category   Quafzi_CustomerFreeShipping
 * @package    Quafzi_CustomerFreeShipping
 * @copyright  © 2016 by Thomas Birke <magento@netextreme.de>
 * @license    OSL
 */

/**
 * Free shipping model for backend use, only
 *
 * @author     Thomas Birke <magento@netextreme.de>
 */
class Quafzi_CustomerFreeShipping_Model_Carrier_Freeshipping
    extends Mage_Shipping_Model_Carrier_Freeshipping
{

    /**
     * Carrier's code
     *
     * @var string
     */
    protected $_code = 'customer_freeshipping';

    /**
     * Whether this carrier has fixed rates calculation
     *
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * FreeShipping Rates Collector
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        if (!Mage::getSingleton('customer/session')->isLoggedIn()
            || !Mage::getSingleton('customer/session')->getCustomer()->getFreeshipping()
        ) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier('customer_freeshipping');
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod('customer_freeshipping');
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice('0.00');
        $method->setCost('0.00');

        $result->append($method);

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('customer_freeshipping' => $this->getConfigData('name'));
    }

}
