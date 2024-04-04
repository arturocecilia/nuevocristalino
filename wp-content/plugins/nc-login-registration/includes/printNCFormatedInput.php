<?php


function printNCFormatedInput($input_type, $input_name, $value, $input_placeholder, $class ='', $label = false, $numerated=false, $arrayOptions=[], $disabled= false)
{
    if (in_array($input_type, ['text','password'])) {
        $input_form ='';
        $input_form .= '<div class="question_bloq input_text '.$class.'">';
        $input_form .= '<div class="question_wrapper">';

        if ($numerated) {
            $input_form .= '<div class="question_number"></div>';
        }


        if ($label) {
            $input_form .= '<label class="udm_question_label">';
            $input_form .= '<span class="title_question">'._x($label, 'nc_login_registration', 'nc-login-registration').'</span>';
            $input_form .= '</label>';
        }

        if ($disabled) {
            $disabled = 'disabled="disabled" ';
        } else {
            $disabled= '';
        }


        $input_form .= '<div class="input_wrapper">';
        $input_form .= '<input type="'.$input_type.'" '.$disabled.' name="'.$input_name.'" value="'.$value.'" placeholder="'._x($input_placeholder, 'nc_login_registration', 'nc-login-registration').'" />';
        $input_form.= '</div>';
        $input_form .= '</div>';
        $input_form .= '</div>';
        return $input_form;
    }

    //
    if ($input_type == 'radio') {
        $radio_form ='';
        $radio_form.='<div class="question_bloq input_radio_checkbox" id="'.$input_name.'_input">';
        $radio_form.= '<div class="question_wrapper" id="">';

        if ($numerated) {
            $radio_form .= '<div class="question_number"></div>';
        }

        $radio_form.= '<div class="question_title udm_question_label" id="">';
        $radio_form.= '<span class="title_question">'._x($label, 'nc_login_registration', 'nc-login-registration').'</span>';
        $radio_form.= '</div>';
        $radio_form.= '<div class="inputs_wrapper">';
        $radio_form.= '<div class="question_inputs" id="" data-buttonset="vertical" style="display: table; margin-bottom: 7px;">';

        foreach ($arrayOptions  as $input_value => $input_label) {
            $radio_form .= '<input type="'.$input_type.'" id="'.$input_value.'_input_radio" name="'.$input_name.'" '.checked($value, $input_value, false).' value="'.$input_value.'" />';
            $radio_form .= '<label for="'.$input_value.'_input_radio">'._x($input_label, 'nc_login_registration', 'nc-login-registration').'</label>';
        }

        $radio_form.= '</div>';
        $radio_form.= '</div>';
        $radio_form.= '</div>';
        $radio_form.= '</div>';


        $radio_form.= '<script>jQuery(\'input[name="ncusertype"]\').change(function(){

        var ncusertype = jQuery(this).val();

        if(ncusertype === \'prof\'){

          if(jQuery("#p_preOrPost_input").length){
            jQuery("#p_preOrPost_input").css("display", "none");
          }
          if(jQuery("#p_sxInteres_input").length){
                        jQuery("#p_sxInteres_input").css("display", "none");
            }
        }
          if(ncusertype === \'pat\'){

            if(jQuery("#p_preOrPost_input").length){
              jQuery("#p_preOrPost_input").css("display", "block");
            }
            if(jQuery("#p_sxInteres_input").length){
                jQuery("#p_sxInteres_input").css("display", "block");
            }
          }
        })
        </script>';




        return $radio_form;
    }


    //

    if ($input_type == 'select') {
        $select_form ='';
        $select_form .= '<div class="question_bloq input_select" id="'.$input_name.'_input">';
        $select_form .= '<div class="question_wrapper" >';
        if ($numerated) {
            $select_form .= '<div class="question_number"></div>';
        }
        $select_form .= '<div class="question_title udm_question_label" >';
        $select_form .= '<span class="title_question">'._x($input_placeholder, 'nc_login_registration', 'nc-login-registration').'</span>';
        $select_form .= '</div>';


        $select_form .= '<div class="inputs_wrapper">';
        $select_form .= '<div class="question_inputs  toCombobox">';
        $select_form .= '<select name="'.$input_name.'" id="" class="toCombobox" style="display: none;">';

        foreach ($arrayOptions  as $option_value => $option_label) {
            $select_form .= '<option class="optionSelect" name="'.$input_name.'" '.selected($value, $option_value, false).' value="'.$option_value.'">'._x($option_label, 'nc_login_registration', 'nc-login-registration').'</option>';
        }
        $select_form .= '</select>';
        $select_form .= '</span>';
        $select_form .= '</div>';
        $select_form .= '</div>';
        $select_form .= '</div>';
        $select_form .= '</div>';

        return $select_form;
    }
}




//$signup_form.= '<input type="'.$input_type.'"  id="input_o_userProfEmailIndustry_Yes" name="o_inEmailingIndustry" value="a">';
//$signup_form.= '<label for="input_o_userProfEmailIndustry_Yes">Sí, estoy interesado.</label>';
//$signup_form.= '<input type="radio" id="input_o_userProfEmailIndustry_No" name="o_inEmailingIndustry" value="o_inEmailingIndustry_No" >';
//$signup_form.= '<label for="input_o_userProfEmailIndustry_No" >No estoy interesado</label>';
