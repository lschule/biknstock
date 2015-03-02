$(function() {
	$("table#stocktable").tablesorter({ sortList: [[1,0]] });
	
	$("a.date").click(function(){
		
		$.get( $(this).attr("href"), function( data ) {
			$("#headers").hide();
			$( "#intraInfo" ).html( data );
			$("#intraInfo").show();
			g = new Dygraph(document.getElementById("graphdiv"),stockData);
		});

		return false;
	})
});

jQuery(function($) {
  function fixDiv() {
    var $cache = $('#getFixed');
    if ($(window).scrollTop() > 300)
      $cache.css({
        'position': 'fixed',
        'top': '50px'
      });
    else
      $cache.css({
        'position': 'relative',
        'top': 'auto'
      });
  }
  $(window).scroll(fixDiv);
  fixDiv();
});