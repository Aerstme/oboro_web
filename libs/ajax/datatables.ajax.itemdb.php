<?php
include_once('../controller.php');

$data = array();


$data_cache = $ITEM->get('ItemDB');
if ( $data_cache )
{
	$IT_TEMP = $ITEM->decode_arr($ITEM->get('ItemDB'));
	foreach($IT_TEMP as $poc => $arr)
	{
		$new_arr = array();
		foreach($arr as $poc => $val)
			array_push($new_arr, $arr[$poc]);
		array_push($data, $new_arr);
	}

	$results = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data
	);

	echo json_encode($results);
}

?>