<?php





function create_po_from_csv($fileFrom, $directoryTo, $domain, $localeNamed= false)
{
    $csv = array_map('str_getcsv', file($fileFrom));
    array_walk($csv, function (&$a) use ($csv) {
        $a = array_combine($csv[0], $a);
    });



    array_shift($csv); # remove column header

    ///

    $currentLangArray = array('es_ES','es_CO','es_MX','es_CL','en_GB','de_DE','de_AT','en_US','fr_FR'); //str_replace('-','_',$currentLangWP);

    foreach ($currentLangArray as $currentLang) {
//
        $path = $directoryTo;//ABSPATH.'wp-content/plugins/nc-login-registration/languages/' ;

        //$domain = 'nc-login-registration';
        if ($localeNamed) {
            $fullPathToPo = $path.$currentLang.'.po';
        } else {
            $fullPathToPo = $path.$domain.'-'.$currentLang.'.po';
        }

        $fh = fopen($fullPathToPo, 'w');

        fwrite($fh, "#\n");

        fwrite($fh, "msgid \"\"\n");
        fwrite($fh, "msgstr \"\"\n");
        fwrite($fh, "\"Content-Type: text/plain; charset=utf-8\\n\"");


        foreach ($csv as $poArray) { //$key => $value

            $msgid = $poArray['msgid'];
            $msgctxt = $poArray['msgctxt'];
            $msgstr = $poArray[$currentLang];

            $key  = addslashes($msgid); //utf8_decode(
            //Estoy teniendo problemas con este addslashes en frances -> Como no los he tenido en otros idiomas lo comento.
            if ($currentLang == 'fr_FR' || $currentLang == 'en_GB' || $currentLang == 'en_US') {
                $value     = $msgstr;
            } else {
                $value     = addslashes($msgstr);
            }

            $context   = addslashes($msgctxt);

            fwrite($fh, "\n");
            fwrite($fh, "msgctxt \"$context\"\n");
            fwrite($fh, "msgid \"$key\"\n");
            fwrite($fh, "msgstr \"$value\"\n");
        }

        fclose($fh);
//
    }
}
