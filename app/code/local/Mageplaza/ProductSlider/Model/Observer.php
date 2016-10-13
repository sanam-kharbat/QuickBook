<?php

class Mageplaza_ProductSlider_Model_Observer
{
    /**
     * process controller_action_predispatch event
     *
     * @return Mageplaza_ProductSlider_Model_Observer
     */
    public function controllerActionPredispatch($observer)
    {
        $action = $observer->getEvent()->getControllerAction();
        return $this;
    }
}