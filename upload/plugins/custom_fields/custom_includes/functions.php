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

	function pull_custom_fields($type = false, $id = false) {
		global $db;
		if ($type) {
			$cond = "custom_field_ptype = '$type'";
		}
		if ($id) {			
			$cond = "custom_field_list_id = '$id'";
			if ($type) {
				$cond .= " AND custom_field_ptype = '$type'";
			}
		}
		$raw_pull = $db->select(tbl("custom_fields"),"custom_field_list_id,custom_field_title,custom_field_type,custom_field_ptype,custom_field_name,custom_field_value,custom_field_required",$cond);
		if (is_array($raw_pull)) {
			return $raw_pull;
		} else {
			return false;
		}
	}

	function update_cstm_field($data = false, $id = false) {
		if (!is_array($data)) {
			$data = $_POST;
		}

		if (!$id) {
			$id = $_GET['custom_edit'];
		}
	}

?>