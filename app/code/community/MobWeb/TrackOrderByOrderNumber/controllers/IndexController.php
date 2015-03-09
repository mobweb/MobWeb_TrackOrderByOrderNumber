<?php

class MobWeb_TrackOrderByOrderNumber_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function postAction()
    {
        $helper = Mage::helper('trackorderbyordernumber');
        $data = $this->getRequest()->getPost();

        // If no tracking or order number is available, thrown an exception
        if (empty($data['number'])) {
            Mage::throwException($this->__('Invalid form data.'));
        }

        // Get the posted search data
        $number = $data['number'];

        // Search the orders for the provided ID
        $orders = Mage::getModel('sales/order')->getCollection();
        $orders->addAttributeToFilter(
            'increment_id', array('like' => '%' . $number . '%')
        );

        // Parse the result collection into an array
        $results = array();
        foreach($orders AS $result) {
            $results[] = $result;
        }

        // If at least one order has been found, try to extract the tracking information for that order
        if(count($results)) {

            // Get the first order from the results
            $order = $results[0];

            // Get all the shipments for that order
            $shipments = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($order)->load();

            // Loop through the shipments
            $trackingInfos = array();
            foreach ($shipments AS $shipment){

                // Get the tracking infos for all shipments
                foreach($shipment->getAllTracks() as $tracking) {
                    $trackingInfo = array(
                        'number' => $tracking->getNumber(),
                        'carrier' => $tracking->getTitle(),
                    );

                    $trackingInfos[] = $trackingInfo;
                }
            }

            // If at least one tracking number has been found, we can use that
            if(count($trackingInfos)) {

                // Get the tracking information
                $tracking = $trackingInfos[0];

                // Get the link for tracking the current tracking number
                $trackingLink = $helper->getTrackingURL($tracking['number'], $tracking['carrier']);
            }
        }

        // If at this point no tracking link has been defined, perhaps a tracking number was
        // entered directly instead of an order number
        if(!isset($trackingLink)) {
            $trackingLink = $helper->getTrackingURL($number);
        }

        // If a valid tracking link has been found, redirect the user to that link
        if(isset($trackingLink) && filter_var($trackingLink, FILTER_VALIDATE_URL)) {
            $this->_redirectUrl($trackingLink);

            return;
        }

        // Otherwise, display a notification and redirect the customer back to the previous page
        Mage::getSingleton('core/session')->addNotice($this->__('No tracking information has been found.'));
        $this->_redirectReferer();

        return;
    }
} 