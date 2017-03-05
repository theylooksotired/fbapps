$(document).ready(function(){
	adjustPosition();
	activateFormAjax();
});

$(window).load(function() {
	adjustPosition();
});

$(window).resize(function() {
	adjustPosition();
});

$(window).scroll(function() {
});

function activateFormAjax() {
	$('.formContact').submit(function(evt){
		evt.preventDefault();
		evt.stopImmediatePropagation();
		var form = $(this);
		var urlForm = $(this).attr('action');
		var dataForm = $(this).serialize();
		$.ajax({
			type: "POST",
			url: urlForm,
			data: dataForm,
			success: function(response) {
				form.html(response);
				activateFormAjax();
			}
		});
	});
}

function adjustPosition() {
	$('.contentFormat').css('height', 'auto');
	var windowHeight = $(window).outerHeight();
	var bodyHeight = $('.bodySite').outerHeight();
	var footerHeight = $('.footer').outerHeight();
	console.log(windowHeight + ' - ' + bodyHeight);
	if (windowHeight > bodyHeight) {
		$('.contentFormat').height(windowHeight - footerHeight);
	}
}