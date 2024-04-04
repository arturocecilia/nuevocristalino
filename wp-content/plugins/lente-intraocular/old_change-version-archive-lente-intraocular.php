<?php          
          
            $filtAvanzado = _x("Usar al Búsqueda Avanzada para Oftalmólogos.","Archive Lente Intraocular","iol_cpt_display");
            $filtSimple   = _x("Usar al Búsqueda Sencilla para Pacientes","Archive Lente Intraocular","iol_cpt_display");
            
            //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versión".
            
            $langChange = substr(get_locale(),0,2);
            
            
            if($langChange =="es"){
            $filtAvanzado 	= "NuevoCristalino modo <strong>PACIENTE</strong> <BR />Cambiar a modo <i>Profesional</i>";
            $filtSimple		= "NuevoCristalino modo <strong>PROFESIONAL</strong> <BR />Cambiar a modo <i>Paciente</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
            if(get_locale() == 'en_GB'){
            $filtAvanzado 	= "NewLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "NewLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
            
            if(get_locale() == 'en_US'){
            $filtAvanzado 	= "MylefStyleLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "MylefStyleLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
            
?>