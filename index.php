<?php

# loading necessary files
require_once('includes/init.inc.php');

if(empty($_GET['queryId']))
	$queryId=1;
else
	$queryId=$_GET['queryId'];


table_index::init_for_query($queryId);

$metaData = new RddfParser(table_index::$rdf);
if($queryId==4 || $queryId==8){
	$year_start = 2010;
	$year_end = 2010;
}else if ($queryId>=5 && $queryId<=7){
	$year_start = 2009;
	$year_end = 2009;
}else{
	$year_start = 1971;
	$year_end = 2007;
}

$table = table_index::$table;
$rdf_file = table_index::$rdf;

?>


<!DOCTYPE HTML>
<html>
<head>
<title>Green Earth</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0">


<link rel = "stylesheet" href ="css/style.css" media = "all">
<link rel = "stylesheet" href ="css/media.css" media = "screen">

<link rel="stylesheet" href="jquery/jquery-jvectormap-1.2.2.css" type="text/css" media="screen"/>
<script src="jquery/jquery-1.9.1.min.js"></script>
<script src="jquery/jquery-jvectormap-1.2.2.min.js"></script>
<script src="jquery/jquery-jvectormap-world-mill-en.js"></script>
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
				scale: ['<?php echo table_index::$light_tone_hex;?>', '<?php echo table_index::$dark_tone_hex;?>'],
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

  <div id ="slider-content">
  <div id="slider"></div>
	<div id="slider-data">
		<label for="amount">Year:</label>
		<input type="text" id="amount"/>
	</div>
	<div style="clear:both;"></div>

</div>
	<div id="title-des" style="font-size:15px; text-align:justify">
	<ul>
		<li><b><?php echo "$metaData->title"." - ".str_replace('_', ' ', $table)."<br />"; ?></b></li>
	</ul>
	<ul>
		<li><?php echo strip_tags($metaData->body);?></li>
	</ul>
	<ul>
		<li>Reference: <a style="color:#666" href="<?php echo $metaData->site_url;?>" target="_blank"><?php echo $metaData->site_url;?></a></li>
	</ul>
	</div>
	</div>
		<aside>
			<div id="controls">
				<nav>
					<ul>
					<?php if($queryId<=3 || $queryId>=9) { ?>
						<li><a href="graph.php?queryId=<?php echo $queryId;?>" target="_blank">Graph</a></li>
						<? } ?>
						<li><a href="<?php echo 'csv'.DS.table_index::$dataset; ?>" target="_blank">Data Set</a></li>
						<li>World Energy
							<ul>
								<li><a href="index.php?queryId=9">Natural Gas</a></li>
								<li><a href="index.php?queryId=2">Energy Supply</a></li>
								<li><a href="index.php?queryId=3">Energy Production</a></li>
								<li><a href="index.php?queryId=10">Hydro Electricity</a></li>
								<li><a href="index.php?queryId=11">Transmission Loss</a></li>
								<li><a href="index.php?queryId=1">Contribution of Renewable</a></li>
							</ul>
						</li>
						<li>Leading Countries
							<ul>
								<li><a href="index.php?queryId=7">Wind</a></li>
								<li><a href="index.php?queryId=6">Solar</a></li>
								<li><a href="index.php?queryId=4">Biofuel</a></li>
								<li><a href="index.php?queryId=8">Geothermal</a></li>
								<li><a href="index.php?queryId=5">Hydroelectricity</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</aside>
	</div>
</div>
<div style="clear:both"></div>
<footer>
	<div class="wrapper">
	<div id="col1">
	<a href="http://spaceappschallenge.org/"><img id="spaceapps" src="images/spaceappschallenge.png"/></a>
	<ul>
		<li id ="header">Thanks</li>
		<li><a href="http://yipl.com.np/">YIPL</a></li>
		<li><a href="http://icimod.org/">ICIMOD</a></li>
		<li><a href="http://jvectormap.com/">jVectorMap</a></li>
	</ul>
	
	<div id="col2">
	<a href="https://github.com/SpaceAppsKtm2013/green-earth"><img src="images/Octocat.png"/></a>
	<ul>
		<li id ="header">Teams</li>
		<li><a href="https://github.com/iusmaharjan">Ayush Maharjan</a></li>
		<li><a href="https://github.com/deepsadhi">Deepak Adhikari</a></li>
		<li><a href="http://github.com/kshitiztiwari">Kshitiz Tiwari</a></li>
	</ul>
	
	</div>
	</div>
</footer>
