<?php


function processTranslator($string, $locale)
{
    $translation = array(
  "TU CASO" => array('en_GB' => "YOUR CASE", 'en_US' => "YOUR CASE", 'fr_FR' => "VOTRE CAS"),
  "TIENES CATARATAS" => array('en_GB' => "YOU HAVE CATARACTS", 'en_US' => "YOU HAVE CATARACTS", 'fr_FR' => "VOUS AVEZ THE CATARACTES"),
  "Lentes intraoculares fáquicas" => array('en_GB' => "Phakic intraocular lenses", 'en_US' => "Phakic intraocular lenses", 'fr_FR' => "Implants intraoculaires phaques"),
  "Lentes intraoculares tóricas" => array('en_GB' => "Toric intraocular lenses", 'en_US' => "Toric intraocular lenses", 'fr_FR' => "Implants intraoculaires toriques"),
  "Lente intraoculares Multifocales" => array('en_GB' => "Multifocal intraocular lenses", 'en_US' => "Multifocal intraocular lenses", 'fr_FR' => "Implants intraoculaires multifocaux"),
  "Lentes intraoculares Monofocales" => array('en_GB' => "Monofocal intraocular lenses", 'en_US' => "Monofocal intraocular lenses", 'fr_FR' => "Implants intraoculaires monofocaux"),
  "Opciones de tratamiento" => array('en_GB' => "Treatment options", 'en_US' => "Treatment options", 'fr_FR' => "Options de traitement"),
  "Listado de clínicas" => array('en_GB' => "List of clinics", 'en_US' => "List of clinics", 'fr_FR' => "Cliniques"),

  "Listado de Clínicas" => array('en_GB' => "List of clinics", 'en_US' => "List of clinics", 'fr_FR' => "Cliniques"),

  "Principales fabricantes de lentes intraoculares" => array('en_GB' => "Main intraocular lens manufacturers", 'en_US' => "Main intraocular lens manufacturers", 'fr_FR' => "Fabricants"),
  "Cómo es la cirugía" => array('en_GB' => "How is the surgery?", 'en_US' => "How is the surgery?", 'fr_FR' => "comme est l'opération"),
  "Calhoun" => array('en_GB' => "Calhoun", 'en_US' => "Calhoun", 'fr_FR' => "Calhoun"),
  "STAAR" => array('en_GB' => "STAAR", 'en_US' => "STAAR", 'fr_FR' => "STAAR"),
  "Physiol" => array('en_GB' => "Physiol", 'en_US' => "Physiol", 'fr_FR' => "Physiol"),
  "AMO" => array('en_GB' => "AMO", 'en_US' => "AMO", 'fr_FR' => "AMO"),
  "Alcon" => array('en_GB' => "Alcon", 'en_US' => "Alcon", 'fr_FR' => "Alcon"),
  "Bausch+Lomb" => array('en_GB' => "Bausch+Lomb", 'en_US' => "Bausch+Lomb", 'fr_FR' => "Bausch+Lomb"),
  "ZEISS" => array('en_GB' => "ZEISS", 'en_US' => "ZEISS", 'fr_FR' => "ZEISS"),
  "OCULENTIS" => array('en_GB' => "OCULENTIS", 'en_US' => "OCULENTIS", 'fr_FR' => "OCULENTIS"),
  "Solución con lentes intraoculares" => array('en_GB' => "Solution with intraocular lenses", 'en_US' => "Solution with intraocular lenses", 'fr_FR' => "Solution avec implants intraoculaires"),
  "Tratamientos sobre la córnea" => array('en_GB' => "Corneal treatments", 'en_US' => "Corneal treatments", 'fr_FR' => "Traitements corneaux"),
  "LA MEJOR LENTE PARA TI" => array('en_GB' => "THE BEST IOL FOR YOU", 'en_US' => "THE BEST IOL FOR YOU", 'fr_FR' => "LE MEILLEUR LIO POUR VOUS"),
  "1 - Explicación Básica" => array('en_GB' => "1 - Basic explanation", 'en_US' => "1 - Basic explanation", 'fr_FR' => "1 - Explication Basique"),
  "3 - Simulador de Lentes Intraoculares" => array('en_GB' => "3 - Intraocular lens simulator", 'en_US' => "3 - Intraocular lens simulator", 'fr_FR' => "3 - Simulateur LIO"),
  "4 - Buscador de Lentes Intraoculares" => array('en_GB' => "4 - Intraocular lens browser", 'en_US' => "4 - Intraocular lens browser", 'fr_FR' => "4 - Chercheur de LIO"),
  "2 - Test para ver la lente" => array('en_GB' => "2 - Test for the IOL", 'en_US' => "2 - Test for the IOL", 'fr_FR' => "2 - Test pour LIO"),
  "Rayner" => array('en_GB' => "Rayner", 'en_US' => "Rayner", 'fr_FR' => "Rayner"),
  "HOYA" => array('en_GB' => "HOYA", 'en_US' => "HOYA", 'fr_FR' => "HOYA"),
  "5- Lista básica de Lentes Intraoculares" => array('en_GB' => "5 - Basic list of Intraocular Lenses", 'en_US' => "5 - Basic list of Intraocular Lenses", 'fr_FR' => "5 - Liste de modeles"),
  "Medicontur" => array('en_GB' => "Medicontur", 'en_US' => "Medicontur", 'fr_FR' => "Medicontur"),
  "2 - Tus datos antes de la operación" => array('en_GB' => "2 - Your data before the surgery", 'en_US' => "2 - Your data before the surgery", 'fr_FR' => "2 - Vos informations avant la chirurgie"),
  "3 - Tu Área Personal" => array('en_GB' => "3 - Your Personal Area", 'en_US' => "3 - Your Personal Area", 'fr_FR' => "3 - Votre área personnel"),
  "¿Gafas después de la operación?" => array('en_GB' => "Glasses after the surgery?", 'en_US' => "Glasses after the surgery?", 'fr_FR' => "¿Lunettes après la chirurgie?"),
  "Quieres ver sin gafas" => array('en_GB' => "Stop using glasses", 'en_US' => "Stop using glasses", 'fr_FR' => "Vous voulez voir sans lunettes"),
  "Información general" => array('en_GB' => "General information", 'en_US' => "General information", 'fr_FR' => "information générale"),
  "Aceptas gafas" => array('en_GB' => "You accept using glasses", 'en_US' => "You accept using glasses", 'fr_FR' => "vous acceptez d'utiliser des lunettes"),
  "Tienes astigmatismo" => array('en_GB' => "You have astigmatism", 'en_US' => "You have astigmatism", 'fr_FR' => "vous avez de l'astigmatisme"),
  "Sin cataratas y menos de 40 años" => array('en_GB' => "No cataracts and less than 40 years", 'en_US' => "No cataracts and less than 40 years", 'fr_FR' => "Pas de cataracte et moins de 40 ans"),
  "Foro: Lentes Intraoculares" => array('en_GB' => "Forum: Intraocular Lenses", 'en_US' => "Forum: Intraocular Lenses", 'fr_FR' => "Forum: Lentilles intraoculaires"),
  "Preguntas: Lentes Intraoculares" => array('en_GB' => "Questions: Intraocular Lenses", 'en_US' => "Questions: Intraocular Lenses", 'fr_FR' => "Questions: Lentilles intraoculaires"),
  "Preguntas: Lentes ICL" => array('en_GB' => "Questions: ICL Lenses", 'en_US' => "Questions: ICL Lenses", 'fr_FR' => "Questions: Lentilles ICL"),
  "La lente idónea para ti" => array('en_GB' => "The best lens for you", 'en_US' => "The best lens for you", 'fr_FR' => "Le meilleur implant pour vous"),
  "La operación de Cataratas" => array('en_GB' => "The cataract surgery", 'en_US' => "The cataract surgery", 'fr_FR' => "La chirurgie de la cataracte"),
  "Nueva Técnica LÁSER" => array('en_GB' => "New LASER technique", 'en_US' => "New LASER technique", 'fr_FR' => "Nouvelle technique LASER"),
  "Dudas Frecuentes" => array('en_GB' => "FAQ", 'en_US' => "FAQ", 'fr_FR' => "Questions fréquemment posées"),
  "Riesgos y Peligros" => array('en_GB' => "Risks and dangers", 'en_US' => "Risks and dangers", 'fr_FR' => "Risques et dangers"),
  "Precio" => array('en_GB' => "Pricing", 'en_US' => "Pricing", 'fr_FR' => "Prix"),
  "Foro: Operación de Cataratas" => array('en_GB' => "Forum: Cataract Surgery", 'en_US' => "Forum: Cataract Surgery", 'fr_FR' => "Forum: Chirurgie de la cataracte"),
  "No quieres gafas" => array('en_GB' => "Dont want to use glasses", 'en_US' => "Dont want to use glasses", 'fr_FR' => "Je ne veux pas utiliser de lunettes"),
  "Además tienes astigmatismo" => array('en_GB' => "Besides you have astigmatism", 'en_US' => "Besides you have astigmatism", 'fr_FR' => "De plus, vous avez de l'astigmatisme"),
  "Clínicas especializadas en Cataratas" => array('en_GB' => "Clinics specialized in Cataracts", 'en_US' => "Clinics specialized in Cataracts", 'fr_FR' => "cliniques spécialisées en l'opération des cataractes"),
  "Quieres que te contacten las clínicas" => array('en_GB' => "You want to be contacted by clinics", 'en_US' => "You want to be contacted by clinics", 'fr_FR' => "Vous voulez être contacté par les cliniques"),
  "Quieres consejo sobre la lente" => array('en_GB' => "You want to be advised about the lens", 'en_US' => "You want to be advised about the lens", 'fr_FR' => "Vous voulez être informé sur l'implant"),
  "2 - Datos de antes de la operación" => array('en_GB' => "2 - Data before the surgery", 'en_US' => "2 - Data before the surgery", 'fr_FR' => "2 - Information avant la chirurgie"),
  "3 - Tu área privada" => array('en_GB' => "3 - Your private area", 'en_US' => "3 - Your private area", 'fr_FR' => "3 - Votre espace privé"),
  "Contáctanos con tus dudas" => array('en_GB' => "Contact us with your doubts", 'en_US' => "Contact us with your doubts", 'fr_FR' => "Contactez-nous avec vos doutes"),
  "TIENES PRESBICIA" => array('en_GB' => "YOU HAVE PRESBYOPIA", 'en_US' => "YOU HAVE PRESBYOPIA", 'fr_FR' => "VOUS AVEZ LA PRESBYOPIE"),
  "Soluciones a la vista cansada" => array('en_GB' => "Solutions for prebyopia", 'en_US' => "Solutions for prebyopia", 'fr_FR' => "Solutions pour la presbytie"),
  "Tipos de lente para presbicia" => array('en_GB' => "Types of IOLs for prebyopia", 'en_US' => "Types of IOLs for prebyopia", 'fr_FR' => "Types de LIO pour la presbytie"),
  "Lentes Intraoculares Trifocales" => array('en_GB' => "Trifocal Intraocular lenses", 'en_US' => "Trifocal Intraocular lenses", 'fr_FR' => "Lentilles intraoculaires trifocales"),
  "¿Cuándo no me convienen?" => array('en_GB' => "When they do not suit me?", 'en_US' => "When they do not suit me?", 'fr_FR' => "Quand elles ne me conviennent pas?"),
  "Clínicas especializadas en Presbicia" => array('en_GB' => "Eye clinics specialized in Presbyopia", 'en_US' => "Eye clinics specialized in Presbyopia", 'fr_FR' => "Cliniques ophtalmologiques spécialisées en presbytie"),
  "Quieres que te contacten clínicas" => array('en_GB' => "You want to be contacted by clinics", 'en_US' => "You want to be contacted by clinics", 'fr_FR' => "Vous voulez être contacté par les cliniques"),
  "Preguntas: Cataratas" => array('en_GB' => "Questions: Cataracts", 'en_US' => "Questions: Cataracts", 'fr_FR' => "Questions: Cataractes"),
  "Foro: Operación Presbicia" => array('en_GB' => "Forum: Presbyopia Surgery", 'en_US' => "Forum: Presbyopia Surgery", 'fr_FR' => "Forum: Chirurgie de la presbytie"),
  "Preguntas: Vista Cansada" => array('en_GB' => "Questions: Presbyopia", 'en_US' => "Questions: Presbyopia", 'fr_FR' => "Questions: Presbytie"),
  "Quieres encontrar tu lente idónea" => array('en_GB' => "You want to find the best IOL for you", 'en_US' => "You want to find the best IOL for you", 'fr_FR' => "Vous voulez trouver la meilleure LIO pour vous"),
  "3 - Mi Área Personal" => array('en_GB' => "3 - Your Personal Area", 'en_US' => "3 - Your Personal Area", 'fr_FR' => "3 - Votre espace personnel"),
  "2 - Datos preoperatorios" => array('en_GB' => "2 - Preoperative Data", 'en_US' => "2 - Preoperative Data", 'fr_FR' => "2 - Données préopératoires"),
  "Ventajas de las Lentes Premium" => array('en_GB' => "Advantages of Premium Intraocular Lenses", 'en_US' => "Advantages of Premium Intraocular Lenses", 'fr_FR' => "Avantages des lentilles intraoculaires premium"),
  "SOY PROFESIONAL" => array('en_GB' => "I AM A PROFESSIONAL", 'en_US' => "I AM A PROFESSIONAL", 'fr_FR' => "JE SUIS UN PROFESSIONNEL"),
  "Dar de alta una Clínica" => array('en_GB' => "Introduce my clinic in the system", 'en_US' => "Introduce my clinic in the system", 'fr_FR' => "Présenter ma clinique dans le système"),
  "Tu Área Personal" => array('en_GB' => "Your Personal Area", 'en_US' => "Your Personal Area", 'fr_FR' => "Votre espace personnel"),
  "Resultados que se obtienen en tu operación ocular" => array('en_GB' => "Outcomes of your surgery", 'en_US' => "Outcomes of your surgery", 'fr_FR' => "Résultats de votre chirurgie"),
  "Tus contenidos de interés" => array('en_GB' => "Your contents", 'en_US' => "Your contents", 'fr_FR' => "Votre contenu"),
  "La lente intraocular idónea para ti" => array('en_GB' => "The best intraocular lens for you", 'en_US' => "The best intraocular lens for you", 'fr_FR' => "La meilleure lentille intraoculaire pour vous"),
  "Tus conocimientos sobre la operación" => array('en_GB' => "Your knowledge about the surgery", 'en_US' => "Your knowledge about the surgery", 'fr_FR' => "Vos connaissances sur la chirurgie"),
  "Ya te has operado" => array('en_GB' => "You have undergone the surgery already", 'en_US' => "You have undergone the surgery already", 'fr_FR' => "Vous avez été opérée"),
  "Todavía no te has operado" => array('en_GB' => "You havent undergone the surgery", 'en_US' => "You havent undergone the surgery", 'fr_FR' => "Vous n'avez pas été opérée"),
  "2 - Datos para mi operación" => array('en_GB' => "1 - Data about my surgery", 'en_US' => "1 - Data about my surgery", 'fr_FR' => "1 - Données sur mon opération"),
  "2 - Encuesta de satisfacción" => array('en_GB' => "2 - Satisfaction survey", 'en_US' => "2 - Satisfaction survey", 'fr_FR' => "2 - Enquête de satisfaction"),
  "3 - Comparte tu experiencia en los foros" => array('en_GB' => "3 - Share your experience in the forum", 'en_US' => "3 - Share your experience in the forum", 'fr_FR' => "3 - Partagez votre expérience sur le forum"),
  "4 - Mira en los foros comentarios de pacientes" => array('en_GB' => "4 - View in the forum other patients comments", 'en_US' => "4 - View in the forum other patients comments", 'fr_FR' => "4 - Voir dans le forum les commentaires des autres patients"),
  "Contactanos si tienes dudas" => array('en_GB' => "Contact us if you have doubts", 'en_US' => "Contact us if you have doubts", 'fr_FR' => "Contactez-nous si vous avez des doutes"),
  "4 - Pregunta a los cirujanos tus dudas" => array('en_GB' => "4 - Ask the surgeons your doubts", 'en_US' => "4 - Ask the surgeons your doubts", 'fr_FR' => "4 - Demandez aux chirurgiens vos doutes"),
  "3 - Preguntar a los cirujanos" => array('en_GB' => "3 - Ask the surgeons", 'en_US' => "3 - Ask the surgeons", 'fr_FR' => "3 - Demander aux chirurgiens"),
  "Tu Área Privada" => array('en_GB' => "Your Private Area", 'en_US' => "Your Private Area", 'fr_FR' => "Votre espace privé"),
  "1 - Datos básicos" => array('en_GB' => "1 - Basic data", 'en_US' => "1 - Basic data", 'fr_FR' => "1 - Données de base"),
  "1 - Tus datos básicos" => array('en_GB' => "1 - Your basic data", 'en_US' => "1 - Your basic data", 'fr_FR' => "1 - Vos données de basiques"),
  "1 - Tus Datos Básicos"  => array('en_GB' => "1 - Your basic data", 'en_US' => "1 - Your basic data", 'fr_FR' => "1 - Vos données de basiques"),
  "1- Tus Datos Básicos" => array('en_GB' => "1 - Your basic data", 'en_US' => "1 - Your basic data", 'fr_FR' => "1 - Vos données de basiques"),
  "Registrarse" => array('en_GB' => "Register", 'en_US' => "Register", 'fr_FR' => "Registre"),
  "BUSCADOR DE LIOs" => array('en_GB' => "IOL Browser", 'en_US' => "IOL Browser", 'fr_FR' => "Navigateur LIO	"));


    //$string, $locale

    if (array_key_exists($string, $translation)) {
        return $translation[$string][$locale];
    } else {
        echo 'No existía esta translation: '.$string.PHP_EOL;
        return $string;
    }
}
