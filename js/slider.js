//--------Slider-1-----------

$(function() {
$( "#slider-range-max-1" ).slider({
range: "max",
min: 1,
max: 250,
value: 0,
slide: function( event, ui ) {
$( "#textLessonTime" ).val( ui.value );
}
});
$( "#textLessonTime" ).val( $( "#slider-range-max-1" ).slider( "value" ) );
});

//--------Slider-2-----------

$(function() {
$( "#slider-range-max-2" ).slider({
range: "max",
min: 1,
max: 250,
value: 0,
slide: function( event, ui ) {
$( "#textClassworkTime" ).val( ui.value );
}
});
$( "#textClassworkTime" ).val( $( "#slider-range-max-2" ).slider( "value" ) );
});



//--------Slider-3-----------

$(function() {
$( "#slider-range-max-3" ).slider({
range: "max",
min: 1,
max: 250,
value: 0,
slide: function( event, ui ) {
$( "#textHomeworkTime" ).val( ui.value );
}
});
$( "#textHomeworkTime" ).val( $( "#slider-range-max-3" ).slider( "value" ) );
});


//--------for  sub-menu in user login for account details--------
$(function(){

	//Hide SubLevel Menus
	$('#menu ul li ul').hide();

	//OnHover Show SubLevel Menus
	$('#menu ul li').hover(
		//OnHover
		function(){
			//Hide Other Menus
			$('#menu ul li').not($('ul', this)).stop();
			
			//Add the Arrow
			$('ul li:first-child', this).before(
				//'<li class="arrow">arrow</li>'
			);

			////Remove the Border
			//$('ul li.arrow', this).css('border-bottom', '0');

			// Show Hoved Menu
			$('ul', this).slideDown();
		},
		//OnOut
		function(){
			// Hide Other Menus
			$('ul', this).slideUp();

			////Remove the Arrow
			//$('ul li.arrow', this).remove();
		}
	);

});
   

