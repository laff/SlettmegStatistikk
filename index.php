<!doctype html>
 
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Slettmeg statistikk demo/test</title>

		<!-- CSS "bundled" with Dragdealer -->
		<link rel="stylesheet" type="text/css" href="http://code.ovidiu.ch/css/dragdealer.css" />

		<!-- JQuery -->
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<!-- Dragdealer -->
		<script type="text/javascript" src="http://code.ovidiu.ch/js/dragdealer.js"></script>
		<!-- Highcharts related -->
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>
		<!-- Local -->
		<script src="dragThroughCharts.js"></script>

		

		<?php
			/**
			 * Magic logic for updating the local json file with knowledge of paths and such.
			 *
			**/
			$jsonDir = 'data.json';

			// Checks if file exists.
			if(file_exists($jsonDir)) {

				// Updates file if it is not from the current month
				if(date("F", filemtime($jsonDir)) != date("F", time())) {
					echo "	
					<script> 
						jQuery(function() {
							jQuery.get('jsonStructure.php');
						});

						console.log('jsonStructure called while old file');

						</script>";
				}

			// Creates new file if it doesnt exist.
			} else {
				echo "	
					<script> 
						jQuery(function() {
							jQuery.get('jsonStructure.php');
						});
						
						console.log('jsonStructure called while no file');

					</script>";
			}

		?>

	</head>
	<body>
		<div id="yearDate"></div>

		<div id="chartDrag" class="dragdealer">
			<div class="red-bar handle">drag me</div>
		</div>

		<div id="pie" style="margin: 0 auto; float: left"></div>
		<div id="stackedcolumn" style="margin: 0 auto; float: right"></div>

		<div id="rotatedlabels" style="margin: 0 auto; float: left"></div>


	</body>
</html>