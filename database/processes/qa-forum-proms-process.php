<?php

//wp eval-file qa-process.php

require ABSPATH.'wp-load.php';



//$output = shell_exec('wp --info');

//include('processes/uninstall-unused-plugins');







include('processes/qa-forum/replace-qa-post-meta-keys.php');
include('processes/qa-forum/replace-qa-taxonomy-keys.php');
include('processes/qa-forum/replace-qa-post-types.php');

include('processes/deactivate-all-plugins.php');

include('processes/qa-forum/export-qas-forums.php');

include('processes/deactivate-all-plugins.php');

include('processes/qa-forum/import-qas-forums.php');
