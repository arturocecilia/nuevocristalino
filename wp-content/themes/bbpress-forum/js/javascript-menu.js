//Función para dar propiedades a menú la url se correpnde con el link al que a te lleva.
jQuery(function() {
	
  jQuery('#menu-menu-cirugia li a').each(function() {
    if (jQuery(this).attr('href')  ===  location.href) {
	  jQuery(this).addClass('selected');
    }
  })
});  


