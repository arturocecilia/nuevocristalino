/*function submit_me(){
jQuery.post(
            the_ajax_script.ajaxurl, 
            jQuery("#theForm").serialize(),
            function(response_from_the_action_function){ 
                    jQuery("#response_area").html(response_from_the_action_function); }
           );
}*/

function submit_me(){
    alert(the_ajax_script.ajaxurl);
jQuery.post(
            the_ajax_script.ajaxurl, 
            jQuery("#iol_filter_form").serialize(),
            function(response_from_the_action_function){ 
                    jQuery("#ajaxResponse").html(response_from_the_action_function); }
           );
}