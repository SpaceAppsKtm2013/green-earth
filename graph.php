<?php

require_once('includes/init.inc.php');

if(empty($_GET['queryId']))
	$queryId=1;
else
	$queryId=$_GET['queryId'];
	

table_index::init_for_query($queryId);
$table = table_index::$table;
$year  = 2007;

$metaData = new RddfParser(table_index::$rdf);

$sql  = "SELECT ";
$sql .= 	"{$table}.* ";
$sql .= "FROM ";
$sql .= 	"country_codes, {$table} ";
$sql .= "WHERE ";
$sql .= 	"{$table}.country=country_codes.country ";
$sql .= "ORDER BY ";
$sql .= 	"`{$year}` DESC LIMIT 6 ";

$result = SQL_to_JS_var::find_by_sql($sql);
$count = $database->num_rows($result);

?>


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

<SCRIPT type="text/javascript" language="javascript">
$(document).ready(function(){
<?php

SQL_to_JS_var::sql_to_jqplot_var($sql);

?>

var plot1 = $.jqplot('chart1', [<?php for($i=0;$i<=$count-1; $i++) echo "line".$i.","; ?>],{
	title:'<?php
		echo "$metaData->title"." - ".str_replace('_', ' ', $table);
		echo "<br>";
		echo "Unit: ".table_index::$unit;
		?>',
	legend: {show:true, location: 'se'},
	series:[
		<?php SQL_to_JS_var::sql_to_jqplot_series_var($sql); ?>
		],
	axes:{
		xaxis:{
		renderer:$.jqplot.DateAxisRenderer,
		tickOptions:{
		formatString:'%y'
		} 
		},
		yaxis:{
		tickOptions:{
		formatString:'%.2f'
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
});
</SCRIPT>

<div class=qbox id=qbox >
	<DIV id="chart1" style="width: 95%; height: 95%; position: relative; " class="jqplot-target"></DIV>
	</div>
</div>

