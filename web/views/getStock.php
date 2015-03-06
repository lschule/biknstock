<div id="getFixed">
<div id="intraInfo">
</div>
<div id="headers" class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/vine/text:<?php echo (isset($year)?$year:"YEAH") ?>" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4><?php echo (isset($year)?"Since year":"Enjoy the page")?></h4>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/sky/text:<?php echo $cor ?>" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Close Open Ratio</h4>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/vine/text:<?php echo $ohr ?>" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4>Open High Ratio</h4>
    </div>    
    <div class="col-xs-6 col-sm-3 placeholder">
      <img data-src="holder.js/200x200/auto/sky/text:<?php echo (isset($vol_ratio)?$vol_ratio:"YEAH") ?>" class="img-responsive" alt="Generic placeholder thumbnail">
      <h4><?php echo (isset($vol_ratio)?"Volume ratio %":"Enjoy the page")?></h4>
    </div>

</div>
</div>
<div class="row placeholders">
	<h2 class="sub-header"><?php echo $count?> Interesting matching Stocks</h2>
	          <div class="table-responsive">
	            <table id="stocktable" class="table table-striped">
	              <thead>
	                <tr>
	                  <th>Date</th>
	                  <th>Stock</th>
	                  <th>Close Open %</th>
	                  <th>Open High %</th>
	                  <th>Volume</th>
	                  <th>Volume Ratio %</th>
	                  <th>Date before</th>
	                  <th>Volume Ratio Before %</th>
	                </tr>
	              </thead>
	              <tbody>
					<?php 
					$already_given = array();
					foreach($data as $row){
						$date_nice = new DateTime($row["fields"]["date"][0]);
						$date_nice_before = new DateTime($row["fields"]["date_before"][0]);
												
						
						echo "<tr><td><a class='date' href='/intraDay/".$row["fields"]["symbol"][0]."/".$date_nice->format('Ymd')."'>".$date_nice->format('Y-m-d')."</a></td><td>".$row["fields"]["symbol"][0]."</td><td>".intval($row["fields"]["close_open_ratio"][0]*100)."%</td><td>".intval($row["fields"]["open_high_ratio"][0]*100)."%</td><td>".intval($row["fields"]["volume"][0])."</td><td>".intval($row["fields"]["volume_ratio"][0])."</td><td>".$date_nice_before->format('Y-m-d')."</td><td>".intval($row["fields"]["volume_ratio_before"][0])."</td></tr>";
					}?>
	              </tbody>
	            </table>
	          </div>
 </div>