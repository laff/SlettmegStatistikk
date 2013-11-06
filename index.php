<?php

$jsonDir = "C:\Users\HS Vikar\Downloads\ball";


$jsonDirStructure = scandir($jsonDir);

$jsonFolders = array();

foreach($jsonDirStructure as $jsonFolder) {

	echo $jsonFolder;
	
	if($jsonFolder != "." || $jsonFolder != "..") {
		array_push($jsonFolders, $jsonFolder);
	}
}

print_r($jsonFolders);


?>