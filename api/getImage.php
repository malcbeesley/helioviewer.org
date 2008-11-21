<?php
	require('lib/helioviewer/DbConnection.php');
	require('lib/helioviewer/ImgIndex.php');

	$dbConnection =  new DbConnection();
	$imgIndex =      new ImgIndex($dbConnection);
	$queryForField = 'abbreviation'; // eventually this will change to id
	$debug= $_GET['debug'];
	
	foreach(array('observatory', 'instrument', 'detector', 'measurement') as $field) {
	  $src["$field.$queryForField"] = $_GET[$field];
	}
	
	switch ($_GET['action']) {
		case 'getClosest':
			if ($debug != "true") {
				header('Content-type: application/json');
			}
			echo json_encode($imgIndex->getClosestImage($_GET['timestamp'], $src, $debug));
			break;
			
		case 'getJP2URL':
			echo $imgIndex->getJP2URL($_GET['timestamp'], $src);
			break;
	}
?>