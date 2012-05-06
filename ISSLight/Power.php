<?php

require_once 'Services/IPPower.php';

class ISSLight_Power
{
    protected $_ippower = null;

    public function __construct(
        $host = '192.168.10.100', $user = 'admin', $pass = '12345678', $log = null
    )
    {
        $options = array(
            'host' => $host,
            'user' => $user,
            'pass' => $pass
        );
        $this->_ippower = new Services_IPPower($options);

        if ($log instanceof Log) {
            $this->_ippower->accept($log);
        }
    }

    public function setSingleOn()
    {
        $this->setRed();
    }

    public function setRed()
    {
        $this->_ippower->setPowerMulti(
            array(
                Services_IPPower::OUTLET_ONE   => Services_IPPower::STATE_ON,
                Services_IPPower::OUTLET_TWO   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_THREE => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_FOUR  => Services_IPPower::STATE_OFF
            )
        );
    }

    public function setYellow()
    {
        $this->_ippower->setPowerMulti(
            array(
                Services_IPPower::OUTLET_ONE   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_TWO   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_THREE => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_FOUR  => Services_IPPower::STATE_ON
            )
        );
    }

    public function setGreen()
    {
        $this->_ippower->setPowerMulti(
            array(
                Services_IPPower::OUTLET_ONE   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_TWO   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_THREE => Services_IPPower::STATE_ON,
                Services_IPPower::OUTLET_FOUR  => Services_IPPower::STATE_OFF
            )
        );
    }

    public function setOff()
    {
        $this->_ippower->setPowerMulti(
            array(
                Services_IPPower::OUTLET_ONE   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_TWO   => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_THREE => Services_IPPower::STATE_OFF,
                Services_IPPower::OUTLET_FOUR  => Services_IPPower::STATE_OFF
            )
        );
    }
}
