<?php




// Directory of the json files containing our data,
$jsonDir = "stat-json";


// Logic for updating the folders and files containing data for the statistics.

$firstYear = "2012";
$firstMonth = "1";

$currentYear = date("Y", time());
$currentMonth = date("n", time());


for ($i = $firstYear; $i <= $currentYear; $i++) {

    if ($i != $currentYear) {

        for ($j = 1; $j <= 12; $j++) {

            getSaveJson($i, $j);

        }

    } else {

        for ($j = 1; $j <= $currentMonth; $j++) {

            getSaveJson($i, $j);

        }

    }

}


// Logic for determining the folder structure to load with javascript.
$jsonDirStructure = scandir($jsonDir);

$jsonArr = array();


// Find the foldernames that contains data by year.
foreach ($jsonDirStructure as $jsonFolder) {

	if ($jsonFolder != "." && $jsonFolder != "..") {

		// find the json files within each of the folders found.
		$jsonFiles = scanDir($jsonDir.'/'.$jsonFolder);


		// Put folder and filenames into the array to be json'ed
		// 0 : year
		// 1 : month
        $fileAmount = (count($jsonFiles) - 2);

		for ($i = 1; $i <= $fileAmount; $i++) {

			array_push($jsonArr, [$jsonFolder, $i.".json"]);

		}
	}
}

if (!file_put_contents('data.json', json_encode($jsonArr))) {
	echo 'Something went wrong writing to file';
}


function getSaveJson($year, $month) {

    $remoteUrl = "http://172.20.64.177:3000/tid/";

    $urlToSave = null;

    global $jsonDir;

   // echo getUrl($testUrl);

    // Check if folder exists
    if (!is_dir($jsonDir.'/'.$year)) {
        // dir doesn't exist, make it
        mkdir($jsonDir.'/'.$year);
    }

    $urlToSave = getUrl($remoteUrl.$year."/".$month.".json");

    if ($urlToSave != 'null') {

        if (file_put_contents($jsonDir."/".$year."/".$month.".json", $urlToSave)) {

            echo("<script> console.log($year+' '+$month+' file put'); </script>");

        } else {

            echo("<script> console.log($year+' '+$month+' file not put'); </script>");

        }
      

    } else {
        echo("<script> console.log($year+' '+$month+' was null'); </script>");
    }
}

function getUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'C:\wamp\www\fetchprofiles.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\wamp\www\fetchprofiles.txt');
    $buffer = curl_exec($ch);
    curl_close($ch);
    return $buffer;
}

?>