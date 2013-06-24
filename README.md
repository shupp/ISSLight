#Overview

This is a fun project to take a remote power controller (IP Power IP9258), a traffic light, and some software to turn on different lights when the ISS (International Space Station) is over your location.  The different color lights represent different visibility states:

* Red: The ISS is overhead but obscured by daylight
* Yellow: The ISS is overhead but eclipsed by the Earth's shadow
* Green: The ISS is overhead and visible to the naked eye

This package relies on a couple of other packages I wrote:  [Predict](http://github.com/shupp/Predict) and [Services_IPPower](http://github.com/shupp/Services_IPPower).  The former handles the ISS prediction logic and the latter is a simple IP Power http client.

To install via PEAR, just do the following:

```shell
    pear channel-discover shupp.github.com/pirum
    pear install shupp/Predict-alpha
    pear install shupp/Services_IPPower-alpha
```

Next, just clone this repository, edit the run.php file and put in your location and IP Power access information.  Then try it out by executing the run.php file:

```shell
    php run.php
```

Now, when the ISS flies overhead, this happens:

![Traffic Light](https://raw.github.com/shupp/ISSLight/master/pics/photo.png)

And to confirm, I pulled up my trusty [Where the ISS at?](http://wheretheiss.at) site and it looked like this:

![Where the ISS at? screenshot](https://raw.github.com/shupp/ISSLight/master/pics/iss_overhead.png)

Enjoy!

Bill Shupp
