<?php


function printPostProcessErrors($errors)
{
    $error_message = '';
    $error_message .='<div class="errorMessage">';
    $error_message .='<p>'._x('Lo sentimos no se han rellenado correctamente los datos', 'nc_login_registration', 'nc-login-registration').': </p>';
    $error_message .= '<ul>';
    foreach ($errors as $error) {
        $error_message .='<li>'.$error.'</li>' ;
    }
    $error_message .= '</ul>';
    $error_message .='</div>';

    return $error_message;
}
