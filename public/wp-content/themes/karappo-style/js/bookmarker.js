jQuery(document).ready(function(){

	$('#bookmarker_switch').toggle(
		function(){
			$('#bookmarker').show();
			$().mousemove(
				function(e){
					$('#bookmarker').css("top" , e.pageY - 40);
			});
			
			
				$('#bookmarker').toggle(
		function(){
			$("#bookmarker").css({width: "100%"});
			$().unbind('mousemove');
			},
		function(){
			$("#bookmarker").css({width: "100%"});
				$().mousemove(
					function(e){
						$('#bookmarker').css("top" , e.pageY - 40);
				});
		});
			
			
			},
		function(){
			$('#bookmarker').hide();
			$().unbind('mousemove');

			});

});
