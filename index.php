<?php

// Directory of the json files containing our data,
$jsonDir = "C:\Users\John\Dropbox\slettmeg\ball";


$jsonDirStructure = scandir($jsonDir);

$jsonFolders = array();

$jsonArr = array();

// Find the foldernames that contains data by year.
foreach ($jsonDirStructure as $jsonFolder) {

	if ($jsonFolder != "." && $jsonFolder != "..") {

		array_push($jsonFolders, $jsonFolder);
		
		$jsonArr[$jsonFolder] = array();

	}
}


// Finding the filenames within each folder.
foreach ($jsonFolders as $jsonFolder) {

	$folderDir = $jsonDir.'/'.$jsonFolder;

	$jsonFolderStructure = scandir($folderDir);

	foreach ($jsonFolderStructure as $jsonFile) {
		if (filetype($folderDir.'/'.$jsonFile) == 'file') {
			array_push($jsonArr[$jsonFolder], $jsonFile);
		}
	}
}

print_r($jsonArr);


?>