# MobWeb_TrackOrderByOrderNumber extension for Magento

A simple form that allows the user to enter an order number. If a tracking number has been added to this order, the user will be redirected to the tracking URL on the carrier's website.

The form is available at ```http://your-shop.com/trackorderbyordernumber/```.

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Configuration / Extension

You might want to add your own carrier codes and tracking URL schemes in ```app/code/community/MobWeb/TrackOrderByOrderNumber/Helper/Data.php``` around line 35.

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).