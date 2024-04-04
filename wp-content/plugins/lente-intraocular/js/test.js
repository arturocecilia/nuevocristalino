function progress(e,t){var n=e*t.width()/100;t.find("#actualProgressBar").animate({width:n},500).html('<span class="p">'+e+"%&nbsp;&nbsp;</span>")}function FormFilledCounter(){var e=0;if(jQuery("#testLIO input:radio[name=tQ1]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ2]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ3]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ4]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ5]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ6]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ7]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ8]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ9]:checked").val()!=null){e+=10}if(jQuery("#testLIO input:radio[name=tQ10]:checked").val()!=null){e+=10}progress(e,jQuery("#progressBar"))}function testFormButtonTabLoader(){jQuery("#tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");jQuery("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");jQuery("#r1,#r2,#r3,#r4,#r5,#r6,#r7,#r8,#r9,#r10").change(function(){FormFilledCounter()});jQuery(":input","#testLIO").not(":button, :submit, :reset, :hidden").val("").removeAttr("checked").removeAttr("selected");jQuery("#testLIO label").removeClass("ui-state-active");jQuery("#r1,#r7,#r8").buttonset();jQuery("#r2,#r3,#r4,#r5,#r6,#r9,#r10").buttonsetv()}function submit_Test(){var e=jQuery("#testLIO").serialize();var t=jQuery("#testLIO").attr("action");var n=t+"?"+e;goToMain(n);history.pushState(null,null,n);jQuery("html, body").animate({scrollTop:jQuery("#primary").offset().top-60},2e3);return}progress(80,jQuery("#actualProgressBar"));jQuery(document).ready(function(){testFormButtonTabLoader()})//javascript necesario para validaciones etc del test.js

function progress(percent, $element) {
	var progressBarWidth = percent * $element.width() / 100;
	$element.find('#actualProgressBar').animate({ width: progressBarWidth }, 500).html('<span class="p">'+percent + "%&nbsp;&nbsp;</span>");
}

progress(80, jQuery('#actualProgressBar'));




function FormFilledCounter() { 
var contador = 0;
    if (jQuery('#testLIO input:radio[name=tQ1]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ2]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ3]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ4]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ5]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ6]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ7]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ8]:checked').val() != null)  { contador += 10; }   
    if (jQuery('#testLIO input:radio[name=tQ9]:checked').val() != null)  { contador += 10; }
    if (jQuery('#testLIO input:radio[name=tQ10]:checked').val() != null) { contador += 10; }
 progress(contador, jQuery('#progressBar'));

}



jQuery(document).ready(function () {
    testFormButtonTabLoader();

});

function testFormButtonTabLoader() { 
    //Activamos las tabs.
    jQuery( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

    //Hacemos que la función FormFilledCounter se dispare en cuanto haya un cambio.
    jQuery("#r1,#r2,#r3,#r4,#r5,#r6,#r7,#r8,#r9,#r10").change(function () {
        FormFilledCounter();
    });
    //Queremos limpiar el formulario.
        //En valores
    jQuery(':input','#testLIO')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');
    //En estilos.
    jQuery('#testLIO label').removeClass('ui-state-active');

    //Activamos los buttonsets como horizontales o verticales según corresponda.
    jQuery( "#r1,#r7,#r8" ).buttonset();
    jQuery( "#r2,#r3,#r4,#r5,#r6,#r9,#r10" ).buttonsetv();
}


function submit_Test() {
	var qStringTest = jQuery('#testLIO').serialize();
	var targetTest = jQuery('#testLIO').attr('action');
	var hrefTest = targetTest + '?' + qStringTest; 
	
	goToMain(hrefTest);
	history.pushState(null, null, hrefTest);
	//AVISO GAnalytics cambio de página
  hrefTest = hrefTest.replace('http://' + document.domain, ''); //GA_CHANGE
  ga('send', 'pageview',hrefTest);
	
	
	//vamos a poner el scrooll to top.
	jQuery("html, body").animate({ scrollTop: jQuery("#primary").offset().top - 60 }, 2000);
	
   // jQuery("#testLIO").submit();
   //alert('En teoría parte Ajax ya enviada');
   
   return;
}


/*  (function( $ ){
  //plugin buttonset vertical
  $.fn.buttonsetv = function() {
    return this.each(function(){
      $(this).buttonset();
      $(this).css({'display': 'table', 'margin-bottom': '7px'});
      $('.ui-button', this).css({'margin': '0px', 'display': 'table-cell'}).each(function(index) {
              if (! $(this).parent().is("div.dummy-row")) {
                  $(this).wrap('<div class="dummy-row" style="display:table-row; " />');
              }
          });
      $('.ui-button:first', this).first().removeClass('ui-corner-left').addClass('ui-corner-top');
      $('.ui-button:last', this).last().removeClass('ui-corner-right').addClass('ui-corner-bottom');
    });
  };
})( jQuery );
*/



