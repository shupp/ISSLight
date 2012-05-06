<?php

require_once 'ISSLight.php';
require_once 'ISSLight/Power.php';

$isslight = new ISSLight(
    '192.168.1.150', // IP Power controller address
    'admin',         // IP Power username
    '12345678',      // IP Power username
    37.646173,       // Latitude
    -122.424127,     // Longitude
    0,               // Altitude
    false            // Whether we are using a single light (outlet one only)
);                   //   or a 3 way traffic light (red/yellow/green)

// $isslight->updateTLE(); // Run this once a day to get the latest TLE file
$isslight->run();
