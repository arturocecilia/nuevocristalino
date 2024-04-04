<?php




register_nav_menu('primary', 'Menu principal');
register_nav_menu('top-menu', 'Top menu del site');
register_nav_menu('Menu-footer', 'Menú para el footer Legal');
register_nav_menu('Menu-footer2', 'Menú para el footer Redes Sociales');
register_nav_menu('Menu-cat-QA', 'Menú de categorías del qa');

//cambiar la longitud del excerpt
function custom_excerpt_length($length)
{
    return 50;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);



function iol_home_meta()
{
    $date = sprintf(
        '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url(get_permalink()),
        esc_attr(get_the_time()),
        esc_attr(get_the_date('c')),
        esc_html(get_the_date())
    );

    $author = sprintf(
        '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
        esc_attr(sprintf(__('View all posts by %s', 'twentytwelve'), get_the_author())),
        get_the_author()
    );

    printf(
    /*	$utility_text,
        $categories_list,
        $tag_list,*/
        $date,
        $author
    );
}





register_sidebar(array(
'name' => __('qa'),
'id' => 'qa',
'description' => __('A 5 widget area to get a search area in qa', 'iol'),
'before_widget' => '<aside id="%1$s" class="widget-container %2$s">',
'after_widget' => "</aside>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
));



//Función para que sólo salgan los post y no las pages en search.php
function SearchFilter($query)
{
    if ($query->is_search) {
        //$query->set('post_type', 'post');
    }
    if ($query->is_home() && $query->is_main_query()) {
        //echo $query->
        $query->set('posts_per_page', 1);
    }

    return $query;
}
add_filter('pre_get_posts', 'SearchFilter');

//Función a partir de the_answer_list para sacar el markup deseado.
function get_iol_the_answer_list()
{
    global $user_ID, $post;
    $question_id = $post->ID;

    if (($user_ID == 0 && !qa_visitor_can('read_answers', $question_id)) && !current_user_can('read_answers', $question_id)) {
        return;
    }

    $accepted_answer = get_post_meta($question_id, '_accepted_answer', true);

    $answers = new WP_Query(array(
        'post_type' => 'answer',
        'post_parent' => $question_id,
        'post__not_in' => array( $accepted_answer ),
        'orderby' => 'qa_score',
        'posts_per_page' => QA_ANSWERS_PER_PAGE,
        'paged' => get_query_var('paged')
    ));

    if ($accepted_answer && !get_query_var('paged')) {
        array_unshift($answers->posts, get_post($accepted_answer));
    }

    $out = '';

    $out .= get_the_qa_pagination($answers);

    foreach ($answers->posts as $answer) {
        setup_postdata($answer);

        //var_dump($answer);

        $out .= '<div id="answer-' . $answer->ID .'" class="answer">';

        $out .= '<div class="preAnswerBody">';
        $out .= '<div class="answerDate">'.date_i18n("j F, Y", false, $answer->post_date).'</div>';
        $out .= '<div class="barravertical">&nbsp;</div>';
        $out .= get_the_qa_author_box($answer->ID);

        $out .= '</div>';


        $out .=	'<div class="answer-body">';

        do_action('qa_before_answer_content', $answer->ID);

        $out .= '<div id="flecha2">';
        $out .= '</div>';
        $out .= '<div class="answer-content">';
        $out .=	apply_filters('the_content', $answer->post_content);
        $out .=	'<div class="answer-meta">';
        $out .= get_the_qa_action_links($answer->ID);
        $out .= '</div>';
        //$out .= get_the_answer_voting( $answer->ID );

        $out .= '</div>';


        do_action('qa_before_answer_meta', $answer->ID);



        do_action('qa_after_answer_meta', $answer->ID);

        $out .=	'</div>
		</div>';
    }

    get_the_qa_pagination($answers);

    wp_reset_postdata();

    return $out;
}




function iol_answer_list()
{
    echo get_iol_the_answer_list();
}


/* Función para detectar el browser */





//return a conditional browser string
function browser_detect()
{
    $iphone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    $firefox = stripos($_SERVER['HTTP_USER_AGENT'], "Firefox");
    $safari = stripos($_SERVER['HTTP_USER_AGENT'], "Safari");
    $ie = stripos($_SERVER['HTTP_USER_AGENT'], "MSIE");
    $opera = stripos($_SERVER['HTTP_USER_AGENT'], "Opera");
    $chrome = stripos($_SERVER['HTTP_USER_AGENT'], "Chrome");
    //detecting device
    if ($iphone == true) {
        echo "iphone";
    } elseif ($firefox == true) {
        echo "firefox";
    } elseif ($ie == true) {
        echo "explorer";
    } elseif ($chrome == true) {
        echo "chrome";
    } elseif ($safari == true) {
        echo "safari";
    } elseif ($opera == true) {
        echo "opera";
    } else {
        echo "unknown";
    }
};






/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function iol_scripts_styles()
{
    //   if(is_page()){
    //$tempPath = get_stylesheet_directory_uri() . '/js/javascript-menu.js';

    $jsPath = get_stylesheet_directory_uri() . '/js/';

    //wp_enqueue_script('javascript-menu', $tempPath, array(), '1.0', true);

    //wp_enqueue_style('lente-intraocular-style');

    wp_register_script('jquery-cookie', $jsPath.'jquery.cookie.min.js', array('jquery'), '1.0', true);
    //   }
    wp_register_script('qa-js', get_stylesheet_directory_uri().'/js/qa.js', array('jquery'));
    //Encolamos el plugin de validación javascript sólo si es la página del test post-op.

    $tempPathLoad = get_stylesheet_directory_uri() . '/js/theme-load.js';
    wp_enqueue_script('theme-load-js', $tempPathLoad, array('qa-js','jquery-cookie'), '1.0', true);//'jquery-cookie','jquery-ui-tooltip'




    if (is_page()) {//'cuestionario-post-operatorio-de-presbicia-cataratas'
        //echo 'IS_page';
        wp_register_script('jQuery-validator', $jsPath.'jquery.validate.min.js', array('jquery'), '1.0', true);
        //echo $jsPath.'jquery.validate.min.js';
        wp_register_script('SurgeryPostOpValidation', $jsPath.'postOpValidation.js', array('jquery','jQuery-validator'), '1.0', true);

        wp_enqueue_script('jQuery-validator');
        wp_enqueue_script('SurgeryPostOpValidation');
    }
    //wp_enqueue_style( 'twentytwelve-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
    wp_enqueue_script('ajax-lente-intraocular-js');

    //Las fuentes ahora, con el problema de firefox y el cross domain =>> LO HAREMOS A CAPÓN¡¡¡
    //wp_deregister_style('twentytwelve-fonts');
    wp_register_style('fonts', get_stylesheet_directory_uri() . '/fonts/fonts-'.get_locale().'.css');
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('fonts');

    /*-- Vamos a hacer --*/



    //Los estilos particulares de cada país
    wp_register_style('i18n-style', get_stylesheet_directory_uri() . '/css/custom-'.get_locale().'.css');
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('i18n-style');

    //hacemos que el style del theme dependa de fonts y por lo tanto se cargue despues
    //wp_register_style('twentytwelve', get_stylesheet_uri(), array( 'fonts' ));
    //wp_enqueue_style('twentytwelve');

    //Metemos una hoja de estilo nueva para móviles
//     if (current_user_can( 'manage_options' )) {

    wp_register_style('mobile', get_stylesheet_directory_uri() . '/css/mobile.css'); //, array('lente-intraocular-style','i18n-style'), '1.1', 'all'
    wp_enqueue_style('mobile');

    //   }
}
add_action('wp_enqueue_scripts', 'iol_scripts_styles', 20);

/*Voy a meter el script y style de iol en el them */


//add_action('wp_head', 'show_template');
function show_template()
{
    global $template;
    print_r($template);
}

//Vamos a tener una función que que nos devuelva VERDADERO si NO es una petición .
/* Ajax check  */
//La petición es AJAX si se da la siguiente condición:
//if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

//Con lo que si se cumple la siguiente condición la petición NO será ajax

function is_Not_Ajax()
{
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        return true;
    } else {
        return false;
    }
}

//Vamos a quitar la barra negra superior para todos los usuarios que no sean administradores o editores.
// show admin bar only for admins
if (!current_user_can('manage_options')) {
    //add_filter('show_admin_bar', '__return_false');
}
// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
    add_filter('show_admin_bar', '__return_false');
}


//Añadimos campos adicionales al usuario.
//Vamos a añadir lo necesario para aumentar los campos a documentar de los usuarios.
function MD_add_custom_user_profile_fields($user)
{
    ?>


<div id="ncaccwrapper2">

	<h3 id="tUserTitle"><?php echo _x('Tipo de Usuario de NuevoCristalino', 'Functions', 'iol_theme'); ?></h3>

		<table class="form-table">
        <!-- Empezamos por la categoría profesional, necesaria para el sistema -->
		<tr>
			<th>
				<label for="title"><?php echo _x('Paciente o Profesional', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>


			<?php
                      $userType = esc_attr(get_user_meta($user->ID, 'ncusertype', true)); ?>

			  <select name="ncusertype" id="ncusertype">
			  	<option value="pat" <?php selected($userType, 'pat'); ?> >
    <?php echo _x('Paciente', 'Functions', 'iol_theme'); ?>
    </option>

    <option value="prof" <?php selected($userType, 'prof'); ?> >
    <?php echo _x('Profesional', 'Functions', 'iol_theme'); ?>
    </option>

    <option value="" <?php selected($userType, ''); ?> ><?php echo _x('Sin Especificar', 'Functions', 'iol_theme'); ?></option>
  </select>


			</td>
		</tr>



		</table>

</div>
<div id="ncaccwrapper3">
		<h3 id="infoPatTitle"><?php echo _x('Información de su perfil de Paciente', 'Functions', 'iol_theme'); ?></h3>

		<!-- Información sobre el paciente -->
		<table>
		<!-- operado si no -->

		<tr>
			<th>
				<label for="title"><?php echo _x('¿Se ha sometido ya a la operación intraocular?', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>
				<!-- <input type="text" name="address" id="address" value="<?php echo esc_attr(get_the_author_meta('address', $user->ID)); ?>" class="regular-text" /><br />-->

                <?php


                      $sxdone = esc_attr(get_user_meta($user->ID, 'sxdone', true)); ?>

    <select name="sxdone">
        <option value="yes" <?php selected($sxdone, 'yes'); ?> ><?php echo _x('Sí', 'Functions', 'iol_theme'); ?></option>
        <option value="no" <?php selected($sxdone, 'no'); ?> ><?php echo _x('No', 'Functions', 'iol_theme'); ?></option>
        <option value="" <?php selected($sxdone, ''); ?> ><?php echo _x('Sin especificar', 'Functions', 'iol_theme'); ?></option>
    </select>
				<span class="description"><?php echo _x('Puede actualizar este campo cuando quiera, es necesario para que si lo desea, sólo le proveamos con la información que pueda interesarle', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>

		<!-- Fin operado si no -->

		<!-- Cataratas si no-->

		<tr>
			<th>
				<label for="title"><?php echo _x('¿Tiene cataratas u opacidad del cristalino?', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>

        <?php
                      $catopa = esc_attr(get_user_meta($user->ID, 'catopa', true)); ?>

    <select name="catopa">
        <option value="yes" <?php selected($catopa, 'yes'); ?> ><?php echo _x('Sí', 'Functions', 'iol_theme'); ?></option>
        <option value="no" <?php selected($catopa, 'no'); ?> ><?php echo _x('No', 'Functions', 'iol_theme'); ?></option>
        <option value="" <?php selected($catopa, ''); ?> ><?php echo _x('Sin especificar', 'Functions', 'iol_theme'); ?></option>
    </select>
				<span class="description"><?php echo _x('Puede actualizar este campo cuando quiera, es necesario para que si lo desea, sólo le proveamos con la información que pueda interesarle', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>


		<!-- Fin Cataratas si no-->

		<!-- Ini Refrap -->

				<tr>
			<th>
				<label for="title"><?php echo _x('¿Aspira a no necesitar gafas tras la operación o al menos a reducir su dependencia de ellas?', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>

        <?php
                      $refrap = esc_attr(get_user_meta($user->ID, 'refrap', true)); ?>

    <select name="refrap">
        <option value="yes" <?php selected($refrap, 'yes'); ?> ><?php echo _x('Sí', 'Functions', 'iol_theme'); ?></option>
        <option value="no" <?php selected($refrap, 'no'); ?> ><?php echo _x('No', 'Functions', 'iol_theme'); ?></option>
        <option value="" <?php selected($refrap, ''); ?> ><?php echo _x('Sin especificar', 'Functions', 'iol_theme'); ?></option>
    </select>
				<span class="description"><?php echo _x('Puede actualizar este campo cuando quiera, es necesario para que si lo desea, sólo le proveamos con la información que pueda interesarle', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>



		<!-- Fin Refrap -->


		<!-- Comunic patients -->

				<tr>
			<th>
				<label for="title"><?php echo _x('¿Desea recibir información?', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>

        <?php
                      $infocompat = esc_attr(get_user_meta($user->ID, 'infocompat', true)); ?>

    <select name="infocompat">
        <option value="yes" <?php selected($infocompat, 'yes'); ?> ><?php echo _x('Sí', 'Functions', 'iol_theme'); ?></option>
        <option value="no" <?php selected($infocompat, 'no'); ?> ><?php echo _x('No', 'Functions', 'iol_theme'); ?></option>
        <option value="" <?php selected($infocompat, ''); ?> ><?php echo _x('Sin especificar', 'Functions', 'iol_theme'); ?></option>
    </select>
				<span class="description"><?php echo _x('Puede actualizar este campo cuando quiera', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>

		<!-- Fin Com patients -->

		<!-- Información sobre el paciente -->





</table>


	<!-- Vamos a meter aquí los parámetros que nos interesan como paciente -->
<!-- Se ha operado ya? Está pensando en operarse -->
<!-- Tiene cataratas u opacidad del cristalino -->
<!-- Es una aspiración prescindir de las gafas tras la operación? -->
<!-- Desea recibir comunicaciones (Siempre podrá cancelar esta opción)-->




	<h3 id="infoProfTitle"><?php echo _x('Información de su Perfil Profesional', 'Functions', 'iol_theme'); ?></h3>

	<table class="form-table">


				<!-- Metemos lo de comunicaciones del profesional aquí -->

				<tr>
			<th>
				<label for="title"><?php echo _x('¿Desea recibir información?', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>

        <?php
                      $infocomprof = esc_attr(get_user_meta($user->ID, 'infocomprof', true)); ?>

    <select name="infocomprof">
        <option value="yes" <?php selected($infocomprof, 'yes'); ?> ><?php echo _x('Sí', 'Functions', 'iol_theme'); ?></option>
        <option value="no" <?php selected($infocomprof, 'no'); ?> ><?php echo _x('No', 'Functions', 'iol_theme'); ?></option>
        <option value="" <?php selected($infocomprof, ''); ?> ><?php echo _x('Sin especificar', 'Functions', 'iol_theme'); ?></option>
    </select>
				<span class="description"><?php echo _x('Puede actualizar este campo cuando quiera', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>


		<!-- Fin comunicaciones del profesional -->






        <!-- Empezamos por la categoría profesional, necesaria para el sistema -->
		<tr>
			<th>
				<label for="title"><?php echo _x('Categoría Profesional', 'Functions', 'iol_theme'); ?></label>
            </th>
			<td>
				<!-- <input type="text" name="address" id="address" value="<?php echo esc_attr(get_the_author_meta('address', $user->ID)); ?>" class="regular-text" /><br />-->

                <?php

                      $doctor = $optometrista = $gerente = $tecnico = $industria = "";
    $selectedTitle = esc_attr(get_user_meta($user->ID, 'catPro', true));

    //var_dump($selectedTitle);

    switch ($selectedTitle) {
                          case _x('Oftalmólogo', 'Functions', 'iol_theme'):
                                $doctor = 'selected';
                          break;
                          case _x('Optometrista', 'Functions', 'iol_theme'):
                                $optometrista = 'selected';
                          break;

                          case _x('Gerente de Clínica', 'Functions', 'iol_theme'):
                                $gerente = 'selected';
                          break;

                          case _x('Técnico de Clínica', 'Functions', 'iol_theme'):
                                $tecnico= 'selected';
                          break;

                          case _x('Especialista de Industria', 'Functions', 'iol_theme'):
                                $industria = 'selected';
                          break;
                          case _x('Sin Especificar', 'Functions', 'iol_theme'):
                                $se = 'selected';
                          break;
                          case _x('Otros', 'Functions', 'iol_theme'):
                                $other = 'selected';
                          break;

                      } ?>

                <select name="catPro">
                        <option value="<?php echo _x('Oftalmólogo', 'Functions', 'iol_theme'); ?>" <?php echo $doctor; ?> ><?php echo _x('Oftalmólogo', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Optometrista', 'Functions', 'iol_theme'); ?>" <?php echo $optometrista; ?> ><?php echo _x('Optometrista', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Gerente de Clínica', 'Functions', 'iol_theme'); ?>" <?php echo $gerente; ?> ><?php echo _x('Gerente de Clínica', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Técnico de Clínica', 'Functions', 'iol_theme'); ?>" <?php echo $tecnico; ?> ><?php echo _x('Técnico de Clínica (Laser, cálculo de lentes...)', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Especialista de Industria', 'Functions', 'iol_theme'); ?>" <?php echo $industria; ?>><?php echo _x('Especialista de Industria', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Otros', 'Functions', 'iol_theme'); ?>" <?php echo $other; ?> ><?php echo _x('Otros', 'Functions', 'iol_theme'); ?></option>
                        <option value="<?php echo _x('Sin Especificar', 'Functions', 'iol_theme'); ?>" <?php echo $se; ?> ><?php echo _x('Sin Especificar', 'Functions', 'iol_theme'); ?></option>
                 </select>
				<span class="description"><?php echo _x('Por favor rellene cual es su cargo-título.', 'Functions', 'iol_theme'); ?></span>
			</td>
		</tr>





        <!-- Cargo-puesto profesional si quiere especificarlo -->
        <tr>
            <th>
                <label for="cargoPro"><?php echo _x('Cargo que ocupa', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
		<input type="text" name="cargoPro" id="cargoPro" value="<?php echo esc_attr(get_user_meta($user->ID, 'cargoPro', true)); ?>" class="regular-text" /><br />
				<span class="description"><?php echo _x('Si desea especificar o ampliar la categoría profesional anterior, con su cargo o puesto rellene este campo. (ej: especialista en retina...', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>
        <!-- Clínica o Empresa-->
        <tr>
            <th>
                <label for="clinicaEmp"><?php echo _x('Clínicas o Empresa en las que trabaja', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
				<input type="text" name="clinicaEmp" id="clinicaEmp" value="<?php echo esc_attr(get_user_meta($user->ID, 'clinicaEmp', true)); ?>" class="regular-text" /><br />
				<span class="description"><?php echo _x('Señale las clínicas o empresas en las que trabaja separadas por comas', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>

        <!-- Webs de las empresas clínicas donde trabaja -->
        <tr>
            <th>
                <label for="webClinicaEmp"><?php echo _x('Webs de las clínicas o empresas anteriores, separadas por comas y en el mismo orden', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
				<input type="text" name="webClinicaEmp" id="webClinicaEmp" value="<?php echo esc_attr(get_user_meta($user->ID, 'webClinicaEmp', true)); ?>" class="regular-text" /><br />
				<span class="description"><?php echo _x('Señale las webs de sus clínicas o empresas, separadas por comas y en el orden que las ha señalado anteriormente', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>


        <!-- Email de contacto -->
        <tr>
            <th>
                <label for="emailContact"><?php echo _x('Email de contacto', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
				<input type="text" name="emailContact" id="emailContact" value="<?php echo esc_attr(get_user_meta($user->ID, 'emailContact', true)); ?>" class="regular-text" /><br />
				<span class="description"><?php echo _x('Señale el email de contacto', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>

        <!-- pequeño extracto profesional -->

         <tr>
            <th>
                <label for="descProf"><?php echo _x('Pequeña descripción profesional (No es un CV, 200 caracteres máximo)', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
				<textarea name="descProf" id="descProf"  class="regular-text"><?php echo esc_attr(get_user_meta($user->ID, 'descProf', true)); ?> </textarea><br />
				<span class="description"><?php echo _x('Si lo desea escriba una pequeña descripción de su profesión/trayectoria (Ofta)', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>

         <!-- Link a su perfil profesional de linkedIn -->
         <tr>
            <th>
                <label for="linkedIn"><?php echo _x('Enlace a su perfil de linkedIn', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

            <td>
				<input type="text" name="linkedIn" id="linkedIn" value="<?php echo esc_attr(get_user_meta('linkedIn', $user->ID, true)); ?>" class="regular-text" /><br />
				<span class="description"><?php echo _x('Pegue el link de su perfil de linkedIn', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>

 <!-- Pregunta sobre si desea que se muestre su imagen (si no ha subido que no ponga que sí) -->
         <tr>
            <th>
                <label for="imgProp"><?php echo _x('¿De haber subido su imagen, está de acuerdo en que se muestre su en su perfil?', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

             <?php
                $true = $false = $imgProp = "";
    $imgProp = esc_attr(get_user_meta($user->ID, 'imgProp', true));

    /*echo 'El pPublic que viene es :'.$pPublic.'<br />';*/

    switch ($imgProp) {
                    case 'FALSE':
                        $false = 'checked="checked"';
                    break;
                    case 'TRUE':
                        $true = 'checked="checked"';
                    break;
                    default:
                        $false = 'checked="checked"';
                } ?>

            <td>
				<input type="radio" name="imgProp" <?php echo $true; ?>  value="TRUE" /> Sí <br />
				<input type="radio" name="imgProp" <?php echo $false; ?>  value="FALSE" />No <br />

                <span class="description"><?php echo _x('Recuerde que puede dejar cualquiera de ellos en blanco y no saldrán igualmente, puede comprobarlo usted mismo', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>

 <!-- Pregunta de si desea tener perfil público -->
         <tr>
            <th>
                <label for="pPublic"><?php echo _x('¿Desea tener un perfil público con los datos de perfil público apuntados?', 'Functions', 'iol_theme'); ?>
                </label>
            </th>

             <?php
                $true = $false = $pPublic = "";
    $pPublic = esc_attr(get_user_meta($user->ID, 'pPublic', true));

    /*echo 'El pPublic que viene es :'.$pPublic.'<br />';*/

    switch ($pPublic) {
                    case 'FALSE':
                        $false = 'checked="checked"';
                    break;
                    case 'TRUE':
                        $true = 'checked="checked"';
                    break;
                    default:
                        $false = 'checked="checked"';
                } ?>

            <td>
				<input type="radio" name="pPublic" <?php echo $true; ?>  value="TRUE" /> <?php echo _x('Sí', 'Functions', 'iol_theme'); ?> <br />
				<input type="radio" name="pPublic" <?php echo $false; ?>  value="FALSE" /><?php echo _x('No', 'Functions', 'iol_theme'); ?> <br />

                <span class="description"><?php echo _x('Recuerde que puede dejar cualquiera de ellos en blanco y no saldrán igualmente, puede comprobarlo usted mismo', 'Functions', 'iol_theme'); ?></span>
			</td>
        </tr>





	</table>

</div>

        <?php

        //Sólo mostramos los metadatos de usuario si el usuario que los está viendo es superadmin.
            if (current_user_can('manage_options')) {

        //Metemos el custom iol test tal cual desde el template de customTest iol tal cual.

                ////////////////////////////FIN DEL CUSTOM TEST IOL ////////////////////////

                //include('includes/form-customtest-iol.php');
                include('userdata-management/form-preopData.php');
            } ?>


        <?php


            if (current_user_can('manage_options')) {
                include('userdata-management/form-postopData.php');
            } ?>




	<!-- Vamos a meter el javascript -->
	<script>


	 /*
   * hoverIntent | Copyright 2011 Brian Cherne
   * http://cherne.net/brian/resources/jquery.hoverIntent.html
   * modified by the jQuery UI team
   */
   /*
  jQuery.event.special.hoverintent = {
    setup: function() {
      jQuery( this ).bind( "mouseover", jQuery.event.special.hoverintent.handler );
    },
    teardown: function() {
      jQuery( this ).unbind( "mouseover", jQuery.event.special.hoverintent.handler );
    },
    handler: function( event ) {
      var currentX, currentY, timeout,
        args = arguments,
        target = jQuery( event.target ),
        previousX = event.pageX,
        previousY = event.pageY;

      function track( event ) {
        currentX = event.pageX;
        currentY = event.pageY;
      };

      function clear() {
        target
          .unbind( "mousemove", track )
          .unbind( "mouseout", clear );
        clearTimeout( timeout );
      }

      function handler() {
        var prop,
          orig = event;

        if ( ( Math.abs( previousX - currentX ) +
            Math.abs( previousY - currentY ) ) < 7 ) {
          clear();

          event = jQuery.Event( "hoverintent" );
          for ( prop in orig ) {
            if ( !( prop in event ) ) {
              event[ prop ] = orig[ prop ];
            }
          }
          // Prevent accessing the original event since the new event
          // is fired asynchronously and the old event is no longer
          // usable (#6028)
          delete event.originalEvent;

          target.trigger( event );
        } else {
          previousX = currentX;
          previousY = currentY;
          timeout = setTimeout( handler, 100 );
        }
      }

      timeout = setTimeout( handler, 100 );
      target.bind({
        mousemove: track,
        mouseout: clear
      });
    }
  };*/









	jQuery('#editaccwrapper').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });

	jQuery('#ncaccwrapper2').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });

	jQuery('#ncaccwrapper3').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });
    jQuery(document).ready(function(){

    jQuery('.wpua-edit-container > p,.wpua-edit-container > div,.wpua-edit-container > input').wrapAll('<div id="myavatarwrap" />');

    jQuery('.wpua-edit-container').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });

     }
    );
	jQuery('#your-profile>table,#your-profile>h3').css('display','none');



		function tUserConsequences(){
		var tuser = jQuery('#ncusertype').val();

		console.log(tuser);
		switch(tuser) {
			case 'prof':
					jQuery("#ncaccwrapper3").accordion({ active: 1 });
					jQuery('#infoProfTitle').fadeIn('slow');
    				jQuery('#infoProfTitle').next().fadeIn('slow');
					jQuery('#infoPatTitle').fadeOut('slow');
    				jQuery('#infoPatTitle').next().fadeOut('slow');
					if(jQuery('#tWarning').length){
						jQuery('#tWarning').remove();
					}
		    break;
			case 'pat':
					jQuery("#ncaccwrapper3").accordion({  active: 0 });
					jQuery('#infoProfTitle').fadeOut('slow');
					jQuery('#infoProfTitle').next().fadeOut('slow');
					jQuery('#infoPatTitle').fadeIn('slow');
					jQuery('#infoPatTitle').next().fadeIn('slow');
					if(jQuery('#tWarning').length){
						jQuery('#tWarning').remove();
					}

			break;
			case '':
					//Abrimos el accordion de tipo de usuario.
					//Añadimos warning antes de todo.
					//Ponemos fondo de color.
					jQuery("#ncaccwrapper2").accordion({  active: 0 });
					jQuery('#infoProfTitle').fadeOut('slow');
					jQuery('#infoProfTitle').next().fadeOut('slow');
					jQuery('#infoPatTitle').fadeOut('slow');
					jQuery('#infoPatTitle').next().fadeOut('slow');
					jQuery('.intro-tml').append('<span id="tWarning">No ha puesto que tipo de Usuario es!</span>');

			break;

			}
		}


	/*Vamos a meter ahora un poco de lógica para que sea más fácil para el usuario */
	jQuery(document).ready(function(){

			tUserConsequences();

			jQuery('#ncusertype').change(tUserConsequences);

		}
	);


	</script>

	<!-- Fin del javascript-->




<?php
}

function md_save_custom_user_profile_fields($user_id)
{

    //echo 'Disparado';

    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_usermeta($user_id, 'catPro', $_POST['catPro']);
    update_usermeta($user_id, 'cargoPro', $_POST['cargoPro']);
    update_usermeta($user_id, 'clinicaEmp', $_POST['clinicaEmp']);
    update_usermeta($user_id, 'webClinicaEmp', $_POST['webClinicaEmp']);
    update_usermeta($user_id, 'descProf', $_POST['descProf']);
    update_usermeta($user_id, 'emailContact', $_POST['emailContact']);
    update_usermeta($user_id, 'linkedIn', $_POST['linkedIn']);
    update_usermeta($user_id, 'imgProp', $_POST['imgProp']);
    update_usermeta($user_id, 'pPublic', $_POST['pPublic']);
    update_usermeta($user_id, 'ncusertype', $_POST['ncusertype']);
    //los añadiddos.
    update_usermeta($user_id, 'sxdone', $_POST['sxdone']);
    update_usermeta($user_id, 'catopa', $_POST['catopa']);
    update_usermeta($user_id, 'refrap', $_POST['refrap']);
    update_usermeta($user_id, 'infocompat', $_POST['infocompat']);
    update_usermeta($user_id, 'infocomprof', $_POST['infocomprof']);
    //Los correspondientes al customIolTest.
    update_usermeta($user_id, 'preedad', $_POST['preedad']);
    update_usermeta($user_id, 'presexo', $_POST['presexo']);
    update_usermeta($user_id, 'presintvis', $_POST['presintvis']);
    update_usermeta($user_id, 'prehenfocu', $_POST['prehenfocu']);
    update_usermeta($user_id, 'preprococu', $_POST['preprococu']);
    update_usermeta($user_id, 'premedocu', $_POST['premedocu']);
    update_usermeta($user_id, 'prehistmedsis', $_POST['prehistmedsis']);
    update_usermeta($user_id, 'premedsis', $_POST['premedsis']);
    update_usermeta($user_id, 'preantfami', $_POST['preantfami']);
    update_usermeta($user_id, 'prestatpsi', $_POST['prestatpsi']);
    update_usermeta($user_id, 'prelifestyle', $_POST['prelifestyle']);
    update_usermeta($user_id, 'pregrad', $_POST['pregrad']);
    update_usermeta($user_id, 'prendepsx', $_POST['prendepsx']);
    update_usermeta($user_id, 'prendepgl', $_POST['prendepgl']);
    update_usermeta($user_id, 'prendepgc', $_POST['prendepgc']);
    update_usermeta($user_id, 'prendepgi', $_POST['prendepgi']);
    update_usermeta($user_id, 'preprefaceptg', $_POST['preprefaceptg']);
    update_usermeta($user_id, 'preprefacephalos', $_POST['preprefacephalos']);
    update_usermeta($user_id, 'preprefacepgpeq', $_POST['preprefacepgpeq']);
    update_usermeta($user_id, 'preprefacepgact', $_POST['preprefacepgact']);
    update_usermeta($user_id, 'prepersonalidad', $_POST['prepersonalidad']);
    update_usermeta($user_id, 'preaddcomments', $_POST['preaddcomments']);
    update_usermeta($user_id, 'valorpending', $_POST['valorpending']);
    update_usermeta($user_id, 'allok', $_POST['allok']);
    //Los correspondientes al postop vision.
    update_usermeta($user_id, 'surgerytime', $_POST['surgerytime']);
    update_usermeta($user_id, 'surgeryeye', $_POST['surgeryeye']);
    update_usermeta($user_id, 'surgeryiol', $_POST['surgeryiol']);
    update_usermeta($user_id, 'ddriving', $_POST['ddriving']);
    update_usermeta($user_id, 'ndriving', $_POST['ndriving']);
    update_usermeta($user_id, 'ivision', $_POST['ivision']);
    update_usermeta($user_id, 'newspaper', $_POST['newspaper']);
    update_usermeta($user_id, 'prices', $_POST['prices']);
    update_usermeta($user_id, 'needle', $_POST['needle']);
    update_usermeta($user_id, 'dglasses', $_POST['dglasses']);
    update_usermeta($user_id, 'nglasses', $_POST['nglasses']);
    update_usermeta($user_id, 'currentvision', $_POST['currentvision']);
    update_usermeta($user_id, 'satiol', $_POST['satiol']);
    update_usermeta($user_id, 'age', $_POST['age']);
    update_usermeta($user_id, 'provincia', $_POST['provincia']);
    update_usermeta($user_id, 'clinic', $_POST['clinic']);
    update_usermeta($user_id, 'comments', $_POST['comments']);
}

/*
add_action( 'show_user_profile', 'MD_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'MD_add_custom_user_profile_fields' );

add_action( 'personal_options_update',  'md_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'md_save_custom_user_profile_fields' );
*/


/*-- Si el usuario es paciente vamos a poner la cookie de ncpatient --*/

function check_type_user()
{
    if (is_user_logged_in() && !isset($_COOKIE['_wp_first_time_patient'])) {//isset($_COOKIE['_wp_first_time']) &&

        $idCurrentNcUser = get_current_user_id();

        //echo $idCurrentNcUser;

        $tipoUser = get_user_meta($idCurrentNcUser, 'ncusertype', true);

        //echo 'El tipo de usuario es '.$tipoUser;

        //var_dump( $tipoUser);

        if (!isset($_COOKIE['ncpatient']) && ($tipoUser == 'pat') && !isset($_COOKIE['_wp_first_time_patient'])) {
            //echo 'filtro aplicaándose';
            setcookie('_wp_first_time_patient', 1, time() + (WEEK_IN_SECONDS * 4), COOKIEPATH, COOKIE_DOMAIN, false);
            setcookie('ncpatient', 'ncpatient', time() + (WEEK_IN_SECONDS * 4), COOKIEPATH, COOKIE_DOMAIN, false);

            if (current_user_can('manage_options')) {
                //echo COOKIEPATH;
            }

            return true;
        }

        return false;
    } else {
        // expires in 30 days.
        //setcookie('_wp_first_time', 1, time() + (WEEK_IN_SECONDS * 4), COOKIEPATH, COOKIE_DOMAIN, false);

        return false;
    }
}
add_action('init', 'check_type_user');



//Tenemos que añadir ahora el campo tipo de usuario en el formulario de registro y hacer que salga también en el de info de perfil.


//1. Add a new form element...
//No es necesario puesto que lo hacemos desde el template ms-signup-form directamente

//2. Add validation. In this case, we make sure first_name is required.
//El filter anterior no es WPMU compatible.
//add_filter( 'registration_errors', 'nc_registration_errors',10,3);
function nc_registration_errors($errors, $sanitized_user_login, $user_email)
{
    echo 'filtro ejecutándose';

    if (empty($_POST['ncusertype']) || ! empty($_POST['ncusertype']) && trim($_POST['ncusertype']) == '') {
        $errors->add('ncusertype_error', _x('Ha de introducir el tipo de usuario al registrarse. Luego lo podrá cambiar tantas a su gusto las veces que quiera. Así mismo podrá ver el site como profesional siendo paciente y como paciente siendo profesional según desee.', 'Functions', 'iol_theme'));
    }

    return $errors;
}

//add_filter( 'wpmu_validate_user_signup','nc_user_registration_validation');

function nc_addfield_signup($meta)
{
    if (empty($_POST['ncusertype'])) {
        $_POST['ncusertype'] = '';
    };
    $meta = array('ncusertype' => $_POST['user_type']); //perhaps push here, but there are no other values passed so far
    return $meta;
}
//add_filter('add_signup_meta','nc_addfield_signup', 10, 3);





function add_user_whith_type($user_id, $password, $meta)
{
    if (empty($meta['ncusertype'])) {
        $meta['ncusertype'] = '';
    }

    add_user_meta($user_id, 'ncusertype', $meta['ncusertype']);
}

//add_action('wpmu_activate_user', 'add_user_whith_type', 10, 3);



//Hay que hacer lo anterior versión TML
/*function tml_registration_errors( $errors ) {
    if ( empty( $_POST['first_name'] ) )
        $errors->add( 'empty_first_name', '<strong>ERROR</strong>: Please enter your first name.' );
    if ( empty( $_POST['last_name'] ) )
        $errors->add( 'empty_last_name', '<strong>ERROR</strong>: Please enter your last name.' );
    return $errors;
}*/
//add_filter( 'registration_errors', 'tml_registration_errors' );





//3. Finally, save our extra registration user meta.
//add_action( 'user_register', 'nc_user_register' );
function nc_user_register($user_id)
{
    if (! empty($_POST['ncusertype'])) {
        update_user_meta($user_id, 'ncusertype', trim($_POST['ncusertype']));
    }
}


//Vamos a urgir al tipo a que edite su perfil.

/*function is_first_time() {
    if (!isset($_COOKIE['_wp_first_time']) && is_user_logged_in()) {

        if(empty(get_user_meta( 'ncusertype', $user->ID, true )) || get_user_meta( 'ncusertype', $user->ID, true )== '' ){

        }

        return false;
    } else {
        if(is_user_logged_in()){// expires in 30 days.
        setcookie('_wp_first_time', 1, time() + (WEEK_IN_SECONDS * 4), COOKIEPATH, COOKIE_DOMAIN, false);
        return true;
            }


    }
}*/
/*add_action( 'init', 'is_first_time_loggedIn');*/



/* Si no ha especificado  el tipo de usuario que és le redireccionamos al perfil en cuanto se logee */

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
 /*
function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    global $user;
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins, vamos a añadir también a los editores y colaboradores (el editor sólo rellena posts y páginas por el momento)
        if ( in_array( 'administrator', $user->roles ) || in_array( 'contributor', $user->roles ) || in_array( 'editor', $user->roles ) ) {
            // redirect them to the default place
            return $redirect_to;
        } else {
            return get_permalink(70);//;home_url();
        }
    } else {
        return get_permalink(70);//$redirect_to;
    }
}*/

//add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );




add_action('after_setup_theme', 'iol_theme_setup');
function iol_theme_setup()
{

    //echo get_template_directory();
    //echo  ;
    //  echo _x("Ver lente","Filter_Template","theme_iol_display");
    // echo get_stylesheet_directory() . '/languages';
    //echo ABSPATH .'wp-content/plugins/nc-sync/languages/';
    /* if(load_plugin_textdomain('iol_theme', false,    ABSPATH .'wp-content/plugins/nc-sync/languages/')){

         echo 'Este es el dominio padre';
     }*/

    if (load_textdomain('iol_theme', ABSPATH .'wp-content/plugins/nc-sync/languages/iol_theme-'.get_locale().'.mo')) {

       //echo 'Aloooha';
    }

    if (load_textdomain('iol_last', ABSPATH .'wp-content/plugins/nc-sync/languages/iol_last-'.get_locale().'.mo')) {

       //echo 'Aloooha';
    }

    if (load_textdomain('user-analysis-p', ABSPATH .'wp-content/plugins/nc-sync/languages/user-analysis-p-'.get_locale().'.mo')) {

       //echo 'Aloooha';
    }
    if (load_textdomain('user-manager-p', ABSPATH .'wp-content/plugins/nc-sync/languages/user-manager-p-'.get_locale().'.mo')) {

       //echo 'Aloooha';
    }

    //Vamos ha hacer un load del domain de TML para ver si así funciona.



    //load_theme_textdomain('iol', get_template_directory() . '/languages');
    if (load_child_theme_textdomain('theme_iol_display', get_stylesheet_directory() . '/languages/')) {
        //echo 'Lo cargooooo';
       //  echo _x("Ver lente","Filter_Template","theme_iol_display");
    }
    /*
         if(load_textdomain( 'theme_iol_display', get_stylesheet_directory() . '/languages/theme_iol_display-en_US.mo' ))
         {

             echo 'ahora siiii¡¡';
         } */
}

//Añadimos el meta-field para identificar unívocamente las páginas en las distintas versiones.

//add_action( 'add_meta_boxes', 'meta_box_pageTextID' );
function meta_box_pageTextID()
{
    add_meta_box('meta-data-ID', 'text ID', 'meta_box_callback', 'page', 'normal', 'high');
}

function meta_box_callback($post)
{
    $values = get_post_custom($post->ID);
    $selected = isset($values['meta_box_pageTextID']) ? $values['meta_box_pageTextID'][0] : '';

    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce'); ?>
    <p>
        <label for="meta_box_pageTextID"><p>Texto Identificador</p></label>
        <textarea name="meta_box_pageTextID" id="meta_box_pageTextID" cols="62" rows="5" ><?php echo $selected; ?></textarea>
    </p>
    <?php
}

//add_action( 'save_post', 'meta_box_pageTextID_save' );
function meta_box_pageTextID_save($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) {
        return;
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post')) {
        return;
    }

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchords can only have href attribute
        )
    );

    // Probably a good idea to make sure your data is set

    if (isset($_POST['meta_box_pageTextID'])) {
        update_post_meta($post_id, 'meta_box_pageTextID', $_POST['meta_box_pageTextID']);
    }
}


/* VAMOS AHORA CON SHORTCODES PARA HACER TODO MÁS SOSTENIBLE */

//[link_tipoIol taxoIol="rap" valueTaxoIol="" titleIol=""]

// shortcode [show_link_tipoIol]
function show_link_tipoIol($atts)
{
    $linkTipoIol_details="";
    // get attibutes and set defaults
    extract(shortcode_atts(array(
                'taxoiol' => 'No especificado',
                'taxovalueiol' => 'No especificado',
                'titleiol' => 'No especificado'
       ), $atts));

    $linkToIolArchive = get_post_type_archive_link(_x('lente-intraocular', 'CustomPostType Name', 'iol'));

    $term_link = add_query_arg(array( _x($taxoiol, 'taxo-name', 'iol') => _x($taxovalueiol, 'taxo-value-slug', 'iol-scaffold')), $linkToIolArchive);

    //$slug = get_post( $post )->post_name;

    // Display info
    $linkTipoIol_details = '<br /><br /><div class="link-to-archive">';
    //$linkTipoIol_details .= $taxoValueIol;
    $linkTipoIol_details .= '<a href="'.$term_link.'">'._x($titleiol, 'shortcode', 'iol_theme').'</a>';
    $linkTipoIol_details .= '</div><br />';

    return $linkTipoIol_details;
}
//shortcode [show_link_page]

function show_link_page($atts)
{
    $linkToPage_details ="";
    //get attributes and set defaults
    extract(shortcode_atts(array(
                'pageslug'  => 'No especificado',
                'pagetitle' => 'No especificado'
       ), $atts));

    $siteUrl =  get_site_url();
    $linkToPage = $siteUrl.'/'.$pageslug;

    $linkToPage_details .= '<div class="linkToPage">';
    $linkToPage_details .= '<a href="'.$linkToPage.'">'.$pagetitle.'</a>';


    $linkToPage_details .= '</div>';

    return $linkToPage_details;
}

//shortcode [show_link_by_ID]

function show_link_by_id($atts)
{
    $linkToPage_details ="";
    //get attributes and set defaults
    extract(shortcode_atts(array(
                'linktitle'  => 'No especificado',
                'id' => 'No especificado'
       ), $atts));


    $linkToPage_details .= '<a href="'.get_permalink($id).'">'.$linktitle.'</a>';

    return $linkToPage_details;
}


//shortcode [grouplink_tipo_iol]

function show_grouplink_tipo_iol($atts)
{
    $group_link_details ="";
    //get attributes and set defaults
    extract(shortcode_atts(array(
                'pageslug'  => 'No especificado',
                'linkpagetitle' => 'No especificado',
                'taxoiol' => 'No especificado',
                'taxovalueiol' => 'No especificado',
                'linktipoioltitle' => 'No especificado'

       ), $atts));
    /*Parte de link a la página de explicación*/
    $siteUrl =  get_site_url();
    if (is_numeric($pageslug)) {
        $linkToPage = get_permalink($pageslug);
    } else {
        $linkToPage = $siteUrl.'/'.$pageslug;
    }


    $pTitle = _x($linkpagetitle, 'shortcode', 'iol_theme');

    $linkToPage_details ='';
    $linkToPage_details .= '<div class="groupLinkToPage">';
    $linkToPage_details .= '<a href="'.$linkToPage.'">'.$pTitle.'</a>';

    $linkToPage_details .= '</div>';

    /*Parte del link al archive */

    $linkToIolArchive = get_post_type_archive_link(_x('lente-intraocular', 'CustomPostType Name', 'iol'));

    $term_link = add_query_arg(array( _x($taxoiol, 'taxo-name', 'iol') => _x($taxovalueiol, 'taxo-value-slug', 'iol-scaffold')), $linkToIolArchive);
    $linkTipoIol_details ="";
    $linkTipoIol_details .="";
    $linkTipoIol_details .= '<div class="groupLinkArchive">';
    $plinkTypTitle = _x($linktipoioltitle, 'shortcode', 'iol_theme');

    $linkTipoIol_details .= '<a href="'.$term_link.'">'.$plinkTypTitle.'</a>';
    $linkTipoIol_details .= '</div>';

    //
    $group_link_details .= '<div class="groupLink">';
    $group_link_details .= $linkToPage_details;
    $group_link_details .= $linkTipoIol_details;
    $group_link_details .= '<div class="groupClearer">&nbsp;</div>';
    $group_link_details .= '</div>';

    //$group_link_details .= '</div>';


    return  $group_link_details;//$linkToPage_details;
}


//shortcode [grouplink_tipo_iol]

function show_subGroupLink_Tipo_Iol($atts)
{
    $group_link_details ="";
    //get attributes and set defaults
    extract(shortcode_atts(array(
                'taxoiol' => 'Taxo No especificado',
                'taxovalueiol' => 'TaxoValue No Especificado',
                'subtaxoiol'=> 'SubTaxo No Especificado',
                'subtaxovalueiol'=>'SubTaxoValueIol No Especificado',
                'linksubtipoioltitle' => 'No especificado',
                'fabricante'=>'No'

       ), $atts));
    /*Parte de link a la página de explicación*/
    $siteUrl =  get_site_url();

    /*Parte del link al archive */

    $linkToIolArchive = get_post_type_archive_link(_x('lente-intraocular', 'CustomPostType Name', 'iol'));

    if ($subtaxoiol != 'SubTaxo No Especificado') {
        $term_link = add_query_arg(array( _x($taxoiol, 'taxo-name', 'iol') => _x($taxovalueiol, 'taxo-value-slug', 'iol-scaffold'), _x($subtaxoiol, 'taxo-name', 'iol') => _x($subtaxovalueiol, 'taxo-value-slug', 'iol-scaffold')), $linkToIolArchive);
    } else {
        $term_link = add_query_arg(array( _x($taxoiol, 'taxo-name', 'iol') => _x($taxovalueiol, 'taxo-value-slug', 'iol-scaffold')), $linkToIolArchive);
    }
    $linkSubTipoIol_details = '';
    $linkSubTipoIol_details .= '<div class="linkSubGroupArchive">';


    $linkSubTipoIol_details .= '<a href="'.$term_link.'" class="linkSubTipoIol">'._x($linksubtipoioltitle, 'shortcode', 'iol_theme').'</a>'; //&pt=no
    $linkSubTipoIol_details .= '<div class="groupClearer">&nbsp;</div>';
    $linkSubTipoIol_details .= '</div>';

    if ($fabricante != 'No') {
        $linkSubTipoIol_details = '<div class="fabGroup">'.$linkSubTipoIol_details.'</div>';
    }


    return  $linkSubTipoIol_details;//$linkToPage_details;
}





//add our shortcodes
add_shortcode('subGroupLink_tipo_iol', 'show_subGroupLink_Tipo_Iol');
add_shortcode('grouplink_tipo_iol', 'show_grouplink_tipo_iol');
add_shortcode('link_tipoIol', 'show_link_tipoIol');
add_shortcode('link_by_id', 'show_link_by_id');

//add_action( 'init', 'register_shortcodes');

//Queremos que no salga la primera metabox la de YOAST.
// Move Yoast to bottom
function yoasttobottom()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');


function new_excerpt_more($more)
{

//	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';

    global $post;

    $post_type = get_post_type($post);
    switch ($post_type):
            case _x('opinion-doctor', 'CustomPostType Name', 'opinion-doctor'):
               $teaser = '<a class="moretag" href="'. get_permalink($post->ID) . '"><span class="prevLinkOp"> [...]</span>'. _x('Leer más', 'link template', 'iol_theme').' </a>';
    break;

    default:
                $teaser = '';
    endswitch;

    return $teaser;
}
add_filter('excerpt_more', 'new_excerpt_more');




if (!function_exists('_log')) {
    function _log($message)
    {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
                error_log($message);
            }
        }
    }
}

/*Funciones de sincronización */
function translatedWPTermsIOLScaffold(&$elemento1, $clave, $context)
{
    $elemento1 = _x($elemento1, $context, 'iol-scaffold');
}

function translatedWPTermsIOL(&$elemento1, $clave, $context)
{
    $elemento1 = _x($elemento1, $context, 'iol');
}
/*
//Función para sacar los key ids de los terms desde donde se encuentren
function keyWPTermsIolScaffold(&$elemento1, $clave, $context)
{
    global $wpdb;
    $langKey = get_locale();

    $queryKey =  "SELECT `text`
                FROM `nc_mu_mo`
                    where `".$langKey."` = '".$elemento1."'
                        and `domain` = 'iol-scaffold'
                        and `context` = '".$context."'";

    $result = $wpdb->get_results($queryKey);
    if (count($result)) {
        foreach ($result as $row) {
            $elemento1 = $row->text;
        }
    } else {
        $elemento1 = null;
    }
}*/

 //Función para sacar los terms en langToTransTo desde donde se encuentren
function nameWPTermsIOL(&$elemento1, $clave, $langToTransTo)
{
    global $wpdb;
    $langKey = get_locale();

    $queryKey =  "SELECT `".$langToTransTo."`
                FROM `nc_mu_mo`
                    where `".$langKey."` = '".$elemento1."'
	                    and `domain` = 'iol-scaffold'
                        and `context` = 'taxo-value-name'";
    //echo $queryKey.'<br />';

    $result = $wpdb->get_results($queryKey);
    if (count($result)) {
        foreach ($result as $row) {
            $elemento1 = $row->$langToTransTo;
        }
    } else {
        $elemento1 = null;
    }
}

 //Función para sacar los terms en langToTransTo desde donde se encuentren
function nameWPTaxoIOL(&$elemento1, $clave, $langToTransTo)
{
    global $wpdb;
    $langKey = get_locale();

    $queryKey =  "SELECT `".$langToTransTo."`
                FROM `nc_mu_mo`
                    where `".$langKey."` = '".$elemento1."'
	                    and `domain` = 'iol'
                        and `context` = 'taxo-name'";
    //echo $queryKey.'<br />';

    $result = $wpdb->get_results($queryKey);
    if (count($result)) {
        foreach ($result as $row) {
            $elemento1 = $row->$langToTransTo;
        }
    } else {
        $elemento1 = null;
    }
}

  //Función para sacar los terms en langToTransTo desde donde se encuentren
function directNameWP_CPT($cptName, $langToTransTo, $domainDCPT)
{
    global $wpdb;
    $langKey = get_locale();

    //echo 'El get locale es'.$langKey.'<br />';

    $queryKey =  "SELECT `".$langToTransTo."`
                FROM `nc_mu_mo`
                    where `".$langKey."` = '".$cptName."'
	                    and `domain` = '".$domainDCPT."'
                        and `context` like 'CustomPostType%'";
    //echo $queryKey;

    $result = $wpdb->get_results($queryKey);
    if (count($result)) {
        foreach ($result as $row) {
            return $row->$langToTransTo;
        }
    } else {
        return null;
    }
}

 function nameWPTermContextIOL($termName, $langToTransTo, $context, $domainTerm)
 {
     global $wpdb;
     $langKey = get_locale();

     $queryKey =  "SELECT `".$langToTransTo."`
                FROM `nc_mu_mo`
                    where `".$langKey."` = '".$termName."'
	                    and `domain` = '".$domainTerm."'
                        and `context` = '".$context."'";
     //echo $queryKey.'<br />';
     if (current_user_can('manage_options')) {
         // echo $queryKey.'<BR /><BR /><BR /><BR /><BR /><BR /><BR />';
     }
     $result = $wpdb->get_results($queryKey);
     if (count($result)) {
         foreach ($result as $row) {
             return $row->$langToTransTo;
         }
     } else {
         return  null;
         if (current_user_can('manage_options')) {
             //    echo $queryKey.'<BR /><BR /><BR /><BR /><BR /><BR /><BR />';
             echo 'Error: el témino'.$termName.'en el contexto'.$context.'no tiene traducción a:'.$langToTransTo.'<br />';
         }
     }
 }

 //Filter for removing hatoms classes => lo haremos a través de schema:org.
 /**
 * Remove 'hentry' from post_class()
 */
function ja_adapt_hatom_classes($class)
{
    $class = array_diff($class, array( 'hentry','vcard' ));
    if (current_user_can('moderate_comments')) {
        //    var_dump($class);
    }
    return $class;
}
add_filter('post_class', 'ja_adapt_hatom_classes');


/* Eliminamos por segunda vez el autosave... en teoría ya lo habíamos hecho en el wp_config pero sigue añadiéndose el script */

function disabler_kill_autosave()
{
    wp_deregister_script('autosave');
}

add_action('wp_print_scripts', 'disabler_kill_autosave');


/* Añadimos la parte de clínicas sugeridas en la parte final de la página */
//Vamos a registrar  también la de lente intraocular con clínica.
function pageToClinicaConnection()
{
    p2p_register_connection_type(array(
        'name' => 'pageToClinica',
        'from' => 'page',
        'to' => _x('clinica', 'CustomPostType Name', 'clinica')
    ));
}

//add_action( 'p2p_init', 'fabricanteToClinicaConnection' );
add_action('p2p_init', 'pageToClinicaConnection');

/*-- Vamos a añadir el campo de condiciones de uso --*/

function tml_registration_errors($errors)
{
    if (! array_key_exists('user_conditions', $_POST)) {
        //	$errors->add( 'conditions_not_accepted', ''._x('Antes de registrarse ha de aceptar las condiciones legales.','functions','iol_theme').'.' );
    }
    return $errors;
}
//add_filter( 'registration_errors', 'tml_registration_errors', 10, 3 );
//add_filter( 'register_post', 'tml_registration_errors', 10, 3 );
//add_filter( 'wpmu_validate_user_signup', 'tml_registration_errors', 10, 3 );

//Arturo
//add_filter('signup_extra_fields','tml_registration_errors',10,1);




//El tema de wp total cache
//add_action( 'after_setup_theme', 'url_wtotalcache_setup' );

function url_wtotalcache_setup()
{
    if (strpos($_SERVER['QUERY_STRING'], 'repeat=w3tc') !== false) {
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $queryString = '';
        if (isset($uri[1])) {
            $queryString = trim(str_replace('repeat=w3tc', '', $uri[1]), '&');
            $queryString = (!empty($queryString)) ? '?' . $queryString : '';
        }
        wp_redirect(home_url($uri[0] . $queryString), 301);
        exit;
    }
}


function _remove_script_version($src)
{
    if (!(strpos($src, 'fonts.googleapis.com') !== false)) {
        $parts = explode('?', $src);
        return $parts[0];
    }
}

//add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
//add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


/**
 * Load Enqueued Scripts in the Footer
 *
 * Automatically move JavaScript code to page footer, speeding up page loading time.
 */
function footer_enqueue_scripts()
{
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}
//add_action('after_setup_theme', 'footer_enqueue_scripts');



//Test para aplicar el minify también al css.
//add_filter('wp_minify_js_url', 'offload_minify_js_css');


//Esto al final no lo vamos a hacer puesto que tiramos toda la minificación del propio w3tc
//add_filter('wp_minify_css_url', 'offload_minify_js_css');

function offload_minify_js_css($url)
{
    $dominios = array('www.nuevocristalino.es','www.nuevocristalino.mx','www.nuevocristalino.co','www.nuevocristalino.cl','www.newlens.co.uk','www.mylifestylelens.com','www.nouveaucristallin.com','www.neuelinsen.com','www.neuelinsen.at');
    return str_replace($dominios, 'd4ofz0usyl9g2.cloudfront.net', $url);
}


/*-- Cuando permites usuarios anónimos se les asigna un nombre en cualquier caso, si luego clickeas en el nombre recibes un 404, esté código es un fix --*/
function bbp_fix_users_404_headers()
{
    if (! function_exists('bbpress')) {
        return;
    }
    $bbp = bbpress();

    if (!empty($bbp->displayed_user) && is_404()) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
    }
}
add_action('wp', 'bbp_fix_users_404_headers');




/*-- Añadimos tags a las páginas --*/
// add tag support to pages
function tags_support_all()
{
    //Lo hacemos para poder utilizar el mismo sistema de etiquetas.
    register_taxonomy_for_object_type('post_tag', 'page');
    register_taxonomy_for_object_type('post_tag', 'topic');
    register_taxonomy_for_object_type('post_tag', 'forum');
    register_taxonomy_for_object_type('post_tag', 'question');
    register_taxonomy_for_object_type('post_tag', 'answer');
}

// ensure all tags are included in queries
function tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) {
        $wp_query->set('post_type', 'any');
    }
}

// tag hooks
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');

//Añadimos el código necesario par ala cookie de identificación de tipo de usuario.
//add_action( 'init', 'nc_setcookie' );
//No lo haremos así porque la página dependerá de la cookie y de momento sólo podemos cachear una.
/*
function nc_setcookie() {
   //Si la cookie no existe la creamos, habrá cookies sólo para pacientes, si no hay cookie es un oftalmólogo/optometrista.
   if(!isset( $_COOKIE['ncpatient'] )){
   setcookie( 'ncpatient', 'ncpatient', time() + 3600000, COOKIEPATH, COOKIE_DOMAIN ); //COOKIE_DOMAIN//WP_SITEURL
   }
}*/


//El shortcode para añadir el formulario.
add_shortcode('qa_ask_question', 'qa_ask_question_sc');
function qa_ask_question_sc()
{
    return get_the_question_form();
}


//Quitamos el css que añade el plugin de custom contact forms.

function remove_ccf_css()
{
    wp_dequeue_style('ccf-jquery-ui');
}
add_action('wp_enqueue_scripts', 'remove_ccf_css', 100);


//quitamos también el wpdm-bootstrap de download manager
function remove_wpdm_bootstrap()
{
    wp_dequeue_script('wpdm-bootstrap');
}
add_action('wp_enqueue_scripts', 'remove_wpdm_bootstrap', 100);


function redesignStyles()
{

    //Los estilos particulares de cada país
    wp_register_style('redesign', get_stylesheet_directory_uri() . '/css/redesign.css');
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('redesign');
}

    add_action('wp_enqueue_scripts', 'redesignStyles');


    function qaStyles()
    {

        //Los estilos particulares de cada país
        wp_register_style('qa', get_stylesheet_directory_uri() . '/css/qa.css');
        // For either a plugin or a theme, you can then enqueue the style:
        wp_enqueue_style('qa');
    }

        add_action('wp_enqueue_scripts', 'qaStyles');




/*-- We want to keep the home forms as simple as possible https://premium.wpmudev.org/forums/topic/cant-choose-html-on-qa-default-text-is-white-on-white --*/

// Use different functions if you want to modify question and answer editors differently
add_filter('qa_question_editor_settings', 'my_modify_editor_function', 10, 2);
add_filter('qa_answer_editor_settings', 'my_modify_editor_function', 10, 2);
function my_modify_editor_function($settings, $ID)
{
    // Dont use visual editor for visitors
    if (is_home()) {
        $tinymce = false;
        $quicktags = false;
    } else {
        $tinymce = true;
        $quicktags = true;
    }

    $settings['tinymce'] = $tinymce;
    $settings['quicktags'] = $quicktags;

    if (current_user_can('manage_options')) {

        //var_dump($settings);
    }

    return $settings;
}

function bbp_enable_visual_editor($args = array())
{
    if (is_home()) {
        $args['tinymce'] = false;
    } else {
        $args['tinymce'] = true;
    }

    return $args;
}
add_filter('bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor');


add_filter('bbp_after_get_the_content_parse_args', 'rkk_bbp_edit_quick_editor');
function rkk_bbp_edit_quick_editor($args = array())
{
    $args['quicktags']         = false; /*array( //http://wordpress.stackexchange.com/questions/49173/remove-html-editor-and-visual-html-tabs-from-tinymce
                                                                            'quicktags' => false
                                                                            //'buttons' => false
                                                                            );//strong,em,link,block,del,img,ul,ol,li,close*/

    return $args;
}


/*-- Remove the rest of the buttons: addMedia, addForm --*/

function z_remove_media_controls()
{
    remove_action('media_buttons', 'media_buttons');
}
 //add_action('admin_head','z_remove_media_controls');



add_filter('bbp_current_user_can_access_create_topic_form', 'custom_bbp_access_topic_form');
function custom_bbp_access_topic_form($retval)
{
    if (is_home()) {//bbp_is_forum_archive
        $retval = bbp_current_user_can_publish_topics();
    }

    return $retval;
}



/*-- Functions for displaying the proper category image question --*/

function get_catQuestion($id_question)
{
    $categories   = wp_get_post_terms($id_question, 'question_category'); //,$args

    $categ_string = wp_list_pluck($categories, 'name');


    if ($categ_string[0]) {
        return $categ_string[0];
    } else {
        return 'Sin categoría asignada';
    }
}

function get_idImgSingleQA($id_question)
{
    $categories   = wp_get_post_terms($id_question, 'question_category'); //,$args

    $categ_string = wp_list_pluck($categories, 'slug');
    $firstCat = 0;
    $idCatQ = "";

    $globalLang = substr(get_locale(), 0, 2);

    $cataratas = array(
                                            'es' =>'preguntas-cataratas',
                                            'en'=>'cataract-questions',
                                            'de'=>'fragen-katarakt',
                                            'fr'=>'questions-cataractes'
                                            );
    $presbicia = array(
                                  'es' =>'preguntas-presbicia',
                                            'en'=>'presbyopia-questions',
                                            'de'=>'Fragen-Presbyopie',
                                            'fr'=>'questions-presbytie'
                        );
    $lio = array(
                                     'es' =>'preguntas-lentes-intraoculares',
                                            'en'=>'intraocular-lenses-questions',
                                            'de'=>'fragen-intraokularlinsen',
                                            'fr'=>'implants-intraoculaires'
                        );
    $clinic = array(
                                            'es' =>'preguntas-clinicas',
                                            'en'=>'eye-clinic-questions',
                                            'de'=>'fragen-kliniken',
                                            'fr'=>'questions-cliniques'
                        );
    if (in_array($cataratas[$globalLang], $categ_string) && ($firstCat == 0)) {
        $idCatQ = "cataractImgQ";
        $firstCat =1;
    }

    if (in_array($presbicia[$globalLang], $categ_string) && ($firstCat == 0)) {
        $idCatQ = "presbImgQ";
        $firstCat =1;
    }

    if (in_array($lio[$globalLang], $categ_string) && ($firstCat == 0)) {
        $idCatQ = "iolImgQ";
        $firstCat =1;
    }

    if (in_array($clinic[$globalLang], $categ_string) && ($firstCat == 0)) {
        $idCatQ = "clinicImgQ";
        $firstCat =1;
    }


    return $idCatQ;
}


/*-- Function to truncat text for the Q&A excerpts in home and others if needed--*/

function truncateCustom($text, $id, $chars = 50)
{
    $text = $text." ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text.' ...';
    return $text;
}


           function get_forumFeatImg($idElement)
           {

               //if(current_user_can('manage_options')){
               $shortLang = substr(get_locale(), 0, 2);
               $titeForumEs = array('Cataratas','Presbicia','Lentes Intraoculares', 'Cl’nicas');
               $titeForumEn = array('Cataracts','Presbyopia','Intraocular Lenses','Eye Clinics');
               $titeForumFr = array('cataractes','Presbytie','Implants Intraoculaires','Cliniques');
               $titeForumDe = array('Katarakt','Presbyopie','Intraokularlinse','Augenkliniken');

               //Vamos a cambiar lo anerior y a hacerlo por IDs

               $imgForum = 'default';

               $idForumCat = array(2939,7566,8752,9101);
               if (in_array($idElement, $idForumCat)) { //get_the_ID()
                   $imgForum = 'opcat';
               }

               $idForumPresb = array(2335,7570,8756,9105);
               if (in_array($idElement, $idForumPresb)) { //get_the_ID()
                   $imgForum = 'presb';
               }
               $idForumPriceIol = array(12220,13141,9103);
               if (in_array($idElement, $idForumPriceIol)) { //get_the_ID()
                   $imgForum = 'prices';
               }


               $idForumIol = array(2333,7571,8757,9104);
               if (in_array($idElement, $idForumIol)) {//get_the_ID()
                   $imgForum = 'iol';
               }


               $idForumClin = array(2841,7567,8753,9102);
               if (in_array($idElement, $idForumClin)) { //get_the_ID()
                   $imgForum = 'clin';
               }
               //vamos con el de los precios y/o gestiones de la cirugía de cataratas.
               $idForumGesCat = array(12469,13143);
               if (in_array($idElement, $idForumGesCat)) {//get_the_ID()
                   $imgForum = 'gescat';
               }
               //vamos con el de offtopics a las lentes intraoculares.
               $idForumOff = array(12471,13142,9106);
               if (in_array($idElement, $idForumOff)) {//get_the_ID()
                   $imgForum = 'tec';
               }

               return get_stylesheet_directory_uri().'/images/content/icon-forum-'.$imgForum.'.png';
           }


//shortcode [not_logged_in_message]

function show_not_logged_in_message($atts)
{
    $notLoggedInMessage ="";

    extract(shortcode_atts(array(
                'message'  => '',
                'register_try' => ''
       ), $atts));

    if (!is_user_logged_in()) {
        $notLoggedInMessage .= '<p>'.$message.'</p>';

        if ($register_try != '') {

                     //$notLoggedInMessage .= '<br />';
            $notLoggedInMessage .= '<p>'.$register_try.'</p>';
            //$notLoggedInMessage .= '<br />';
            $notLoggedInMessage .= do_shortcode("[TheChamp-Login]");
        }
    }



    return $notLoggedInMessage;
}
add_shortcode('not_logged_in_message', 'show_not_logged_in_message');

//We are going to create one specific taxonomy to be able to categorize pages.
//We are going to do it the same way we do with questions.

add_action('init', 'create_page_taxcategory');

function create_page_taxcategory()
{
    register_taxonomy(
        'page_category',
        'page',
        array(
            'label' => 'Page Category',
            'rewrite' => array( 'slug' => _x('informacion-basica/categoria', 'Functions', 'iol_theme') ),
            'hierarchical' => true,
        )
    );
}

add_action('init', 'create_page_tagcategory');

function create_page_tagcategory()
{
    register_taxonomy(
        'page_tag',
        'page',
        array(
            'label' => 'Page Tag',
            'rewrite' => array( 'slug' => _x('informacion-basica/etiqueta', 'Functions', 'iol_theme') ),
            'hierarchical' => true,
        )
    );
}



function custom_menu_page_removing()
{
    remove_menu_page('ccf_form');//$menu_slug
}
//add_action( 'admin_menu', 'custom_menu_page_removing' );



//remove_action( 'loop_start', add_custom_content_before_loop );

global $_qa_core;

//Remove this content that is being added to keep the template as it was before.

remove_action('loop_start', array( $_qa_core, 'add_custom_content_before_loop' ));


//enque general css style also in the ask question page as it was before.

if (class_exists('QA_Virtual_Page')) {
    wp_enqueue_style('qa-section', QA_PLUGIN_URL . QA_DEFAULT_TEMPLATE_DIR . '/css/general.css', array(), QA_VERSION);
    /*wp_dequeue_script('lente-intraocular-js');
    wp_enqueue_script ( 'lente-intraocular-js',plugins_url().'/lightbox-plus/js/jquery.colorbox.1.5.9-min.js', array('jQuery','colorbox'), false, false);
    */
}

//Add search form to menu as it was before.

add_filter('qa_show_menu_search_form', 'add_search_form');
function add_search_form($string)
{
    return true;
}

//vamos a cambiar los métodos de contacto de usuarios que vienen por defecto.

// Remove Silly Contact Methods

function removesilly_contactmethods($contactmethods)
{
    // here you could add other fields
$contactmethods['skype'] = 'skype'; // Add Google Plus
$contactmethods['facebook'] = 'Facebook'; // Add Facebook
$contactmethods['twitter'] = 'Twitter'; // Add Twitter
//$contactmethods['gplus'] = 'Google+'; // Add Google Plus


  unset($contactmethods['yim']); // Remove Yahoo IM
  unset($contactmethods['aim']); // Remove AIM
  unset($contactmethods['jabber']); // Remove Jabber


return $contactmethods;
}

add_filter('user_contactmethods', 'removesilly_contactmethods', 10, 1);



// Only display to administrators
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function bg_recent_comments($no_comments = 5, $comment_len = 50)
{
    $comments_query = new WP_Comment_Query();
    $comments = $comments_query->query(array( 'number' => $no_comments ));
    $comm = '';

    $comm .= '<div class="leftmenutitlewrapper">';
    $comm .= '<span class="priorleftmenutitle">&nbsp;</span>';

    $comm .= '<h3>'.__('Recent Comments').'</h3>';/**/

    $comm .= '<span class="afterleftmenutitle">&nbsp;</span>';
    $comm .= '</div>';
    $comm .= '<ul >';

    if ($comments) : foreach ($comments as $comment) :
    $comm .= '<li class="comment-list-items"><a class="author" href="' . get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID . '">';

    $comm .= get_comment_author($comment->comment_ID) . '</a> en: ';
    $comm .= '<a href="'.get_permalink($comment->comment_post_ID).'">'.get_the_title($comment->comment_post_ID).'</a>';
    $comm .= '<p>' . strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)) . '...</p></li>';
    endforeach; else :
    $comm .= '<li>No comments.</li>';
    endif;
    $comm .= '</ul>';
    echo $comm;
}





//Parte de adsense:
//Insert ads after second paragraph of single post content.



add_filter('the_content', 'prefix_insert_post_ads');



function prefix_insert_post_ads($content)
{
    global $post;


    $ad_code = '<div class="adsense-unit-responsive">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1153244876275063"
     data-ad-slot="4180169437"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>';


    // if ( is_single() ) {//is_single() && ! is_admin()
    if ((is_singular('page')) ||  (is_singular('post'))) {
        return prefix_insert_after_paragraph($ad_code, 4, $content);
    }

    return $content;
}




// Parent Function that makes the magic happen

function prefix_insert_after_paragraph($insertion, $paragraph_id, $content)
{
    $closing_p = '</p>';

    $paragraphs = explode($closing_p, $content);

    foreach ($paragraphs as $index => $paragraph) {
        if (trim($paragraph)) {
            $paragraphs[$index] .= $closing_p;
        }



        if ($paragraph_id == $index + 1) {
            $paragraphs[$index] .= $insertion;
        }
    }
    return implode('', $paragraphs);
}



add_action('login_form_bottom', 'add_lost_password_link');
function add_lost_password_link()
{
    return '<div class="lostpassword"><a href="/wp-login.php?action=lostpassword">'.__('Lost your password?').'</a></div>';
}



function my_login_logo()
{
    ?>
    <style type="text/css">
/*#loginform .button-primary,*/
  body.wp-core-ui .button-primary{
      background:#FEA63C;
      border-color: #FEA63C;
      box-shadow: 0 1px 0 #FEA63C;
      color: #fff;
      text-decoration: none;
      text-shadow: 0 -1px 1px #FEA63C, 1px 0 1px #FEA63C, 0 1px 1px #FEA63C, -1px 0 1px #FEA63C;
    }

        #login h1 a, .login h1 a {
          background-image: url(https://www.nuevocristalino.es/wp-content/themes/dw-qa/images/logo-nc.jpg);
          height: 129px;
          width: 320px;
          background-size: 320px 129px;
          background-repeat: no-repeat;
          padding-bottom: 15px;
          border-radius: 3px;
        }

body.login #login_error,
body.login .message,
body.login .success{
      border-left: 4px solid #FEA63C;
}
    </style>
<?php
}
add_action('login_enqueue_scripts', 'my_login_logo');




add_action('after_setup_theme', 'dw_qa_setup');
function dw_qa_setup()
{
    //var_dump(load_theme_textdomain('iol-main', get_template_directory() . '/languages'));


    load_child_theme_textdomain('dw-qa', get_stylesheet_directory() . '/languages');
}
