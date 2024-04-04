<?php

  global $capsule;

    $registerPageID    = 66;
    $loginPageID       = 64;
    $editProfilePageID = 70;


    $mainSiteId = $capsule::table('nc_sites_groups')
                          ->where('group_site_key', get_locale())
                          ->first()->main_site_id;
                          
    switch_to_blog($mainSiteId);

    $loginUrl = get_permalink($loginPageID);
    $registerUrl = get_permalink($registerPageID);

    restore_current_blog();

    if (is_home()) {
        $logoutUrl = get_home_url();
    } else {
        $logoutUrl = get_permalink();
    }



echo '<div id="loginStuff">';

if (is_user_logged_in()) {
    global $current_user;

    wp_get_current_user();//get_currentuserinfo();
    //vamos a poner su nombre de usuario.
    echo '<div id="userName">';
    echo _x('Usuario', 'Header', 'iol_theme').': <span id="spanUserName">' . $current_user->user_login .'</span>' ;
    echo '</div>';
    //Ver/Editar perfil

    $editProfile = _x('Editar Perfil', 'header', 'iol_last');

    echo '<a href="';
    echo get_permalink($editProfilePageID);                    /*echo get_edit_user_link();*/
    echo '">'.$editProfile.'</a>';

    echo '&nbsp;&nbsp;';
    //Cerrar sesión
    echo '<a href="';
    echo wp_logout_url($logoutUrl);
    echo '" title="Logout" class="noGotoMain">'._x('Cerrar Sesión', 'Header', 'iol_theme').'</a>';
} else {
    //Le damos la opción de hacer login o registrarse.

    //LogIn
    echo '<a href="';
    echo $loginUrl;
    echo '" title="Login">'._x('Login', 'Header', 'iol_theme').'&nbsp;|</a>';//Cambiado desde mayúsculas

    echo '&nbsp;';
    //Registrarse
    echo '<a href="';
    echo $registerUrl;//wp_registration_url();
    echo '" title="Register">'._x('Registrarse', 'Header', 'iol_theme').'</a>';//Cambiado desde mayúsculas


    echo '<div id="userName">';
    echo '<span id="spanNotUserName">'._x('No ha iniciado sesión', 'Header', 'iol_theme').'</span>' ; /*Usuario: <span id="spanUserName">' . $current_user->user_login .'</span>*/
    echo '</div>';
}

echo '</div>';
//Fin de loginStuff
