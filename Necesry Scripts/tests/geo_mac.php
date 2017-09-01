<?php
//isaac geo integration 20/11/2016
include_once('../../define_const.php');

if ($CONFIG->__GETCONF('UseGeoLocalization') == 'yes')
	$GIP = geoip_open('../../includes/ajax/GeoIP.dat',GEOIP_STANDARD);

echo geoip_country_code_by_addr($GIP, "24.24.24.24") . "\t" .
	geoip_country_name_by_addr($GIP, "24.24.24.24") . "\n";
echo geoip_country_code_by_addr($GIP, "80.24.24.24") . "\t" .
	geoip_country_name_by_addr($GIP, "80.24.24.24") . "\n";
geoip_close($GIP);
?>