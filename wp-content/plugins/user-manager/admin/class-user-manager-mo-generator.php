<?php
//Clase para generar los .po correspondientes a los forms.



class User_Manager_MoGenerator {

	public function __construct() {
		
		}


// add admin menu


public function UserManagerMoGenerator_Menu() {   

    //echo 'esto se está procesando';
    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); 
    add_submenu_page( 'tools.php',
    									'User Manager Mo Files Generator', 
    									'User Manager Mo Files Generator',
    									'add_users', 
    									'user-manager-mo-files-generator', 
    									array($this,'UserManagerFilesGenerator')
    									);
}


// Habrá formulario de confirmación previa y luego info sobre la generación.
public function UserManagerFilesGenerator() {
    global $wpdb;

    $html_update ="";
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have rights to access this page.') );
    }

    // when form is submitted
    if(isset($_POST['mode'])){
        $toDo = $_POST['action'];
    }
    else{
        $toDo = NULL;
    }

    if ( $toDo == "user-manager-mo-generate") {

    //Para conseguir el path donde hemos de crear el fichero: ej, include(ABSPATH . 'wp-content/plugins/lente-intraocular/archive-patient-form.php');
    $pathToTextDomain = array(
                                'user-manager'  =>  ABSPATH .   'wp-content/plugins/user-manager/languages/',
                                );
    /*A partir del array anterior sabremos donde hay que crear cada .po --> Luego habrá que compilarlo*/

    $currentLangWP = get_bloginfo('language','display');
    //$currentLang =str_replace('-','_',$currentLangWP);
    $currentLangArray = array('es_ES','es_CO','es_MX','es_CL','en_GB','de_DE','de_AT','en_US','fr_FR','en_IN'); //str_replace('-','_',$currentLangWP);
    //Para cada lenguaje hay que crear los .mos de arriba en el path indicado. Se incluirá en cada uno tantos términos como
    //se devuelva de la BBDD.
    //require('php-mo.php');

    foreach($currentLangArray as $currentLang){
    foreach($pathToTextDomain as $key=>$value){
    
        $domain = $key;
        $path = $value;
        $fullPathToPo = $path.$domain.'-'.$currentLang.'.po';

    //$queryGetTrans = "SELECT `key` as msgid, 'user_manager' as msgctxt, ".$currentLang." as msgstr FROM nc_userdata";
    
    
    $queryGetTrans = "SELECT `key` as msgid, 'user_manager' as msgctxt, ".$currentLang." as msgstr FROM nc_userdata
			UNION
		SELECT `user_data_key` as msgid, 'user_manager' as msgctxt, ".$currentLang." as msgstr FROM nc_userdata
     				where `user_data_key` in ('country','region','preedad','presexo')
			UNION
		SELECT `user_data_key_value` as msgid, 'user_manager' as msgctxt, ".$currentLang." as msgstr FROM nc_userdata
    			 where `user_data_key_value` in ('pat','prof','yes','no')";
     
     
    
    
    echo $queryGetTrans.'<br /><br />';

    
    $resultTrans = $wpdb->get_results( $queryGetTrans);

        $fh = fopen($fullPathToPo, 'w');
         
        
        fwrite($fh, "#\n");

        fwrite($fh, "msgid \"\"\n");
        fwrite($fh, "msgstr \"\"\n");
		fwrite($fh, "\"Content-Type: text/plain; charset=utf-8\\n\"");      


        foreach ($resultTrans as $poArray) { //$key => $value

                 $key       = addslashes(   $poArray->msgid     ); //utf8_decode(
                 //Estoy teniendo problemas con este addslashes en frances -> Como no los he tenido en otros idiomas lo comento.
                 if($currentLang == 'fr_FR' || $currentLang == 'en_GB' || $currentLang == 'en_US' ){
                     $value     = $poArray->msgstr; 
                 }
                 else{
                    $value     = addslashes(   $poArray->msgstr    );                     
                 }

                 $context   = addslashes(   $poArray->msgctxt   );
                 
                 fwrite($fh, "\n");
                 fwrite($fh, "msgctxt \"$context\"\n");
                 fwrite($fh, "msgid \"$key\"\n");
                 fwrite($fh, "msgstr \"$value\"\n");
                
                }
        
        fclose($fh);
        //Hacemos el .mo.
         
         //phpmo_convert( $fullPathToPo  ); //, [ 'output.mo' ]

        }
    }

    }
    
    
    ?>
    <div class="wrap">  
        <?php echo $html_update; ?> 
        <div id="icon-plugins" class="icon32"><br /></div>
        <h2>Mo Generator for the domain user-manager</h2>
        <p>A continucaci&oacute;n se va a generar la localizacion para el site de acuerdo al valor de idioma que tiene en su configuración y a los
        términos correspondientes de la tabla nc_userdata.</p>

        <form action="" method="post" enctype="multipart/form-data">
            <!-- Con este input lo que hacemos es controlar que efectivamente se ha enviado el formulario, esto es que estamos en el post-->
            <!-- Habrá que ir aglutinando las distintas funciones en un mismo plugin -->
            <input type="hidden" name="mode" value="submit">
            <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="action" value="user-manager-mo-generate"> - Proceder con la localización del site. 
            <br />

            <input type="submit" value="Generar las Mo files en nc-sync" />
        </form>


        <p style="color: red">Please make sure you back up your database before proceeding!</p> 
    </div>
    <?php
}


}