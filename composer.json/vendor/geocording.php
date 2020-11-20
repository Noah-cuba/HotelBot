<?php
require_once realpath(__DIR__.'/autoload.php');


$addresses = Dm_Geocoder::reverseGeocode(39.761437, 140.089602);
$addresses[0]->prefectureName; // 秋田県
$addresses[0]->municipalityName; // 秋田市
$addresses[0]->localName; // 将軍野青山町
$addresses[1]->localName; // 将軍野堰越
$addresses[2]->localName; // 寺内字通穴
$addresses[3]->localName; // 将軍野東四丁目
print_r($addresses);
?>
