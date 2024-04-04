<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header();


    // Sacamos los links directamente a través del id

    $permalink      =   get_permalink(2349);//id Explicación básica => 2349
    $permalinkSim   =   get_permalink(2891); //id página simulador de lentes => 2891
    $permalinkCuest =   get_permalink(2869); // id página cuestionario => 2869
    $permalinkTest  =   get_permalink(227); // id página cuestionario => 2869
    $permaMod       =   get_permalink(412); //id página de modelos de LIO
    $permaOpPresbi  =   get_permalink(111); //id de la página de operación presbicia
    $permaAdvPrem   =   get_permalink(343);
    $resulSxCat     =   get_permalink(2881);
    $permaBlog      =   get_permalink(31);
    $permaBuscaIol  =   get_permalink(5254);//página del buscador de lentes


    
     include('interaction-home.php');


      get_footer("home");
