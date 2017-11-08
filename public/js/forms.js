/*
 *  Custom Script for Forms.
 *  
 */

// Helps correct placeholders.

$(document).on('focus', 'input, textarea', function() {
	if(!$(this).is('[readonly]')) {
		$(this).attr('placeholder', '');
	}		
	var name = $(this).attr('name');
	$('label[for=' + name + ']').css({ opacity: "1", visibility: "visible"});

}).on('focusout', 'input, textarea', function() {
	var value = $(this).val(); 
	if(value.length === 0) {		
		var placeholder = $(this).data('place');
		var name = $(this).attr('name');
		
		$(this).attr('placeholder', placeholder);
		$('label[for=' + name + ']').css({ opacity: "0", visibility: "hidden"});
	}
});

$(document).on('focusout', 'textarea', function() {
	if($(this).val().length !== 0) {
		while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
			$(this).height($(this).height()+1);
		};
	} else {
		$(this).css('height', '38px');
	}
});

// DROPDOWN

// This will slide down the list to select the location. 
$(document).on('click', '.dropdown', function() {
	var id = '#' + $(this).attr('name');
	$(id).slideToggle(100);
});

// If the input losses it's focus, then the dropdown menu will hide.
$(document).on('focusout', '.dropdown', function() {
	var id = '#' + $(this).attr('name');
	if($(id).is(':visible')) {
		$(id).delay(100).slideUp(100);
	}
});

// This will remove focus once the user move mouse outside of dropdown list.
$('.dropdown-list').mouseleave(function() {
	$(this).parents('.field-container').find('.dropdown-list').slideUp(100);
	$(this).parents('.field-container').find('input').blur();

});

// Once the user has selected an option from the dropdown list, the list will slide-up.
$('.dropdown-list li').on('click', function() {
	
	var value = $(this).text(),
		name = $(this).parents('.dropdown-list').attr('id');

	$('#fl_' + name).attr({ value: value });
	$('label[for=' + name + ']').css({visibility: 'visible', opacity: '1'});

	// this will hide the list.
	$(this).parents('ul.dropdown-list').slideUp(100);

});

$(function() {

	$('input, textarea').each(function() {
		var value = $(this).val(); 
		if(value.length !== 0) {		
			var placeholder = $(this).data('place');
			var name = $(this).attr('name');
			
			$(this).attr('placeholder', '');
			$('label[for=' + name + ']').css({ opacity: "1", visibility: "visible"});
		}
	});

});