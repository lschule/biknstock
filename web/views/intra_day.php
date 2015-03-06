

<div id="graphdiv" style="width:800px; height:300px;"></div>  
  <script>
	var stockData = function() {
     return "Time,Close\n"+
    <?php	  
	  foreach($timesCloses as $line){
		  echo'"'.$line.'\n"+';
	  }  
	?>"\n";
	};
    </script>