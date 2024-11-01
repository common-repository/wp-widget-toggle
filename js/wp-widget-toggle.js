jQuery(document).ready(function($){

	console.log( wpwt_data );

  // show on pointer on hover
  $('.widget-title').css('cursor','pointer');

	// get custom selectors
	
	if( wpwt_data.selectors ){
		selectors = wpwt_data.selectors.split("\n");
	}else{
		selectors = ['.widget'];
	}

	if( wpwt_data.start_open !=  1 ){
		for (index = 0; index < selectors.length; ++index) {
			// hide widget content
			console.log(selectors[index] + ' .widget-title');
			$( selectors[index] + ' .widget-title' ).each(
				function(){
				  $(this).parent().children().not('.widget-title').slideUp();
				}
			);
		}
	}
	  
	// show/hide widget content on click
	for (index = 0; index < selectors.length; ++index) {
		$( selectors[index] + ' .widget-title' ).click(
			function(){
				$(this).parent().children().not('.widget-title').toggle();
			}
		);
	}
	
});