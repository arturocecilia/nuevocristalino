<?php

use App\Models\NcSync;

function myprefix_edit_form_after_title()
{
    global $post;
    global $ncWPSites;
    global $wpdb;
    //Sacamos el id del post en cuestión.

    $id = $post->ID;


    $ncsync = NcSync::where(get_locale(), $post->ID)->first();

    if (is_null($ncsync)) {
        echo '<div>No hay sincronización disponible</div>';
        return;
    }


    //Aquí vamos a mostrar a google la canonización según países.
    $ncWPSitesCopy = $ncWPSites;

    //unset($ncWPSites[get_locale()]);



    echo '<table>';
    echo '<tr style="height:35px;">';
    echo '<td  style="width:50px;">SITIO</td>';
    echo '<td style="width:200px;">Título del Contenido </td>';
    echo '<td><a style="text-decoration:none;">LINK <span style="font-size:10px;">URL</span></a>';
    echo '</td><td style="padding-left:30px;">EDITAR</td><td style="width:30px;"></td>';
    echo '</tr>';

    foreach ($ncWPSitesCopy as $key=>$value) {
        switch_to_blog($value);

        $post_id = $ncsync->{$key};
        echo '<tr>';
        echo '<td style="width:50px;">'.$key.'</td>';
        echo '<td style="width:200px;">'.get_the_title($post_id).'</td>';
        echo '<td><a href="'. get_permalink($post_id).'" style="text-decoration:none;">Ir a Verlo <br />';
        echo '<span style="font-size:10px;">('.str_replace(array('www.nuevocristalino','www.neuelinsen.com','www.newlens.co','www.nouveaucristallin.com','www.mylifestylelens.com'), 'nc', get_permalink($post_id)).')</span></a></td>';
        echo '<td style="padding-left:30px;">';
        echo'<a href="'.admin_url('post.php?post='.$post_id.'&action=edit').'">Editarlo</a>';

        echo '</tr>';
        restore_current_blog();
    }

    echo '</table>';
    echo '<br /><br />';
    //switch_to_blog(3); -> El hacer un switch sin haber hecho el restore antes lo estaba jodiendo todo.
}


function syncPropaga_form_after_editor()
{
    global $ncWPSites;

    $ncWPSitesCopy = $ncWPSites;

    echo '<h3>Precaución: A continuación tiene la opción de propagar estos datos a otro site de nuevocristalino.</h3>';
    echo '<p>Si deja el input correspondiente a la versión en blanco o con un 0, no se lleva a cabo acción alguna.<br />';
    echo '<span style="margin-left:40px;"><strong>1</strong> Sólo se actualizarán las taxonomías.</span>';
    echo '<span style="margin-left:40px;"><strong>2</strong> Sólo los metadatos.</span><br />';
    echo '<span style="margin-left:40px;"><strong>3</strong> Se propagarán las taxonomías y los metadatos.</span>';
    echo '<span style="margin-left:40px;"><strong>4</strong> Se propagarán el excerpt y los contenidos.</span></br>';
    echo '<span style="margin-left:40px;"><strong>5</strong> Se propagará la featured image.</span>';
    echo '<span style="margin-left:40px;"><strong>6</strong> Se propagará toda la info menos el content y el excerpt.</span><br />';
    echo '<span style="margin-left:40px;">7</strong> se propagará toda la información de este post-type</span></p>';

    //Vamos con los inputs.
    echo '<tr>';
    foreach ($ncWPSitesCopy as $key=>$value) {
        echo '<td style="">';
        echo '<span style="padding-left:25px;">'.$key.'</span><input style="width:35px;" type="text" name="'.$value.'_'.$key.'" />';
        echo '</td>';
    }
    echo '</tr>';
    echo '<br>Si rellenta el siguiente campo borrará el post en todos los sites¡¡¡';
    echo '<tr>';
    echo '<span style="padding-left:25px;">BORRADO¡¡</span><input style="width:35px;" type="text" name="delete" />';
    echo '</tr>';
    echo '<div style="height:20px;">&nbsp;</div>';
}


function sync_translation_status($post)
{
    global $locale;
    global $post;
    global $ncWPSites;

    $ncsync = NcSync::where($locale, $post->ID)->first();

    echo '<p>Recuerde si está traducido es un 1, si no lo está: va un 0 o en blanco, si es un 2 es que es una lengua similar que únicamente requiere adaptación (ej: Español de España, español de Méjico)</p>';
    echo '<p>Estos campos son importantes de cara a informar a los buscadores que los contenidos están relacionados. También informan a la persona que edite el post si ha de "propagar" o no los cambios</p>';


    foreach ($ncWPSites as $site_key => $site_id) {
        echo '<div style="margin-bottom:10px; width:48%;float:left;">';
        echo '<label style="display:inline-block;width:70px;margin-left:10px;">'.$site_key.': </label>';
        echo '<input type="text" name="'.$site_key.'_status" value="'.$ncsync->{$site_key.'_status'}.'" />';
        echo '</div>';
    }
    echo '<div style="clear:both;">&nbsp;</div>';
}
