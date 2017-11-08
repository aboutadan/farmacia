<?php 

// Form Helper
// As name suggests, this will help place custom input with the custom label.
// Please note, will need to include the forms js file for labels to work correctly.
// This was created before learning about "Laravel Collective".

function place_input($name = null, $label = null, $value = null, $attrs = null) {

	/*
		Will need to pass: 
		- name and label (required), sample of how to use: 
        
        place_input('search', 'Busqueda', set_value('search');
        
		- all the other attributes are optional, need to be passed as an ARRAY.
		- if using readonly, which doesn't have a value, set value as null. See example:
		
		$value = array('readonly' => null, 'required' => null);
		
		This will require to add the form helper from codeigniter.
					
	*/
	
	if($name === null || $name === '') die('Input has no name. Try again.');
	else null;
	
	if($label === null || $label === '') die('Input has no label name. Try again.');
	elseif($label === 'empty') $label = '';
	else null;

	if($value !== null || $value !== '') $insert_value = ' value="'.$value.'" ';
	else $insert_value = null;
	
	$insert_type = 'text';
	
	// This sets the values for the attritubutes.
	if($attrs !== null) {
		
		$insert_attr = '';
			
		foreach($attrs as $attr => $val) {
			if($attr === 'type') $insert_type = $val;
			else {			
				if($val === 'true') $insert_attr .= ' '.$attr;
				else $insert_attr .= ' '.$attr.'="'.$val.'" ';
			}
		}

	} else $insert_attr = null;
	
	echo '<div class="field-container">
			<input type="'.$insert_type.'" id="fl_'.$name.'" name="'.$name.'" placeholder="'.$label.'" data-place="'.$label.'" '.$insert_value.' '.$insert_attr.'>
			<label for="'.$name.'">'.$label.'</label>
		  </div>';
}


function place_dropdown($name = null, $label = null, $list = null, $value = null, $attrs = null) {
	
	/*
		Will need to pass: 
		- name, label and list (required)
		
		- all the other attributes are optional, value cannot be array. Attributes needs to be passed as an ARRAY.
		- if using readonly, which doesn't have a value, set value as 'true'. See example:
		
		$value = array('readonly' => 'true', 'required' => 'true');
		
		This will require to add the form helper from codeigniter.
					
	*/
	
	if($name === null || $name === '') die('Input has no name. Try again.');
	else null;
	
	if($label === null || $label === '') die('Input has no label name. Try again.');
	else null;

	if($list === null || $list === '') die('No list has been added to dropdown option. Try again.');
	else {
		$list_options = ''; 
		foreach($list as $option) {
			$list_options .= '<li>'.$option.'</li>';
		}
	}

	if($value !== null || $value !== '') $insert_value = ' value="'.$value.'" ';
	else $insert_value = null;
	
	if($attrs !== null) {
		
		$insert_attr = '';
		
		foreach($attrs as $attr => $val) {								
			if($val === 'true') {
				$insert_attr .= ' '.$attr;
			} else{
				$insert_attr .= ' '.$attr.'="'.$val.'" ';	
			}
		}
	} else $insert_attr = null;
	
	
	echo '<div class="field-container">
			<i class="fa fa-caret-down" aria-hidden="true"></i>
			<input type="text" class="dropdown" id="fl_'.$name.'" name="'.$name.'" placeholder="'.$label.'" data-place="'.$label.'" '.$insert_value.' '.$insert_attr.' readonly>
			<label for="'.$name.'">'.$label.'</label>
			<ul id="'.$name.'" class="dropdown-list">
				'.$list_options.'
			</ul>
          </div>';
	
}

function place_textarea($name = null, $label = null, $value = null, $attrs = null) {

	/*
		Will need to pass: 
		- name (required)
		- all the other attributes are optional, need to be passed as an ARRAY.
		- if using readonly, which doesn't have a value, set value as null. See example:
		
		$attrs = array('readonly' => null, 'required' => null);
		
		This will require to add the form helper from codeigniter.
					
	*/
	
	if($name === null || $name === '') die('Input has no name. Try again.');
	else null;
	
	if($label === null || $label === '') die('Input has no label name. Try again.');
	else null;
	
	$insert_type = 'text';
	
	if($attrs !== null) {
		
		$insert_attr = '';
			
		foreach($attrs as $attr => $val) {	
			if($val === 'true') {
				$insert_attr .= ' '.$attr;
			} else{
				$insert_attr .= ' '.$attr.'="'.$val.'" ';	
			}
		}
	} else $insert_attr = null;
	
	echo '<div class="field-container">
            <textarea id="fl_'.$name.'" placeholder="'.$label.'" data-place="'.$label.'" name="'.$name.'" '.$insert_attr.'>'.$value.'</textarea>
            <label for="'.$name.'">'.$label.'</label>
          </div>';

}


