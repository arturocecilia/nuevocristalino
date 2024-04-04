<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<li class="bbp-forum-info">
       <?php
       //Tenemos que meter la imagen apropiada, aqu� no es una categor�a sino el t�tulo del foro.
       //Comprobamos que el t�tulo es el de cataratas, presb... en cada idiomay asignamos la imagen correspondiente.
       		//Cataratas,Presbicia,Lentes Intraoculares, Cl�nicas
       		//Katarakt,Presbyopie,Intraokularlinse, Augenkliniken
       		//Cataracts,Presbyopia,Intraocular Lenses,Eye Clinics
       		//cataractes,Presbytie,Cliniques,Implants Intraoculaires




       ?>

    	<img src="<?php echo get_forumFeatImg(get_the_ID()); ?>" alt="Logotipo Nuevo Cristalino Forum"/>





		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

<!-- Movemos el la info del último mensaje aquí -->
<span class="freshnessWrapper">
		<?php bbp_forum_freshness_link(); ?>
	</span>
<!-- Fin info del último mensaje-->
		<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php bbp_forum_row_actions(); ?>

	</li>

	<li class="bbp-forum-topic-count"><span class="mensWrapp"><span class="newDLine"><?php bbp_forum_topic_count(); ?></span><span class="newDLineLabel"><?php _e( 'Topics', 'bbpress' ); ?></span></span></li>

	<li class="bbp-forum-reply-count"><span class="topicWrapp"><span class="newDLine"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?> </span><span class="newDLineLabel"><?php _e( 'Replies', 'bbpress' ); ?></span></span></li>

	<li class="bbp-forum-freshness">

		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

		<?php //bbp_forum_freshness_link(); ?>

		<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<?php do_action( 'bbp_theme_before_topic_author' ); ?>

			<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 40 ) ); ?></span>

			<?php do_action( 'bbp_theme_after_topic_author' ); ?>

		</p>
	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
