<?php

require_once('includes/init.inc.php');


$sql = "select energy_production.* from country_codes,energy_production where energy_production.country=country_codes.country order by `2007` desc limit 6 ";
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



<div class=qbox id=qbox >


<SCRIPT type="text/javascript" language="javascript">
$(document).ready(function(){
<?php

SQL_to_JS_var::sql_to_jqplot_var($sql);

?>

  var plot1 = $.jqplot('chart1', [<?php for($i=0;$i<=$count-1; $i++) echo "line".$i.","; ?>],{
      title:'Petrol Price',
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


<DIV id="chart1" style="width: 95%; height: 95%; position: relative; " class="jqplot-target"></DIV>
</div>
</div>

