<?php
                      //Vamos a Desacoplar el tema de la "Versión de NuevoCristalino" de los pos mos. Razón: Sólo hay que tocar 6 plantillas.
            $filtAvanzado = _x('Usar Búsqueda avanzada para oftalmólogos.','Template Modelos de Lente Intraocular','iol_theme');
            $filtSimple   = _x('Usar al Búsqueda Sencilla para Pacientes','Template Modelos de Lente Intraocular','iol_theme');
            
            //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versión".
            $langChange = substr(get_locale(),0,2);
            
            
            if($langChange =="es"){
            $filtAvanzado 	= "NuevoCristalino modo <strong>PACIENTE</strong> <BR />Cambiar a modo <i>Profesional</i>";
            $filtSimple		= "NuevoCristalino modo <strong>PROFESIONAL</strong> <BR />Cambiar a modo <i>Paciente</i>";
            //Metemos una regla css a capón.
      //      echo '<style> #preButtonSet.noArchive #helpTitle a{top:-57px;} #preButtonSet.noArchive #searchReset{top:52px !important;} </style>';
            }
            
                        if(get_locale() == 'en_GB'){
            $filtAvanzado 	= "NewLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "NewLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
            
            if(get_locale() == 'en_US'){
            $filtAvanzado 	= "MylefStyleLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "MylefStyleLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
         //   echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
?>