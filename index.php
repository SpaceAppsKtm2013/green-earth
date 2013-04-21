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

echo "$metaData->title"." - ".str_replace('_', ' ', $table)."<br />";

?>


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
<style>
	
</style>
<div id="world-map"></div>
<div id="slider"></div>
<p>
	<label for="amount">Year:</label>
	<input type="text" id="amount"/>
</p>

<hr />
<?php
echo "site url: ". $metaData->site_url."<br />";
echo "body: ". strip_tags($metaData->body)."<br />";
echo "dataset url: ". $metaData->dataset_url."<br />";
echo "source name: ". $metaData->source_name."<br />";
echo "source url: ". $metaData->source_url."<br />";
echo "time period: ". $metaData->time_period."<br />";
?>
