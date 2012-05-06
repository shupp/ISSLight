<?php

require_once 'Predict.php';
require_once 'Predict.php';
require_once 'Predict/Sat.php';
require_once 'Predict/QTH.php';
require_once 'Predict/Time.php';
require_once 'Predict/TLE.php';

class ISSLight_ISS
{
    protected $_lat     = 0;
    protected $_lon     = 0;
    protected $_alt     = 0;
    protected $_tleFile = 'iss.tle';

    protected $_tle     = null;
    protected $_qth     = null;
    protected $_sat     = null;
    protected $_predict = null;

    public function __construct($lat, $lon, $alt = 0, $file = 'iss.tle')
    {
        $this->_lat     = $lat;
        $this->_lon     = $lon;
        $this->_alt     = $alt;
        $this->_tleFile = $file;

        $this->_qth      = new Predict_QTH();
        $this->_qth->lat = $this->_lat;
        $this->_qth->lon = $this->_lon;
        $this->_qth->alt = $this->_alt;

        $tleFile        = file($this->_tleFile);
        $this->_tle     = new Predict_TLE($tleFile[0], $tleFile[1], $tleFile[2]);
        $this->_sat     = new Predict_Sat($this->_tle);
        $this->_predict = new Predict();
    }

    public function getCurrentData()
    {
        $now = Predict_Time::get_current_daynum(); // get the current time as Julian Date (daynum)

        // Calculate the current location of the satellite
        $this->_predict->predict_calc($this->_sat, $this->_qth, $now);
        $visibility = $this->_predict->get_sat_vis($this->_sat, $this->_qth, $now);

        $data = array(
            'lat'        => $this->_sat->ssplat,
            'lon'        => $this->_sat->ssplon,
            'alt'        => $this->_sat->alt,
            'velocity'   => $this->_sat->velo,
            'visibility' => $visibility,
            'azimuth'    => $this->_sat->az,
            'elevation'  => $this->_sat->el,
            'timestamp'  => Predict_Time::daynum2unix($now)
        );

        return $data;
    }
}

?>
