<?php

require_once('includes/init.inc.php');

$year_start = 1971;
$year_end = 2008;
$table = "energy_production";



?>




<!DOCTYPE HTML>
<html>
<head>
	<title>Template</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	
		
	<link rel = "stylesheet" href ="css/style.css" media = "all">
	<link rel = "stylesheet" href ="css/media.css" media = "screen">
	<!-- jVector Map -->
	<link rel="stylesheet" href="jquery/jquery-jvectormap-1.2.2.css" type="text/css" media="screen"/>
	<script src="jquery/jquery-1.9.1.min.js"></script>
	<script src="jquery/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="jquery/jquery-jvectormap-world-mill-en.js"></script>
	
	
	<!--
	<script src="http://use.edgefonts.net/league-gothic.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
	-->
	
	<link rel="stylesheet" href="jquery/jquery-ui.css" />
	<script src="jquery/jquery-ui.js"></script>
	
<script>

var data = new Array();


<?


for($year=$year_start, $id=0; $year<=$year_end; $year++, $id++){

	$sql  = "SELECT ";
	$sql .= 	"tblCC.code, tblES.`{$year}` ";
	$sql .= "FROM ";
	$sql .= 	"{$table} tblES, country_codes tblCC ";
	$sql .= "WHERE ";
	$sql .= 	"lower(trim(tblES.country)) LIKE lower(trim(concat('%', tblCC.country, '%')))";

	echo "data[{$id}] = { ";
		SQL_to_JS_var::sql_to_jqvector_var($sql);
	echo " };\n";

}

?>


function load_map(dataId){
	var loadData = data[dataId];
	$('#world-map').html('');
	$('#world-map').vectorMap({
		map: 'world_mill_en',
		series: {
			regions: [{
				values: loadData,
				scale: ['#e1e4f6', '#090c1f'],
				normalizeFunction: 'polynomial'
			}]
			},
		onRegionLabelShow: function(e, el, code){
			el.html(el.html()+' - '+loadData[code]);
		}
	});
}


var default_value = <?=$year_start;?>;
var min_value = <?=$year_start;?>;
var max_value = <?=$year_end;?>;
$(function() {
	$( "#slider" ).slider({
		value:default_value,
		min: min_value,
		max: max_value,
		step: 1,
		slide: function( event, ui ) {
			$( "#amount" ).val(ui.value );
			load_map(ui.value-<?=$year_start;?>);
		}
	});
	$( "#amount" ).val($( "#slider" ).slider( "value" ) );
});

$(document).ready(function(){
	load_map(0);
});

</script>


</head>
<header>
	<div class="wrapper">
		<div id="title">
			<hgroup>
				<h1 id="title">Green Earth</h1>
				<h2 id="tagline">Renewable Energy Explorer</h2>
			</hgroup>
		</div>
	</div>
</header>
<div id="main-content">
	<div class="wrapper">
		<div id="maps">
		  <div id="world-map"></div>
		  <script>

      
 

  </script>
  <div id="slider"></div>
  <p>
<label for="amount">Year:</label>
<input type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold;" />
</p>
  </div>
		<div id="controls">
			<h1>Controls</h1>
			<ul>
				<li>
					<ul>
						<li><img src="images/graph.png"/></li>
						<li>Graph</li>
					</ul>
				</li>
				<li>
					<ul>
						<li><img src="images/data_sources.png"/></li>
						<li>Data Sources</li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="browse"></div>
	</div>


<?php

$metaData = new RddfParser('node-459.rdf');
echo "site url: ". $metaData->site_url."<br />";
echo "title: ". $metaData->title."<br />";
echo "body: ". $metaData->body."<br />";
echo "dataset url: ". $metaData->dataset_url."<br />";
echo "source name: ". $metaData->source_name."<br />";
echo "source url: ". $metaData->source_url."<br />";
echo "time period: ". $metaData->time_period."<br />";

?>
