<?php
/*
Desde este template vamos a incluir con <?php get_template_part( $slug, $name ); ?> los templates que correpondan de acuerdo a las query_vars.
Siguiendo la template hierarchy y la definición que hicimos en el plugin para encontrar el template. Sólo busca archive-lente-intraocular cuando se requiere el archive de lentes intraoculares.
Las tax queries no están redirigidas al archive de lentes intraoculares.

Desde este template por lo tanto redigiremos a las "archive pages correspondientes" puesto que equivales a las tax templates en lo que a representación se refiere.
Todo se basa en que desde taxonomy.php no hay fallback a archive-custom-post-type.php sino sólo a archive.php con lo que tenemos que utilzar este template como distribuidor.

    - Resultado de una query a una única taxonomy de lente-intraocular sin resultados (viene desde tipos de IOL) => pillamos archive-lente-intraocular.
    - Resultado de una query a un conjunto de taxonomies y metefields de lente intraocular (viene desde single IOL)=> pillamos archive-lente-intraocular.
    - Resultado de un aquery desde single clinica =>pillamos archive-clinica.

 */


//echo 'Archive puro y duro';

   /*
   var_dump($wp_query->query_vars);

   echo '<br>'.$wp_query->query_vars['diseno-optica'].'</br>';
   echo '<br>'.$wp_query->query_vars['tipo-lente-intraocular'].'</br>';
   echo '<br>'.$wp_query->query_vars['filtros'].'</br>';
   */

   /*

   -- No entiendo por qué pero si la url era la del custom post type archive. Si no hay custom post type posts se viene aquí...

   */


   if(($wp_query->query_vars['taxonomy'] == 'question_category') || ($wp_query->query_vars['taxonomy'] == 'question_tag')){
     include( get_stylesheet_directory().'/qa-archive-question.php');
     die();
   }

   if(($wp_query->query_vars['post_type'] == 'question') && ($wp_query->query_vars['author_name'] == '') ){
     include( get_stylesheet_directory().'/qa-archive-question.php');

     die();
   }

   if(($wp_query->query_vars['post_type'] == 'question') && ($wp_query->query_vars['author_name'] != '')){
     include( get_stylesheet_directory().'/qa-user-question.php');
     die();
    }

   //Si es el resultado de una query desde single-iol:
   if ($wp_query->query_vars['post_type']=='lente-intraocular'){

   //get_template_part('iolPluginTemplates/archive-lente-intraocular');

   include( ABSPATH . 'wp-content/plugins/lente-intraocular/archive-lente-intraocular.php');

   die();
   }

   //Si es el resultado de una query desde single-clinica:
   if ($wp_query->query_vars['post_type']=='clinica'){

   //echo 'estamos llamando al archive clinica desde archive.php de iol';
    include( ABSPATH . 'wp-content/plugins/clinica/archive-clinica.php');
   //get_template_part('clinicaPluginTemplates/archive-clinica');

   die();
   }


?>
