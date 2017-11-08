// JavaScript Document
// Still working on what options I need and which ones I don't.

$(function() {
	
	// This loads the section (where the form is placed).
	$('.section, .section_container').css({display: "inline-block"});
	
	$('.sh_toggle, .modals').on('click', function() {
		var id = $(this).data('tab');
		$('#' + id).slideToggle();
	});
		
	$('#cancel_note').on('click', function() {
		$('.doctors_note').hide();
		$('#doctors_note').show();
	});
	
	// Hides any messages displayed.
	if($('#message_banner').length) {
		$('#message_banner').delay(3000).slideUp(250);
		setTimeout(function() {
			$('#message_banner').remove();
		}, 3500);
	}

	// This is for the overlay
	
});


// This function will add the class hV to label the input has a value or not.
function cVal(e) {
	
	var value = e.value;
	
	if(value.length === 0){
		var name = e.getAttribute('name');
		document.querySelector('label[for="' + name + '"]').removeAttribute('class');
	} else {
		var name = e.getAttribute('name');
		document.querySelector('label[for="' + name + '"]').className += 'hV';
	}
	
}

function closeOverlay() {
	$('.overlay').fadeOut(300);
}

function openOverlay() {
	$('.overlay').fadeIn(300);
}

function showSection(info) {

	var section = $(info).data('test');

	$(section).slideDown(200);

}

