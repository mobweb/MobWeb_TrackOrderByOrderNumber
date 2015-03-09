<?php

class MobWeb_TrackOrderByOrderNumber_Helper_Data extends Mage_Core_Helper_Abstract
{

	/*
	 *
	 * In this function we parse a tracking number and try to get the URL to the external
	 * tracking page
	 *
	 */
	public function getTrackingURL($trackingNumber, $carrier = NULL)
	{

		// If no carrier has been specified, we have to try and guess
		// the carrier by the format of the tracking number
		if(!$carrier) {

			//TODO add logic for figuring out carrier by analyzing the tracking number
		}

		// If no carrier has been defined at this point, we can't get 
		// the tracking URL
		if(!$carrier) {
			return false;
		}

		// The URL schemes for the different carriers
		$urlSchemes = array(
			'Federal Express' => 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=%s&cntry_code=us',
			'United States Postal Service' => 'https://tools.usps.com/go/TrackConfirmAction.action?tRef=fullpage&tLc=1&text28777=&tLabels=%s',
			'DHL' => 'http://www.dhl.com/en/express/tracking.html?AWB=%s&brand=DHL',
			'Swiss Post' => 'https://www.post.ch/post-startseite/post-geschaeftskunden/post-track-and-trace-search-gk.htm?formattedParcelCodes=%s&directSearch=false&VTI-GROUP=1',

			// Add your own URL schemes here, replacing the part with the tracking number with %s
		);

		// Generate the tracking URL
		return sprintf($urlSchemes[$carrier], $trackingNumber);
	}
}