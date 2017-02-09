$(document).ready(function(){

	/*
	//MENU
	$('.bodySiteIntro .menu .menuItem a').click(function(evt){
		evt.stopImmediatePropagation();
		evt.preventDefault();
		var info = $.attr(this, 'href').split('#')[1];
	    $('html, body').animate({
	        scrollTop: $('[name="' + info + '"]').offset().top
	    }, 500);
	    return false;
	});
	*/
	
	activateAjax();

});

$(window).load(function() {
});

$(window).resize(function() {
});

$(window).scroll(function() {
});


function activateAjax() {
	//FORMS
	$('.formContact').submit(function(evt){
		evt.stopImmediatePropagation();
		$.post($(this).attr('action'), $(this).serialize(), function(response){
	    	$('.formContact').replaceWith($('<div />').html(response).html());
			activateAjax();
		});
		return false;
	});	
}