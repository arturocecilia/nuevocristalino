<?php



function printNCRgpd()
{
    $rgpd_form ='';
    $rgpd_form .= '<div class="rgpd">';
    $rgpd_form .= '<label class="checkbox">';
    $rgpd_form .= '<input type="checkbox" id="privacy_agree" name="privacy_agree" value="privacy_agree">';
    $rgpd_form .= '<span class="rgpdcheckboxtext">'._x('Acepto las condiciones', 'nc_login_registration', 'nc-login-registration').'</span>';
    $rgpd_form .= '</label>';
    $rgpd_form .= '<ul>';
    $rgpd_form .= '<li><span class="title">'._x('Responsable de los datos', 'nc_login_registration', 'nc-login-registration').':</span> Andomed SL.</li>';
    $rgpd_form .= '<li><span class="title">'._x('Finalidad', 'nc_login_registration', 'nc-login-registration').': </span>';
    $rgpd_form .= _x('Envío de información personalizada junto con las credenciales de acceso y uso del sistema como usuario registrado.', 'nc_login_registration', 'nc-login-registration');
    $rgpd_form .= '</li>';
    $rgpd_form .= '<li><span class="title">'._x('Legitimizacion', 'nc_login_registration', 'nc-login-registration').':</span> '._x('La aceptación de la', 'nc_login_registration', 'nc-login-registration').' <a class="noGotoMain" href="https://www.nuevocristalino.es/politica-de-privacidad/">'._x('Política de Privacidad', 'nc_login_registration', 'nc-login-registration').'</a>.</li>';
    $rgpd_form .= '<li><span class="title">'._x('Destino', 'nc_login_registration', 'nc-login-registration').':</span> '._x('Una base de datos gestionada por Andomed SL', 'nc_login_registration', 'nc-login-registration').'</li>';
    $rgpd_form .= '<li><span class="title">'._x('Derechos', 'nc_login_registration', 'nc-login-registration').':</span> '._x('Tienes derecho al derecho al acceso, rectificación, supresión, limitación, portabilidad y olvido de sus datos', 'nc_login_registration', 'nc-login-registration').'</li>';
    $rgpd_form .= '</ul>';
    $rgpd_form .= '</div>';

    return $rgpd_form;
}
