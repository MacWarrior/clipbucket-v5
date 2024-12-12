<?php

class formObj
{
    var $multi_cat_id = 0;

    /**
     * FUNCTION USED TO CREATE TEXT FIELD
     *
     * @param      $field
     * @param bool $multi
     * @param bool $skipall
     *
     * @return bool|string|void
     * @throws Exception
     */
    function createField($field, $multi = false, $skipall = false)
    {
        $field['sep'] = $field['sep'] ?: '<br>';

        switch ($field['type']) {
            case 'textfield':
            case 'password':
            case 'hidden':
            case 'textarea':
            default:
                $field['type'] = $field['type'] ?: 'textfield';
                $fields = $this->createTextfield($field, $multi);
                break;

            case 'checkbox':
                $fields = $this->createCheckBox($field, $multi);
                break;

            case 'radiobutton':
                $fields = $this->createRadioButton($field, $multi);
                break;

            case 'dropdown':
                $fields = $this->createDropDown($field, $multi, $skipall);
                break;

            case 'checkboxv2':
                $fields = $this->createCheckBoxV2($field);
                break;
        }
        return $fields;
    }


    /**
     * FUNCTION USED TO CREATE TEXT FIELD
     *
     * @param      $field
     * @param bool $multi
     *
     * @return string
     */
    function createTextfield($field, $multi = false): string
    {
        $textField = '';
        //Starting Text Field
        if ($field['type'] == 'textfield') {
            $textField = '<input type="text"';
        } elseif ($field['type'] == 'password') {
            $textField = '<input type="password"';
        } elseif ($field['type'] == 'hidden') {
            $textField = '<input type="hidden"';
        } elseif ($field['type'] == 'textarea') {
            $textField = '<textarea';
        }

        if ($field['type'] == 'textfield' || $field['type'] == 'password') {
            $textField .= ' placeholder="' . $field['placehoder'] . '"';
        }

        if (!empty($field['name'])) {
            if (!$multi) {
                $textField .= ' name="' . $field['name'] . '"';
            } else {
                $textField .= ' name="' . $field['name'] . '[]"';
            }
        }
        if (!empty($field['id'])) {
            $textField .= ' id="' . $field['id'] . '"';
        }
        if (!empty($field['class'])) {
            $textField .= ' class="' . $field['class'] . '"';
        }
        if (!empty($field['title'])) {
            $textField .= ' title="' . $field['title'] . '"';
        }
        if (!empty($field['size'])) {
            if ($field['type'] == 'textfield' || $field['type'] == 'password') {
                $textField .= ' size="' . $field['size'] . '"';
            } else {
                $textField .= ' cols="' . $field['size'] . '"';
            }
        }
        if (!empty($field['rows']) && $field['type'] == 'textarea') {
            $textField .= ' rows="' . $field['rows'] . '"';
        }

        if (!empty($field['extra_tags'])) {
            $textField .= ' ' . $field['extra_tags'];
        }

        if (!empty($field['disabled'])) {
            $textField .= ' disabled';
        }

        if (!empty($field['value'])) {
            if ($field['type'] == 'textfield' || $field['type'] == 'password' || $field['type'] == 'hidden' ) {
                $textField .= ' value="' . display_clean($field['value']) . '" ';
            }
        }

        if ($field['type'] == 'textarea') {
            $field['value'] =
            $textField .= '>' . display_clean($field['value']);
        }

        //Finishing It
        if ($field['type'] == 'textfield' || $field['type'] == 'password' || $field['type'] == 'hidden' ) {
            $textField .= ' >';
        } elseif ($field['type'] == 'textarea') {
            $textField .= '</textarea>';
        }

        //Checking Label
        if (!empty($field['label'])) {
            $formTextField = '<label>' . $field['label'] . $textField . '</label>';
        } else {
            $formTextField = $textField;
        }

        return $formTextField;
    }

    /**
     * FUNCTION USED TO CREATE CHECK BOXES
     *
     * @param name
     * @param id
     * @param value = array('value'=>'name')
     * @param class
     * @param extra_tags
     * @param label
     *
     * @return bool|string|void
     * @throws Exception
     */
    function createCheckBox($field, $multi = false)
    {
        //First Checking if value is CATEGORY
        if ($field['id'] == 'category') {
            //Generate Category list
            $type = $field['category_type'] ?: 'video';

            $catArray = getCategoryList(['type' => $type]);

            if (is_array($catArray)) {
                $this->multi_cat_id = $this->multi_cat_id + 1;
                $params['categories'] = $catArray;
                $params['field'] = $field;
                if (config('show_collapsed_checkboxes') == 1) {
                    $params['collapsed'] = true;
                }
                $this->listCategoryCheckBox($params, $multi);
                return false;
            }
            return 'There is no category to select';
        }

        if ($multi) {
            global $multi_cat_id;
            @$multi_cat_id++;
        }

        $count = 0;
        if (!is_array($field['value'])) {
            $field['value'] = explode(',', $field['value']);
        }

        foreach ($field['value'] as $key => $value) {
            $count++;

            if (is_array($value)) {
                foreach ($value as $cat_val) {
                    if ($cat_val == $key || $field['checked'] == 'checked') {
                        $checked = ' checked ';
                        break;
                    } else {
                        $checked = '';
                    }
                }
            }

            if (!$multi) {
                $field_name = $field['name'];
            } else {
                $field_name = $field['name'];
                $field_name = $this->rmBrackets($field_name);
                $field_name = $field_name . $multi_cat_id . '[]';
            }

            if (!empty($field['id'])) {
                $field_id = ' id="' . $field['id'] . '" ';
            }

            if ($count > 0) {
                if (!isset($field['notShowSeprator'])) {
                    echo $field['sep'];
                }
            }

            if ($field['wrapper_class']) {
                echo '<div class="' . $field['wrapper_class'] . '">';
            }

            $label_class = '';

            if ($field['label_class']) {
                $label_class = 'class="' . $field['label_class'] . '"';
            }
            if (!empty($field['disabled'])) {
                $disabled = ' disabled';
            }

            echo '<label ' . $label_class . '> <input name="' . $field_name . '" type="checkbox" value="' . $key . '" ' . $field_id . ' ' . $checked . ' '.$disabled.' ' . $field['extra_tags'] . '> ' . $value . '</label>';

            if ($field['wrapper_class']) {
                echo '</div>';
            }
        }
    }

    function createCheckBoxV2($field)
    {
        $field_label = $field['label'];
        $field_name = $field['name'];
        $field_value = $field['value'];
        $field_disabled = $field['disabled'];
        $checked = ($field['checked'] == $field_value) ? 'checked' : '';

        echo '
        <div class="col-md-1">
            <input value="' . $field_value . '" name="' . $field_name . '" id="' . $field_name . '" ' . $checked . ' '. $field_disabled . 'type="checkbox" class="ace ace-switch ace-switch-5"/>
            <span class="lbl"></span>
        </div>
        <div class="col-md-7">
            <label class="nowrap" for="' . $field_name . '" title="' . $field_label . '">' . $field_label . '</label>
        </div>
        ';
    }

    function listCategoryCheckBoxCollapsed($in, $multi)
    {
        $cats = $in['categories'];
        $field = $in['field'];
        $rand = (rand(0, 100000));
        if ($field['sep'] == '<br/>' || $field['sep'] == '<br>') {
            $field['sep'] = '';
        }

        if (!$multi) {
            $fieldName = $field['name'];
        } else {
            $fieldName = $field['name'];
            $fieldName = $this->rmBrackets($fieldName);
            $fieldName = $fieldName . $this->multi_cat_id . '[]';
        }
        $display = 'none';

        if ($cats) {
            foreach ($cats as $cat) {
                $checked = '';
                if( in_array($cat['category_id'], $field['value']) ){
                    $checked = 'checked';
                }

                echo "<div style='position:relative;'>";
                echo $field['sep'];
                echo '<label><input name="' . $fieldName . '" type="checkbox" value="' . $cat['category_id'] . '" ' . $checked . ' ' . $field['extra_tags'] . '>' . display_clean($cat['category_name']) . '</label>';
                if ($cat['children']) {
                    echo "<span id='" . $cat['category_id'] . "_toggler' alt='" . $cat['category_id'] . "_" . $rand . "' class='CategoryToggler CheckBoxCategoryToggler glyphicon glyphicon-chevron-down' style='float:right;margin-left:20px;' onclick='toggleCategory(this);'></span>";
                    $childField = $field;
                    $childField['sep'] = $field['sep'] . str_repeat('&nbsp;', 5);
                    echo "<div id='" . $cat['category_id'] . '_' . $rand . "' class='sub_categories sub_categories_checkbox' style='display:" . $display . "'>";
                    $this->listCategoryCheckBoxCollapsed(['categories' => $cat['children'], 'field' => $childField, 'children_indent' => true], $multi);
                    echo '</div>';
                }
                echo '</div>';
            }
        }
    }

    //Creating checkbox with indent for category childs
    function listCategoryCheckBox($in, $multi)
    {
        $cats = $in['categories'];
        $field = $in['field'];
        $collapsed = $in['collapsed'];
        if ($collapsed) {
            $this->listCategoryCheckBoxCollapsed($in, $multi);
            return;
        }
        //setting up the field name
        if (!$multi) {
            $field_name = $field['name'];
        } else {
            $field_name = $field['name'];
            $field_name = $this->rmBrackets($field_name);
            $field_name = $field_name . $this->multi_cat_id . '[]';
        }

        //Setting up the values
        $values = $field['value'];
        if ($cats) {
            foreach ($cats as $cat) {
                $checked = '';
                //checking value
                if (in_array($cat['category_id'] , $values)) {
                    $checked = 'checked';
                }

                $label_class = '';
                if ($field['label_class']) {
                    $label_class = 'class="' . $field['label_class'] . '"';
                }
                if (!isset($field['notShowSeprator'])) {
                    echo $field['sep'];
                }
                echo '<label ' . $label_class . '><input name="' . $field_name . '" type="checkbox" value="' . $cat['category_id'] . '" ' . $checked . ' ' . $field['extra_tags'] . '> ' . display_clean($cat['category_name']) . '</label>';
                if ($cat['children']) {
                    $childField = $field;
                    $childField['sep'] = $field['sep'] . str_repeat('&nbsp;', 5);
                    $this->listCategoryCheckBox(['categories' => $cat['children'], 'field' => $childField, 'children_indent' => true], $multi);
                }
            }
        }
    }

    /**
     * FUNCTION USED TO CREATE RADIO Button
     * @param name
     * @param id
     * @param value = array('value'=>'name')
     * @param class
     * @param extra_tags
     * @param label
     */
    function createRadioButton($field, $multi = false)
    {
        //Creating Fields
        $count = 0;
        $sep = $field['sep'];
        $arrayName = $this->rmBrackets($field['name']);
        if (!is_array($field['value'])) {
            $field['value'] = explode(',', $field['value']);
        }
        foreach ($field['value'] as $key => $value) {
            if ((is_array($_POST) && !empty($_POST[$arrayName])) || !empty($field['checked'])) {
                if ((is_array($_POST) && $_POST[$arrayName] == $key) || $field['checked'] == $key) {
                    $checked = ' checked ';
                } else {
                    $checked = '';
                }
            } else {
                if ($count == 0) {
                    $checked = ' checked ';
                } else {
                    $checked = '';
                }
                $count++;
            }
            if (!empty($field['id'])) {
                $field_id = ' id="' . $field['id'] . '" ';
            }

            if (!$multi) {
                $field_name = $field['name'];
            } else {
                $field_name = $field['name'] . '[]';
            }

            $class = '';
            if (!empty($field['class'])) {
                $class = ' class="' . $field['class'] . '"';
            }

            $title = '';
            if (!empty($field['title'])) {
                $title = ' title="' . $field['title'] . '"';
            }

            if ($field['wrapper_class']) {
                echo '<div class="' . $field['wrapper_class'] . '">';
            }

            $label_class = '';
            if ($field['label_class']) {
                $label_class = 'class="' . $field['label_class'] . '"';
            }
            if (!empty($field['disabled'])) {
                $disabled = ' disabled';
            }

            echo '<label ' . $label_class . '> <input name="' . $field_name . '" type="radio" value="' . $key . '" ' . $field_id . ' ' . $class . ' ' . $title . ' ' . $checked . ' ' . $disabled . ' ' . $field['extra_tags'] . '>' . $value . '</label>';

            if ($field['wrapper_class']) {
                echo '</div>';
            }

            echo (isset($field['notShowSeprator'])) ? '' : $sep;
        }
    }

    /**
     * FUNCTION USED TO REMOVE BRACKET FROM FIELD NAME IF IT IS AN ARRAY
     *
     * @param string $string with brackets
     *
     * @return string|string[]|null
     */
    static function rmBrackets($string)
    {
        return preg_replace('/\[\]/', '', $string);
    }

    private function getCategories($catArray, $skipall = false, $level = 0): array
    {
        $data = [];
        foreach ($catArray as $categorie) {
            if ($skipall && $categorie['category_id'] == 'all') {
                continue;
            }

            $data[$categorie['category_id']] = str_repeat('&nbsp;', $level * 2) . $categorie['category_name'];
            if (isset($categorie['children'])) {
                $sub_categories = $this->getCategories($categorie['children'], $skipall, ($level + 1));
                foreach ($sub_categories as $sub_id => $sub_name) {
                    $data[$sub_id] = $sub_name;
                }
            }
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    function createDropDown($field, $multi = false, $skipall = false)
    {
        //First Checking if value is CATEGORY
        if ($field['value'][0] == 'category') {
            //Generate Category list
            $catArray = getCategoryList(['type' => $field['category_type'], 'with_all' => true]);

            $field['value'] = $this->getCategories($catArray, $skipall);
        }

        if (!$multi) {
            $field_name = $field['name'];
        } else {
            $field_name = $field['name'] . '[]';
        }

        $select = '';
        if (!empty($field['id'])) {
            $select .= ' id="' . $field['id'] . '"';
        }

        if (!empty($field['class'])) {
            $select .= ' class="' . $field['class'] . '"';
        }

        if (!empty($field['disabled'])) {
            $select .= ' disabled';
        }

        $hidden = '';
        if (!empty($field['input_hidden'])) {
            $hidden = '<input type="hidden" name="' . $field_name . '" value="' . $field['checked'] . '">';
        }

        $ddFieldStart = '<select name=\'' . $field_name . '\'' . $select . '>';
        $arrayName = $this->rmBrackets($field['name']);
        if (is_string($field['value'])) {
            $field['value'] = explode(',', $field['value']);
        }
        $fieldOpts = '';
        if (is_array($field['value'])) {
            foreach ($field['value'] as $key => $value) {
                if ((is_array($_REQUEST) && !empty($_REQUEST[$arrayName])) || !empty($field['checked'])) {
                    if ((is_array($_REQUEST) && $_REQUEST[$arrayName] == $key) || $field['checked'] == $key) {
                        $checked = ' selected ';
                    } else {
                        $checked = '';
                    }
                } else {
                    if ($count == 0) {
                        $checked = ' selected ';
                    } else {
                        $checked = '';
                    }
                    $count++;
                }
                $fieldOpts .= '<option value="' . $key . '" ' . $checked . ' ' . $field['extra_tags'] . '>' . $value . '</option>';
            }
        }
        $ddFieldEnd = '</select>';
        echo $hidden . $ddFieldStart . $fieldOpts . $ddFieldEnd;
    }
}
