<?php
if(isset($_GET["count"])){
  $count = $_GET["count"];
} else {
  $count = 10;
}

foreach ($_GET as $key => $value) {
  $search .=  '"'.$key.'":"'.$value.'",';
}

$search = rtrim($search,',');

  $json_url = 'http://militaryhomesforsale.ylopo.com/api/1.0/mapsearch?s=%7B%22locations%22:[%7B'.$search.'%7D]%7D';




//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$json_url);
// Execute
$json=curl_exec($ch);
// Closing
curl_close($ch);
$listings = json_decode($json, true);

$listings = $listings['listings'];
$ids = array();
$i = 1;
foreach ($listings as $listing){

	$ids[] = $listing['id'];
  if ($i++ == $count) break;
}

$ids = array_reverse($ids);

$query = implode(",",$ids);

//echo $query;

$detail_url = 'http://militaryhomesforsale.ylopo.com/api/1.0/listings/?s=%7B%22listingIds%22:['.$query.']%7D';

//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$detail_url);
// Execute
$json=curl_exec($ch);
// Closing
curl_close($ch);





echo $json;


//echo $detail_url;

//echo '<pre>';
//var_dump($listings);
//echo '</pre>';
