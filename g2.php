<?php

require_once('includes/init.inc.php');

$year_start = 1971;
$year_end = 2008;
$table = "energy_supply";



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
	
	
<LINK type="text/css" href="jquery/jquery-ui-1.7.2.custom.css" rel="stylesheet">
<LINK type="text/css" href="jquery/ui.all.css" rel="stylesheet"> 
<LINK type="text/css" href="jquery/demos.css" rel="stylesheet"> 
<LINK type="text/css" href="style/style.css" rel="stylesheet"> 
<LINK rel="stylesheet" type="text/css" href="jquery/jquery.jqplot.css">

<SCRIPT type="text/javascript" src="jquery/jquery-1.3.2.min.js"></SCRIPT>
<SCRIPT language="javascript" type="text/javascript" src="jquery/jquery.jqplot.js"></SCRIPT>
<SCRIPT language="javascript" type="text/javascript" src="jquery/jqplot.dateAxisRenderer.js"></SCRIPT>
<SCRIPT language="javascript" type="text/javascript" src="jquery/jqplot.categoryAxisRenderer.js"></SCRIPT>
<script type="text/javascript" src="jquery/jqplot.highlighter.js"></script>
<script type="text/javascript" src="jquery/jqplot.cursor.js"></script>

	
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








function load_graph(){
  var line1 = [['2012-12-21', 123],['2012-09-02', 125],['2012-06-19', 120],['2012-03-26', 120],['2012-02-24', 116],['2012-01-26', 112],['2012-01-18', 115],['2011-10-10', 105],['2011-08-26', 102],['2011-07-10', 102],['2011-06-11', 102],['2011-05-07', 97],['2011-03-12', 97],['2010-12-18', 88],['2010-12-06', 88],['2010-07-06', 85],['2010-05-11', 82],['2010-04-22', 82],['2010-03-14', 80],['2010-02-17', 77.5],['2010-02-06', 77.5],['2010-01-08', 77.5],['2009-11-17', 77.5],['2009-03-03', 77.5],['2009-02-02', 77.5],['2008-12-26', 80.5],['2008-12-03', 85.5],['2008-11-01', 90],['2008-10-25', 95],['2008-06-09', 100],['2008-06-04', 80],['2008-05-14', 80],['2007-12-26', 80],['2007-12-06', 73.5],['2007-11-08', 73.5],['2007-10-25', 73.5],['2007-10-25', 73.5],['2007-08-05', 67.25],['2007-04-10', 67.25],['2006-10-31', 67.25],['2006-09-26', 67.25],['2006-03-03', 67.25],['2006-02-17', 67],['2005-08-18', 67],['2005-06-21', 62],['2005-02-12', 62],['2005-01-10', 62],['2004-07-19', 56],];

  var line2 = [['2012-12-21', 107.584],['2012-09-02', 109.536],['2012-06-19', 108.448],['2012-03-26', 105.024],['2012-02-24', 105.024],['2012-01-26', 105.024],['2012-01-18', 105.024],['2011-10-10', 106.272],['2011-08-26', 101.92],['2011-07-10', 101.392],['2011-06-11', 93.392],['2011-05-07', 93.392],['2011-03-12', 93.392],['2010-12-18', 84.656],['2010-12-06', 84.656],['2010-07-06', 82.288],['2010-05-11', 76.688],['2010-04-22', 76.688],['2010-03-14', 75.888],['2010-02-17', 75.888],['2010-02-06', 71.552],['2010-01-08', 71.552],['2009-11-17', 71.552],['2009-03-03', 64.992],['2009-02-02', 64.992],['2008-12-26', 72.992],['2008-12-03', 80.992],['2008-11-01', 80.992],['2008-10-25', 80.992],['2008-06-09', 80.896],['2008-06-04', 72.896],['2008-05-14', 72.896],['2007-12-26', 69.632],['2007-12-06', 69.632],['2007-11-08', 69.632],['2007-10-25', 69.632],['2007-10-25', 69.632],['2007-08-05', 69.632],['2007-04-10', 68.56],['2006-10-31', 71.76],['2006-09-26', 74.96],['2006-03-03', 69.584],['2006-02-17', 69.584],['2005-08-18', 69.584],['2005-06-21', 64.784],['2005-02-12', 60.56],['2005-01-10', 60.56],['2004-07-19', 58.896],];

  var plot1 = $.jqplot('world-map', [line1, line2],{
      title:'Petrol Price',
            legend: {show:true, location: 'se'},
      series:[
        {label:'Nepal'}, 
        {label:'India'},
      ],
      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer,
          tickOptions:{
            formatString:'20%y&nbsp;%b&nbsp;%#d'
          } 
        },
        yaxis:{
          tickOptions:{
            formatString:'NRs. %.2f'
            }
        }
      },
      highlighter: {
        show: true,
        sizeAdjust: 7.5
      },
      cursor: {
        show: false
      }
  });
};















$(document).ready(function(){
	load_graph();
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
