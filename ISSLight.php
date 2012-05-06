<?php

require_once 'ISSLight/ISS.php';
require_once 'ISSLight/Power.php';

class ISSLight
{
    protected $_iss              = null;
    protected $_power            = null;
    protected $_log              = null;
    protected $_singleLight      = true;
    protected $_previousFunction = null;

    public function __construct(
        $powerHost,
        $powerUser,
        $powerPass,
        $lat,
        $lon,
        $alt,
        $singleLight = true,
        $file = 'iss.tle',
        $log = null
    )
    {
        $this->_iss   = new ISSLight_ISS($lat, $lon, $alt, $file);
        $this->_power = new ISSLight_Power(
            $powerHost,
            $powerUser,
            $powerPass,
            $log
        );

        $this->_singleLight = $singleLight;
    }

    public function setLightToCurrentStatus()
    {
        $data     = $this->_iss->getCurrentData();
        $function = 'setOff';

        if ($data['elevation'] > 0) {
            switch ($data['visibility']) {
                case Predict::SAT_VIS_VISIBLE:
                    $function = 'setGreen';
                    break;
                case Predict::SAT_VIS_DAYLIGHT:
                    $function = 'setRed';
                    break;
                case Predict::SAT_VIS_ECLIPSED:
                    $function = 'setYellow';
                    break;
            }

            if ($this->_singleLight && $function != 'setOff') {
                $function = 'setSingleOn';
            }
        }

        if ($function != $this->_previousFunction) {
            $this->_power->{$function}();
        }
        $this->_previousFunction = $function;
    }

    public function run($sleep = 1)
    {
        while (true) {
            try {
                $this->setLightToCurrentStatus();
                echo 'Calling ' . $this->_previousFunction . "\n";
            } catch (Exception $e) {
                echo $e;
            }
            sleep($sleep);
        }
    }

    public function updateTLE()
    {
        $filename     = __DIR__ . '/iss.tle';
        $tempFilename = __DIR__ . '/new_iss.tle';
        $url          = 'http://celestrak.com/NORAD/elements/stations.txt';

        $contentsOriginal = file_get_contents($url)
                            or die('Could not updated tle get file');
        file_put_contents($tempFilename, $contentsOriginal);
        $contents = file($tempFilename);

        $newFile = implode(
            "\n",
            array(
                trim($contents[0]),
                trim($contents[1]),
                $contents[2]
            )
        );

        file_put_contents($filename, $newFile) or die('could not write');
        unlink($tempFilename);
    }
}
