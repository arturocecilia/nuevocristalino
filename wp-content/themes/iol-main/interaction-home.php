


 <div style="clear:both; height:0px;">&nbsp;</div>
	<div id="primary" class="site-content-home">
		<div id="content interaction" role="main">

<?php

  include('home-blocks/register-form-home.php')
?>


<div id="fakeDiff"style="clear: both; height: 0px;">&nbsp;</div>


<?php


include('home-blocks/main-4-blocks.php');


include('adsense-unit-responsive.php');


 if (true) {
     include('home-blocks/postop-outcomes.php');
 }

 if (in_array(get_locale(), ['es_ES','es_MX','es_CL','es_CO','de_DE','de_AT'])) {
     include('home-blocks/patologias.php');
 }


include('home-blocks/activity.php');


 ?>





		</div><!-- #content -->
	</div><!-- #primary -->
