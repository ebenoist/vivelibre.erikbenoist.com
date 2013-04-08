$(document).ready(function(){

	// Links effect
	//
	if( BrowserDetect.browser!="Explorer" ) {
		$("a").hover(
			function(){
				$(this).parent().addClass("selected");
				$(this).animate({opacity: 0.5},300);
				$(this).animate({opacity: 1},100);
			},
			function(){
				$(this).parent().removeClass("selected");
				$(this).animate({opacity: 1},100);
			}
		);
	}

	// External Links
	//
	$("ul.links li a").append(" <img src='wp-content/themes/dfblog/images/icons/external.png' border ='0' />");
	$("a.external").append(" <img src='wp-content/themes/dfblog/images/icons/external.png' border ='0' />");

	// Go To Top
	//
	$("span#gototop a").click( function() {
		$.scrollTo($("body"), 1000);
		return false;
	});
});