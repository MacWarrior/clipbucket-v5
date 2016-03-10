<?php
	
	function push_custom_field($data = false) {
		global $db;
		if (!is_array($data)) {
			$data = $_POST;
		}
		
		$name = $data['fieldname'];
		$label = $data['fieldtitle'];
		$type = $data['type'];
		$df_val = $data['default_value'];
		$ptype = $data['type_page'];
		$flds = array('custom_field_name','custom_field_title','custom_field_type','custom_field_value','custom_field_ptype');
		$vals = array($name, $label, $type, $df_val, $ptype);
		$insert_id = $db->insert(tbl("custom_fields"), $flds, $vals);
		if ($insert_id) {
			return $insert_id;
		} else {
			return false;
		}
	}

?>