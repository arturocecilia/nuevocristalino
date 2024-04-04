    <?php 
	    //vamos a poner el "widget customizado" de principales especialistas.
	    
	    
	    if((get_locale() == 'es_ES')){//||(get_locale() == 'es_CO')||(get_locale() == 'es_CL');current_user_can('manage_options')
	    ?>
	    <aside id="mainSurgeons" class="mainSurgeons">
		    <h3 class="widget-title surgeonTitle">Especialistas en cirugía intraocular en España:</h3>
		    <div class="surgeonWrapper">
			    <div class="surgeonImg">
				    <img src="<?php echo wp_upload_dir()['baseurl'].'/doctors/dr-hanneken.png'; ?>"/>
			    </div>
			    <!-- <div class="surgeonDesc"> -->
				    <p>El Dr. Hanneken es uno de los principales especialistas de Europa en cirugía de presbicia y cataratas con lentes intraoculares premium, así como en el implante de lentes ICL. <br /><br />Pionero en el desarrollo de las últimas tecnologías en cirugía intraocular es el director médico de <a href="http://www.nuevocristalino.es/clinica-oftalmologica-lente-intraocular/vallmedic-vision/" class="noGotoMain">VallmedicVision</a> con sedes en Andorra y Mallorca</p>
			    <!-- </div> -->
			    <div style="clear:both;height:1px;">&nbsp;</div>
		    </div>
	    </aside>
	    <?php
		    }
    ?>    