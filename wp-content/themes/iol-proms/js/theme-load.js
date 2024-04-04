//Función para evitar el flickeo a la izquierda del menú superior.

jQuery(document).ready(function() {
  // Handler for .ready() called.
  jQuery("div#menu-main").css("overflow", "visible");

  console.log("theme load");
  jQuery("#siteShower").on("click", function() {
    //top-header-countries
    //alert('Clickeado');
    toggleSites();
    return false;
  });

  //alert('done');
});

function fakeDivGenerator() {
  var pTopGRef = jQuery("#grey-in")
    .parent()
    .position();
  var topGRef = jQuery("#grey-in").position();
  var topP = topGRef.top + pTopGRef.top - 180; //185,,160,,20

  if (jQuery("#interaction-bloq").length) {
    var topBRef = jQuery("#interaction-bloq").position();
    //si tenemos el call to action para registrarse hay que cambiar esta referencia.
    if (jQuery("#whyregisterwrapper").length) {
      var topBRef = jQuery("#whyregisterwrapper").position();
    }
  } else {
    var topBRef = jQuery("#block1").position();
  }

  //para el nuevointeraction approach.
  if (jQuery("#preophomeblock").length) {
    var pTopGRef = jQuery("#fakeDiff").position();
    //var topGRef = jQuery('#grey-in').position();
    //var topP = topGRef.top + pTopGRef.top - 180;//185,,160,,20
    var topP = pTopGRef.top; /*SYNC INTERACTION*/
    var topBRef = jQuery(".grey-last").position();
    var bottomRef = topBRef.top + 360; /*SYNC INTERACTION*/
    var heigh = bottomRef - topP;
  } else {
    var bottomRef = topBRef.top - 20;
    var heigh = bottomRef - topGRef.top + 25;
  }

  //console.log(topP);

  //console.log(heigh);

  //var width = jQuery(window).width();

  jQuery("body #fakeDiv").css({
    position: "absolute",
    display: "block",
    height: heigh + "px",
    width: "100%" /*width*/,
    top: topP + "px",
    "z-index": "-10",
    background: "#f6f6f6", //'#e9e9e9', redesign
    "min-width": "100% !important",
    margin: "0px",
    padding: "0px",
    overflow: "visible"
  });
  //We are going to replicate it with the second grey bloq.

  if (jQuery("#interaction-bloq").length) {
    var pTopGDownRef = jQuery("#bloque-cirujano").position();
    //var topGDownRef = jQuery('#grey-in').position();
    var topPDown = pTopGDownRef.top + 238; //185,,160,,20
    /*var topBRefDown = jQuery('#block1').position();

	  var bottomRef = topBRef.top - 30;
    var heigh = bottomRef - topGRef.top+53;*/
    console.log("fakeDivDown generated");
    if (jQuery(window).width() >= 640) {
      jQuery("body #fakeDivDown").css({
        position: "absolute",
        display: "block",
        height: "360px", //heigh +
        width: "100%" /*width*/,
        top: topPDown + "px", //topP +
        "z-index": "-10",
        background: "#f6f6f6", //'#e9e9e9', redesign
        "min-width": "100% !important",
        margin: "0px",
        padding: "0px",
        overflow: "visible"
      });
    } else {
      var topMovilDown = topPDown + 160;

      jQuery("body #fakeDivDown").css({
        position: "absolute",
        display: "block",
        height: "260px", //heigh +
        width: "100%" /*width*/,
        top: topMovilDown + "px", //topP +
        "z-index": "-10",
        background: "#f6f6f6", //'#e9e9e9', redesign
        "min-width": "100% !important",
        margin: "0px",
        padding: "0px",
        overflow: "visible"
      });
    }
  }

  //Vamos a añadir la lógica de los estilos propios de la home.

  if (jQuery("#page.is-home").length) {
    console.log("Ya tiene la clase is-home el elemento #page");
  } else {
    jQuery("#page").addClass("is-home");
  }
}

function fakeDivHidder() {
  jQuery("#fakeDiv,#fakeDivDown").css({ display: "none" });

  if (jQuery("#page.is-home").length) {
    jQuery("#page").removeClass("is-home");
  } else {
    console.log("No veníamos de la home");
  }
}

//Función para cargar el tooltip de jQuery UI a lo largo de toda la aplicación.

jQuery(document).ready(function() {
  jQuery(document).tooltip({ tooltipClass: "nc-tooltip", fixed: "true" }); //Para las posiciones ->,  position: { my: "left-10 center-5",at: "right center"}
});

//Añadimos el código de los botones scroll.

//Primero unas líneas de js sobre eventos que el autor del pluguin http://tympanus.net/codrops/2010/01/03/scrolling-to-the-top-and-bottom-with-jquery/ incluía

/*--------*/
(function() {
  var special = jQuery.event.special,
    uid1 = "D" + +new Date(),
    uid2 = "D" + (+new Date() + 1);

  special.scrollstart = {
    setup: function() {
      var timer,
        handler = function(evt) {
          var _self = this,
            _args = arguments;

          if (timer) {
            clearTimeout(timer);
          } else {
            evt.type = "scrollstart";
            jQuery.event.handle.apply(_self, _args);
          }

          timer = setTimeout(function() {
            timer = null;
          }, special.scrollstop.latency);
        };

      jQuery(this)
        .bind("scroll", handler)
        .data(uid1, handler);
    },
    teardown: function() {
      jQuery(this).unbind("scroll", jQuery(this).data(uid1));
    }
  };

  special.scrollstop = {
    latency: 300,
    setup: function() {
      var timer,
        handler = function(evt) {
          var _self = this,
            _args = arguments;

          if (timer) {
            clearTimeout(timer);
          }

          timer = setTimeout(function() {
            timer = null;
            evt.type = "scrollstop";
            jQuery.event.handle.apply(_self, _args);
          }, special.scrollstop.latency);
        };

      jQuery(this)
        .bind("scroll", handler)
        .data(uid2, handler);
    },
    teardown: function() {
      jQuery(this).unbind("scroll", jQuery(this).data(uid2));
    }
  };
})();

/*--------*/

//Jquery en sí de los scroll buttons.
jQuery(function() {
  // the element inside of which we want to scroll
  var $elem = jQuery("#page"); //#content

  // show the buttons
  jQuery("#nav_up").fadeIn("slow");
  jQuery("#nav_down").fadeIn("slow");

  // whenever we scroll fade out both buttons
  jQuery(window).bind("scrollstart", function() {
    jQuery("#nav_up,#nav_down")
      .stop()
      .animate({ opacity: "0.2" });
  });
  // ... and whenever we stop scrolling fade in both buttons
  jQuery(window).bind("scrollstop", function() {
    jQuery("#nav_up,#nav_down")
      .stop()
      .animate({ opacity: "1" });
  });

  // clicking the "down" button will make the page scroll to the $elem's height
  jQuery("#nav_down").click(function(e) {
    jQuery("html, body").animate({ scrollTop: $elem.height() }, 1000);
  });
  // clicking the "up" button will make the page scroll to the top of the page
  jQuery("#nav_up").click(function(e) {
    jQuery("html, body").animate({ scrollTop: "0px" }, 1000);
  });
});

/*vamos a ver si podemos añadir que los scrolls se produzcan tras varios segundos de hovers */
jQuery("#nav_down").hover(
  function() {
    clearTimeout(jQuery(this).data("timeout"));
    var $elem = jQuery("#page");
    jQuery("html, body").animate({ scrollTop: $elem.height() }, 2000);
  },
  function() {
    var t = setTimeout(function() {
      jQuery("html, body").stop();
    }, 100);
    jQuery(this).data("timeout", t);
  }
);
//Ahora con el nav_up.

jQuery("#nav_up").hover(
  function() {
    clearTimeout(jQuery(this).data("timeout"));
    var $elem = jQuery("#page");
    jQuery("html, body").animate({ scrollTop: "0px" }, 2000);
    jQuery("#nav_down").stop();
    //$('li.icon > ul').slideDown('fast');
  },
  function() {
    var t = setTimeout(function() {
      jQuery("html, body").stop();
    }, 100);
    jQuery(this).data("timeout", t);
  }
);

function toggleSites() {
  console.log("Toggle Sites ejecutada");

  if (jQuery("#top-header-countries").css("opacity") == "0") {
    jQuery("#top-header-countries").css("display", "block");
    jQuery("#top-header-countries").animate({ opacity: 1 }, { duration: 300 }); //css('display', 'block');
  } else {
    jQuery("#top-header-countries").animate({ opacity: 0 }, { duration: 300 });
    jQuery("#top-header-countries").css("display", "none");
  }
}

//Vamos ahora a implementar ajax en los links del menú principial que vayamos viendo -> cambiará también la url.

function goToMain(href, selectorsNotToFade, scrollTop, dragchecker) {
  //console.log('Función goToMain llamada');

  //sabemos que cualquier goToMain llamado desde el home implicará que el fakeDiv no esté visible
  if (jQuery("#sliderMBloqsWrapper #slider").length) {
    //fakeDivGenerator();
    fakeDivHidder();
  }

  //Podemos hacer de primeras un Fade selectivo.
  if (typeof selectorsNotToFade !== "undefined") {
    if (jQuery(selectorsNotToFade).length) {
      if (selectorsNotToFade == "#menu-cirugia") {
        jQuery("#main")
          .children()
          .children()
          .not("#menu-cirugia")
          .fadeTo("slow", 0.5);
        if (jQuery("#loadingGif.loadingGeneral").length) {
          jQuery("#loadingGif.loadingGeneral").css({
            display: "block"
          });
        }
      } else {
        if (selectorsNotToFade == "#LinkPages.testPagination") {
          //recordar que para fadeTo el not, tiene que etar en el nivel jerárquico correspondiente para funcionar
          jQuery("#main")
            .children()
            .children()
            .children()
            .not("div#PaginationWrapper")
            .fadeTo("fast", 0.5);
          if (jQuery("#loadingGif.loadingGeneral").length) {
            jQuery("#loadingGif.loadingGeneral").css({
              display: "block"
            });
          }
        } else {
          jQuery("#main")
            .children()
            .not(selectorsNotToFade)
            .fadeTo("fast", 0.5);
          if (jQuery("#loadingGif.loadingGeneral").length) {
            jQuery("#loadingGif.loadingGeneral").css({
              display: "block"
            });
          }
          console.log(
            "Los elementos" + selectorsNotToFade + "No han sufrido fade alguno"
          );
        }
        //alert('si si');
      }

      //jQuery(selectorsNotToFade).fadeTo('fast',0.85);
      console.log(selectorsNotToFade + "No han sufrido fade alguno");
    } else {
      //Final
      jQuery("#main").fadeTo("fast", 0.5);
      if (jQuery("#loadingGif.loadingGeneral").length) {
        jQuery("#loadingGif.loadingGeneral").css({
          display: "block"
        });
      }
    }
  } else {
    //Final

    jQuery("#main").fadeTo("fast", 0.5);
    if (jQuery("#loadingGif.loadingGeneral").length) {
      jQuery("#loadingGif.loadingGeneral").css({
        display: "block"
      });
    }
  }
  //Vamos a meter la lógica para que se respete el posicionamiento de los accordions sobre los que se ha hecho dragg.
  if (typeof dragchecker !== "undefined") {
    if (jQuery("#accordionFilterSecond").length) {
      var $accFSecond = jQuery("#accordionFilterSecond");
      if ($accFSecond.css("position") == "fixed") {
        var accFSecondTop = $accFSecond.css("top");
        var accFSecondLeft = $accFSecond.css("left");
        var accFSecondWidth = $accFSecond.css("width");

        var style1 = jQuery(
          "<style> #accordionFilterSecond { width:" +
            accFSecondWidth +
            "; position: absolute; left:" +
            accFSecondLeft +
            ";top:" +
            accFSecondTop +
            "; }</style>"
        );
        jQuery("html > head").append(style1);
      }
    }
    if (jQuery("#accordionFilterSimple").length) {
      var $accFSimple = jQuery("#accordionFilterSimple");
      if ($accFSimple.css("position") == "fixed") {
        var accFSimpleTop = $accFSimple.css("top");
        var accFSimpleLeft = $accFSimple.css("left");
        var accFSimpleWidth = $accFSimple.css("width");

        var style2 = jQuery(
          "<style> #accordionFilterSimple { width:" +
            accFSimpleWidth +
            "; position: absolute; left:" +
            accFSimpleLeft +
            ";top:" +
            accFSimpleTop +
            "; }</style>"
        );
        jQuery("html > head").append(style2);
      }
    }
    if (jQuery("#simpleAccordionFilter").length) {
      var $accsFilter = jQuery("#simpleAccordionFilter");
      if ($accsFilter.css("position") == "fixed") {
        var accsFilterTop = $accsFilter.css("top");
        var accsFilterLeft = $accsFilter.css("left");
        var accsFilterWidth = $accsFilter.css("width");

        var style3 = jQuery(
          "<style> #simpleAccordionFilter { width:" +
            accsFilterWidth +
            "; position: absolute; left:" +
            accsFilterLeft +
            ";top:" +
            accsFilterTop +
            "; }</style>"
        );
        jQuery("html > head").append(style3);
      }
    }
    if (jQuery("#advancedAccordionFilter").length) {
      var $accAFilter = jQuery("#advancedAccordionFilter");
      if ($accAFilter.css("position") == "fixed") {
        var accAFilterTop = $accAFilter.css("top");
        var accAFilterLeft = $accAFilter.css("left");
        var accAFilterWidth = $accAFilter.css("width");

        var style4 = jQuery(
          "<style> #advancedAccordionFilter { width:" +
            accAFilterWidth +
            "; position: absolute; left:" +
            accAFilterLeft +
            ";top:" +
            accAFilterTop +
            "; }</style>"
        );
        jQuery("html > head").append(style4);
      }
    }
    if (jQuery("#surgeonAccordionFilter").length) {
      var $accSxFilter = jQuery("#surgeonAccordionFilter");
      if ($accSxFilter.css("position") == "fixed") {
        var accSxFilterTop = $accSxFilter.css("top");
        var accSxFilterLeft = $accSxFilter.css("left");
        var accSxFilterWidth = $accSxFilter.css("width");

        var style5 = jQuery(
          "<style> #surgeonAccordionFilter { width:" +
            accSxFilterWidth +
            " ; position: absolute; left:" +
            accSxFilterLeft +
            ";top:" +
            accSxFilterTop +
            "; }</style>"
        );
        jQuery("html > head").append(style5);
      }
    }
  }

  /*Voy a cambiar el jQuery Aja por el Load creo...*/

  jQuery.ajax({
    url: href,
    beforeSend: function() {
      //Si es móvil hacemos un fade a todo menos el header para que el usuario vea que está pasando algo.
      if (jQuery(window).width() < 600) {
        jQuery("#menu-site").animate({ opacity: "0.2" }, 700);
        jQuery("#page").animate({ opacity: "0.5" }, 700);
        jQuery("#footer-wrap").animate({ opacity: "0.5" }, 700);
        jQuery("body").css("cursor", "wait !important");
      }
    },
    //   cache: false,
    success: function(data) {
      //Cargamos los scripts de la respuesta.
      //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
      console.log("Petición Ajax realizada con éxito");
      var dataRude = jQuery(data);
      var dataMain = dataRude.find("#main");
      dataMain.find("iframe").remove(); //Tuvimos que quitar el iframe de los forms de custom contact forms porque daba error en el ajax.
      var dataMainHtml = dataMain.html();
      //var mainContent = jQuery(data).find('#main').html();
      console.log("Sin iframes");

      //Tenemos que solucionar el tema del menú de cirugías.
      if (dataRude.find("#menu-cirugia").length) {
        console.log("La página que se va a descargar es de cirugía");
        if (jQuery("#menu-cirugia").length) {
          console.log("y estamos en una de cirugía");
        } else {
          console.log(
            "y no estamos en una de cirugía=> hay que añadir el menú"
          );
          $menuSx = dataRude.find("div.fullMenuWrapper");
          jQuery("#main").before($menuSx);
        }
      } else {
        console.log("la pagina a descargar no es de cirugía");
        if (jQuery("#menu-cirugia").length) {
          console.log(
            "y estamos en una de cirugía=> Retiramos el menu de cirugía por lo tanto"
          );
          jQuery("div.fullMenuWrapper").remove();
        }
      }

      //jQuery('#main').html(mainContent); //aquí está el asunto
      //jQuery('#main').html('<div>Smaple</div>');

      //console.log(dataRude);
      jQuery("#main").html(dataMainHtml);
      //console.log('linea 1003');
      //console.log('Contenido Central Remplazado');
      //Exito
      if (jQuery("#loadingGif.loadingGeneral").length) {
        jQuery("#loadingGif.loadingGeneral").css({ display: "none" });
      }

      jQuery("#main").fadeTo("fast", 1); //Necesitamos además cargar los scripts que activan los elementos presentes en la respuesta¡¡
      //Su está presente el form de lentes:
      if (jQuery("#iol_filter_form").length) {
        // do something here
        iolFormComboboxInputSlider();
        iolFormButtonAccordionLoader();
        jQuery("#addDisabler").DisablerButton();
        buttonsChangeFilterLoader();
        iolQueryStringUpdater();
        iolTextSearch();
        console.log("Condición de #iol_filter_form cumplida");
      }
      //función que ha de ejecutarse si la página que se descarga tiene el formulario de post op.
      if (jQuery("#post-op-form").length) {
        postOpFormLoader();
      }

      //La siguiente condición también en complete para ver si se ejecuta.
      if (jQuery("#patient_iol_filter_form").length) {
        PatientFormLoader();
        buttonsChangeFilterLoader();
        iolQueryStringUpdater();
        iolTextSearch();
        //alert('el patiene y el buttonschangeloader...');
      }

      //Tenemos que hacer los mismo con el form de clínicas.
      if (
        jQuery("#clinica_filter_form").length &&
        !jQuery("#primary.site-content-archive-clinica").length
      ) {
        //CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí

        clinicFormAccordionLoader();
        clinicFormComboButtonLoader();
        clinicaQueryStringUpdater();
        gmapsClinicsLoader();
        clinicaTextSearch();
        if (jQuery("#singleClinicTemplate").length) {
        } else {
          ClinicReseter();
        }
      }
      if (
        jQuery("#clinica_filter_form").length &&
        jQuery("#primary.site-content-archive-clinica").length
      ) {
        console.log("cargamos clinicaTextSearch");
        clinicaTextSearch(); //Añadimos el buscador de clínicas.
      }

      //También en la página correspondiente de explicación de clínicas
      if (jQuery("#clinicasIolUrl").length) {
        //CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí
        clinicFormAccordionLoader();
        clinicFormComboButtonLoader();
        clinicaQueryStringUpdater();
        gmapsClinicsLoader();
        /*Revisar estos procedimientos*/

        //Queremos que no salga el combo de selección de vista.
        jQuery("#comboViewTypeClinic").remove();
      }

      //en el archive submit me no funcionaba
      if (jQuery(".site-content-archive-clinica").length) {
        clinicFormAccordionLoader();
        clinicFormComboButtonLoader();
        clinicaQueryStringUpdater();
        console.log("pasamos jQuery por el filtrado de clínicas");
      }

      //También con el form del test.
      if (jQuery("#testLIO").length) {
        testFormButtonTabLoader();
      }
      //Lo mismo con la página de explicación de tipos de lentes para pacientes.
      if (jQuery("#left-explicacion-lio").length) {
        PatientFormLoader();
        buttonsChangeFilterLoader();
        activacionLeftMenuScroller();
        scrollToOnClick();
        jQuery("#comboViewType").remove();
      }

      if (jQuery("#menu-menu-anatomia-ojo").length) {
        scrollToOnClickAnatomy();
      }

      if (jQuery("#archiveClinicaTemplate").length) {
        //CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí

        clinicaInfoPannelLoader();
        buttonClinicaInfoPannelLoader();
      }
      //Metemos el ocultador del submenu de Mis Ojos.
      if (jQuery("#templateMisOjos").length) {
        showHideSubmenuMisOjos();
        //alert('condicion Template mis ojos detectada');
      }
      //Metemos la condición para la validación del formulario.
      if (jQuery("#post-op-form").length) {
        console.log("esto se cumple");
        postOpFormValidation();
      }

      //Metemos aquí el condicional del template de cirugía o de presbicia.
      if (
        jQuery("#templatePresbicia").length ||
        jQuery("#templateCirugiaOcular").length
      ) {
        addSelectToMenuCirugia();
        console.log("Sí que se ha aplicado el add select al menú superior");
      }
      //Metemos la condición de que si está el changeModeBloqContent rellene su contenido.
      if (jQuery("#changeModeBloq").length) {
        addChangeModeBloqContent();
        console.log("Ejecutada por presencia de #changeModeBloq");
      }
      //Metemos el callToFunction.
      //Añadimos el div de call to question.
      if (jQuery("#callToQuestion").length) {
        addCallToQuestion();
        console.log("callToquestion ejecutada");
      }

      //Hacemos visibles todos los elementos que tengan la clase de .startsUgly.
      jQuery(".startsUgly").show();

      //update the page title
      var title = jQuery("#main")
        .find("h1")
        .text();
      jQuery("head")
        .find("title")
        .text(title);

      //Metemos la actualización de la versiónd e Paciente o de Profesional.
      versionNcUpdater();
      console.log("Función de actualización de versión llamada desde gotomain");

      if (jQuery(window).width() < 600) {
        jQuery("#menu-site").animate({ opacity: "1" }, 700);
        jQuery("#page").animate({ opacity: "1" }, 700);
        jQuery("#footer-wrap").animate({ opacity: "1" }, 700);
        jQuery("body").css("cursor", "default");
      }

      //Metemos las funciones de user-data-manager
      if (
        jQuery("#setupform").length ||
        jQuery("#your-profile").length ||
        jQuery("form.user-manager-form").length
      ) {
        /*profileFormLoader();
											numerate_fields();
											give_wrapper_display();
											specific_input_relations();*/
        userDataFormLoader();
        userProfClinicsLoader();
        //gamifyier();
        //fineTunner();
      }
    },
    complete: function(data) {
      console.log("con redes sociales en ajax a medias");

      //Insertamos la parte de social.

      //Metemos la carga de los sociales si lo hay.
      if (jQuery("div.fb-page").length) {
        FB.XFBML.parse();
      }
      //Sabemos que los social de linkedin y Twitter van a estar en:
      //single lente, single-fabricante

      if (jQuery("div.qaSocial").length || jQuery("div.networkProf").length) {
        //Twitter
        if (typeof twttr != "undefined") {
          twttr.widgets.load();
        } else {
          jQuery.getScript("https://platform.twitter.com/widgets.js");
        }
      }

      if (jQuery("#linkedInWrapper").length) {
        //Parte de linkedIn

        jQuery("#linkedInWrapper").append(
          '<script type="IN/FollowCompany" data-id="10034187"></script>'
        );
        if (typeof IN != "undefined") {
          IN.parse();
        } else {
          jQuery.getScript("https://platform.linkedin.com/in.js");
        }
      }

      //Fin de la parte de social

      //Si está en la pagina de modelos de IOL.
      //Ponemos esta función en el complete porque en el success falla...
      if (jQuery("#modelosIol").length) {
        /*PatientFormLoader();
                buttonsChangeFilterLoader();*/
        iolInfoPannelLoader();
        buttonPannelLoader();
        //Queremos quitar el botón de paginación si se encuentra.

        jQuery("#comboViewType").remove();
      }
      //Si está el listado de clínicas asociadas hay que meter el script.
      if (jQuery("#singleLensClinics").length) {
        lensClinicsLoader();
      }
      //Si es la home tenemos que mostrar el fakediv
      if (jQuery("#sliderMBloqsWrapper #slider").length) {
        if (jQuery("body #fakeDiv").length == 0) {
          jQuery("body").append('<div id="fakeDiv">&nbsp;</div>');
        }
        fakeDivGenerator();
        console.log("fakeDivGenerator activado");
        //fakeDivHidder();
      }

      //Metemos ahora el del tipos de lentes para que se añada la clase "seleccionado" al item correspondiente del submenu.
      if (jQuery("#menu-menu-tipos-lentes").length) {
        var url = window.location.href;
        jQuery('.menu-menu-tipos-lentes-container a[href="' + url + '"]')
          .parent()
          .addClass("seleccionado");
      }

      //Metemos las llamadas necesarias para google charts en el post results.
      if (
        jQuery("#templatePostOpTestResult").length ||
        jQuery("#templatePostOp").length
      ) {
        // desde #templatePostOp
        console.log("Ahora es el surgeryResults Loader");
        //resultPostOpTabsLoader();
        surgeryShowResultsLoader();
        console.log("Fin del surgeryResults loader");
      }

      //Hay que ver la razón por la que el buttonloader no funciona onSuccess.
      //Vamoa a llevar a cabo la actualización del infoPannel.
      if (jQuery("#archiveIolTemplate").length) {
        //Pienso que lo único que hay que hacer es activarlo y punto.
        //alert('Por aquí que vino');
        iolInfoPannelLoader();
        buttonPannelLoader();
      }
      if (typeof scrollTop !== "undefined") {
        //alert('scroll top activado');
        console.log(
          "Por ejemplo en los links del footer habrá que hacerle scroll."
        );
        if (jQuery("#menu-site").length) {
          jQuery("html, body").animate(
            { scrollTop: jQuery("#menu-site").offset().top },
            2000
          ); //Cambiamos #primary por menu-site
        } else {
          if (jQuery("#top-header-blog").length) {
            jQuery("html, body").animate(
              { scrollTop: jQuery("#top-header-blog").offset().top },
              2000
            );
          } else {
            if (jQuery("#top-header-foro").length) {
              jQuery("html, body").animate(
                { scrollTop: jQuery("#top-header-foro").offset().top },
                2000
              );
            }

            if (jQuery("#qa-menu").length) {
              console.log("al qa-menu");
              jQuery("html, body").animate(
                { scrollTop: jQuery("#qa-menu").offset().top },
                2000
              );
            }
          }
        }
      }

      //Quitar el viewtype combobox cuando es la página de modelos.
      if (jQuery(".site-content-modelos-lentes").length) {
        jQuery("#comboViewType").css("visibility", "hidden");
        console.log("viewtype quitado");
      }

      if (jQuery("#templateIolSimulator").length) {
        //alert("SimLoader");
        SimLoader();
      }
      //Metemos la validación del perfil de clínica
      if (jQuery("#primary.clinic-profile form").length) {
        jQuery("#primary.clinic-profile form").submit(function(event) {
          if (jQuery('input[name="clinicname"]').val() == "") {
            event.preventDefault();
            jQuery('label[for="clinicname"]').css("color", "red");
            return false;
          }
          if (jQuery('input[type="checkbox"]').prop("checked") != true) {
            event.preventDefault();
            jQuery("label.checkbox").css("color", "red");
            return false;
          }
          return true;
        });
      }

      //Vamos a poner la condición de que si está en móvil se mueva al inicio del content.
      //Mobile
      if (jQuery(window).width() < 600) {
        if (jQuery("#content").length) {
          scrollToElement(jQuery("#content"));
          console.log("Scroll realizado por gotomain al estar en Movil...");
        }
        if (jQuery("#content-quienes").length) {
          scrollToElement(jQuery("#content-quienes"));
        }
      }

      //Añadimos el efecto vertical accordion a los menus del area interna.
      if (
        jQuery("#menu-menu-myprofile").length ||
        jQuery("#menu-menu-mync").length
      ) {
        accordionProfAndMyNC();
      }

      //Ejecutamos el lightbox
      //jQuery('a[rel=lightbox]').colorbox();  --> Lo Ampliamos
      //Añado este nuevo selector porque en un update se ha debido ir...
      jQuery("a[rel*=lightbox],a[data-lightboxplus=lightboxplus]").colorbox({
        maxWidth: "90%",
        maxHeight: "90%"
      });
    }
  });
}

//Con esta función añadiremos el contenido del changeModeBloq
function addChangeModeBloqContent(){
	jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data:  { action: "addChangeModeBloqContent"},
        cache: true,
        success:
            function (response_from_the_action_function) {

				jQuery('#changeModeBloq div.contenidoMode').html(response_from_the_action_function);
            },
        beforeSend: function () {
         console.log('addChangeModeBloqContent ejecutandose');
						        },
	   complete: function () {
        	//añadimos el onClick event para el changeVersionContentBloq
        	jQuery('.contentModeBloq a#changeModeLink').click(function(event){
        				event.preventDefault();
        				versionNCChangeRefresh();
        				//goToMain()
        	});

        	jQuery('.contentModeBloq a#changeModeHelp').click(function(event){
        		event.preventDefault();
        		goToHelp(jQuery(this).attr('href'),'primary','primary');
        		console.log('gotTohelp disparada');

        	});

             }

            }

            );
      console.log('addChangeModeBloqContent ejecutada');

}


function Ajaxor() {
  if (getPartOfTheSite()) {
    if (typeof history.pushState !== "undefined") {
      console.log("historyCount puesto a 0");
      var historyCount = 0;
      //A continuación estamos asignando la función gotoMain...
      //A los links que no necesitan un remplazo de toda la página puesto que están en un submenú(:el main de ese grupo ya se ha descargado), tendremos que asignarles el gotoContent.

	  var homePageUrl = 'https://'+location.hostname;

      var selectorsArrayNoGoToMain = new Array(
        //
        "#menu-top-menu a",
        "body.home a",
'a[href="'+homePageUrl+'"]',
        //
        'a[href *= "https://' + urlSITE + '/wp-admin"]',
        "div.link-to-archive a",
        "#top-header-blog a",
        "div.groupLinkToPage a",
        "#changeFilter a",
        'a[href*="https://' + urlSITE + '/logout"]',
        "#dc_jqmegamenu_widget-2-item ul#menu-menu-site li:nth-child(7) .sub-container.non-mega li:nth-child(2) a",
        "#news #foro a ",
        "#destacados .destacado2 h2 a",
        "#lateral-presbicia a",
        "#LinkPages.testPagination a",
        "a.bbp-topic-edit-link ",
        "a[rel=lightbox]",
        "#menu-header-foro a",
        "#submisojos a",
        "#subfaqs a",
        "#menu-menu-explicacion-tipos-lio a",
        ".submenu-pages #menu-menu-tipos-lentes a",
        "#LinkPages.archiveLenteIntraocularAjaxer a",
        "#LinkPagesBis.archiveLenteIntraocularAjaxer a",
        "div#primary.site-content-archive-clinica #LinkPages a",
        "div#primary.site-content-archive-clinica #LinkPagesBis a",
        "#footer-wrap a",
        "#helpTitle a",
        "#menu-cirugia a",
        "#menu-cirugia-submenu a",
        ".noGotoMain",
        "nogotomain",
        "#bloque-cirujano a",
        "div.footerClinicas a",
        "#loginStuff a.noGotoMain",
        ".content-destacado a",
        ".block h2 a",
        ".block-last h2 a",
        "#helpTitle a",
        "#testimonios-home a",
        "#top-header-qa a",
        "#mCLens a",
        "a.cboxElement",
        "a.linkSubTipoIol",
        "div.groupLinkArchive a",
        "#rightLogin a",
        "#community.rightProfile a",
        ".nWindIol",
        "div.moreClinics a",
        "div.bloq-single-lente.std div.value a",
        ".searchLink a",
        "#block1left a",
        "div.clinicListsWrapper a",
        ".widget_recent_entries ul li a",
        ".widget_categories ul li a",
        "#bbpress-forums a.bbp-breadcrumb-home",
        "#list-topic-forum ul li a",
        "#list-forum ul li a",
        "#list-countries-forum ul li a",
        "#list-about-forum ul li a",
        "#footer-wrap-blog a",
        ".slideImgWrapper a",
        "a.singleIOLFeatImage",
        "li#qa-current-url a",
        "div.archive-clinica-wrapper h1.archive-clinica-title a",
        "a.bbp-forum-title",
        "div#widget-forum ul.tml-user-links a",
        "a.bbp-breadcrumb-forum",
        "a.bbp-topic-permalink",
        "#qa-menu ul li:nth-child(3) a",
        "div.question-summary h3 a",
        "div.yarpp-related a",
        "#qSugLinks ul li a",
        "#bbpress-forums li.bbp-forum-freshness a",
        "#changeModeHelp",
        "div.contenidoCallToQuestion a",
        "#buscadorBody footer#colophon a",
        ".firstPoint a",
        ".rightBCWrapper2 a",
        "#content.template-bucador-clinicas #sponsoredListWrapper a",
        "#mVisitedClinics a", //:not(#buscadorBody footer#colophon a)
        "#menu-menu-site > li:nth-child(7) > a",
        //Vamos a meter algunos de scroll
        "div.leermas-blog a",
        "aside.widget-container.widget_display_replies ul li a",
        "ul#recentcomments li.recentcomments a",
        "div.qa-pagination a",
        "#grey-in #grey3 h2 a",
        "aside.widget-container.widget_question_tags div.question-tagcloud a",
        "aside.widget-container.widget_question_categories ul li a",
        "aside.widget-container.widget_questions ul li a",
        "#content-blog .entry-header h1 a",
        "#blog-blocks ul li.recentcomments a",
        "a.provFSpan",
        "body.single-post article .entry-content p a",
        "body.single-question .answer-content p a",
        "body.single-post article .entry-content li a",
        "body.single-question .answer-content li a",
        ".comment-content.comment a",
        "#widgetblog #mainClinics a",
        ".bbp-reply-content a",
        "span.sugClinicMas a",
        "#userName a",
        "#loginStuff a",
        "ul.tml-action-links li a",
        "div.homeBloqQA a",
        "div.homeBloqForo a",
        "#doctoresRight a",
        "#doctores-particular a",
        "#mCLens a",
        ".must-log-in a",
        "a.comment-reply-login",
        "#qa-user-tabs a",
        "#menu-menu-anatomia-ojo ul.sub-menu a",
        "ul#menu-menu-anatomia-ojo > li >a",
        "ul#qa-user-tabs li a",
        "ul.whyregisterlist > li:nth-child(1) a",
        "div.advRegisterWrapper ul.whyregisterlist li a",
        "div.quickMessage-notok a",
        "div.patologia-buttons a",
        "#block1.redesign a",
        "#whyRegisterButton a",
        "ul#menu-menu-myprofile > li:nth-child(1) > ul > li:nth-child(2) a" /*Perfil completo*/,
        ".submenu-pages.not_logged #menu-menu-myprofile > li > a",
        "div.testresults a",
        "div#loginStuff a",
        "#whyregisterwrapper a",
        "div.linkToIolProSelector a",
        "#profile-graph-info a",
        "li.mega-noGotoMain a",
        "li.noGotoMain a",
        "ul.the_champ_sharing_ul a",
        "#wizard a",
        "#postophomeblock a",
        "#opTypeLinksWrapper a",
        ".patogrey a",
        "div.downloadable a",
        ".noGotoMain a"
      );
      var selectorsStringNoStandardGoToMain = selectorsArrayNoGoToMain.join(
        ","
      );

      //alert('Modificación de historial del navegador');
      jQuery(
        ' a[href*="https://' +
          urlSITE +
          '"]:not(' +
          selectorsStringNoStandardGoToMain +
          ")"
      ).live("click", function() {
        console.log("EL SELECTOR NO HA FUNCIONADO");
        var href = jQuery(this).attr("href"); //#rightFaqsSxCataratas a,

        if (
          jQuery(this)
            .attr("href")
            .indexOf("forums") != -1 ||
          jQuery(this)
            .attr("href")
            .indexOf("tecnologia-lentes-intraoculares") != -1 ||
          jQuery(this)
            .attr("href")
            .indexOf("preguntas-cirujano-ocular") != -1
        ) {
        } else {
          //alert('Cogida por goToMain');
          goToMain(href);
          history.pushState(null, null, href);
          //AVISO GAnalytics cambio de página
          href = href.replace("https://" + document.domain, ""); //GA_CHANGE
          ga("send", "pageview", href);
          console.log("3");
          console.log(
            "pushState llevado a cabo a:" +
              href +
              "como asignación automática de goToMain"
          );
          return false;
        }
      });

      jQuery("#menu-menu-cirugia a").live("click", function() {
        var href = jQuery(this).attr("href");
        goToMain(href, "#menu-cirugia");
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);

        console.log(
          "#menu-cirugía no ha sufrido fade en teoría, pushState llevado a cabo a:" +
            href +
            "como asignación automática de goToMain"
        );

        return false;
      });
      //En los siguientes hay scroll top (metemos también el de explicación básica)
      var selectorsArrayScroll = new Array(
        "#content.template-clinicas div.clinicListsWrapper a",
        "#block1left a",
        "#mCLens a",
        "a.linkSubTipoIol",
        "div.groupLinkArchive a",
        "div.groupLinkToPage a",
        "div.moreClinics a",
        "div.bloq-single-lente.std div.value a",
        ".widget_recent_entries ul li a",
        ".widget_categories ul li a",
        "#list-topic-forum ul li a",
        "#list-forum ul li a",
        "div.archive-clinica-wrapper h1.archive-clinica-title a",
        ".secondPoint a",
        ".thirdPoint a",
        //Vamos a meter algunos de scroll.
        "div.leermas-blog a",
        "aside.widget-container.widget_display_replies ul li a",
        // 'ul#recentcomments li.recentcomments a',
        "div.qa-pagination a",
        "aside.widget-container.widget_question_tags div.question-tagcloud a",
        "aside.widget-container.widget_question_categories ul li a",
        "aside.widget-container.widget_questions ul li a",
        "#content-blog .entry-header h1 a",
        "a.provFSpan",
        "ul#menu-menu-anatomia-ojo >li >a"
      );
      var selectorsStringScroll = selectorsArrayScroll.join(",");
      jQuery(
        selectorsStringScroll + ":not(#buscadorBody footer#colophon a)"
      ).live("click", function() {
        var href = jQuery(this).attr("href");
        goToMain(href, null, "ScrollTop");
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);

        return false;
      });

      //El que descarga los resultados de satisfacción del paciente necesita una función específica
      jQuery(
        "#dc_jqmegamenu_widget-2-item ul#menu-menu-site li:nth-child(7) .sub-container.non-mega li:nth-child(2) a, #destacados .destacado2 h2 a, #destacados .destacado1 h2 a, #testimonios-home a"
      ).live("click", function() {
        var href = jQuery(this).attr("href");
        surgeryShowResultsLoader();
        goToMain(href, null, "ScrollTop");
        history.pushState(null, null, href);

        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);
        console.log("4");
        console.log(
          "pushState llevado a cabo a:" +
            href +
            "como asignación automática de goToMain"
        );
        return false;
      });

      //Metemos ahora los de cirugías.
      //Con el de ayuda no queremos hacer push state
      jQuery(
        "#submisojos a,#subfaqs a, .submenu-pages #menu-menu-tipos-lentes a"
      ).live("click", function() {
        var href = jQuery(this).attr("href");
        goToContent(href);
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);
        console.log("5");
        console.log(
          "pushState llevado a cabo a:" +
            href +
            "como asignación automática de goToMain"
        );

        return false;
      });
      //-- Los links de ayuda van con la función goToHelp
      jQuery("#helpTitle a").live("click", function() {
        var href = jQuery(this).attr("href");
        //El resto de parámetros lo vamos a sacar mediante data attributes del link.
        idToGet = jQuery(this).data("idtoget");
        //console.log('El idToGet es: ' + idToGet);
        idToReplace = jQuery(this).data("idtoreplace");
        //console.log('El idToReplace es: ' + idToReplace);
        if (jQuery(this).data("selectorsnottofade") == "") {
          selectorsNotToFade = null;
        }
        if (jQuery(this).data("scrolltop") == "") {
          scrollTop = jQuery(this).data("scrolltop");
        }

        goToHelp(href, idToGet, idToReplace); //, selectorsNotToFade, scrollTop
        //console.log('goToHelp llamada y ejecutada');

        return false;
      });

      //Ahora los links de la paginación del test merecen una llamada a gotomain específica
      jQuery("#LinkPages.testPagination a").live("click", function() {
        var href = jQuery(this).attr("href");
        goToMain(href, "#LinkPages.testPagination", "yes");
        console.log("Específico para paginación del test");
        return false;
      });

      //A los links de abajo y a los de #content-destacado le damos el scroll to top.
      jQuery(
        "#destacados .destacado1 h2 a, #mVisitedIols a:not(#buscadorBody footer#colophon a), #corporativeLinks a:not(#buscadorBody footer#colophon a), div.link-to-archive a:not(#buscadorBody footer#colophon a), .content-destacado a, .block-last h2 a, .block h2 a, block-last h2 a:not(#buscadorBody footer#colophon a)"
      ).live("click", function() {
        var href = jQuery(this).attr("href");
        goToMain(href, null, "scrollTop");
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);

        return false;
      });

      //Parte izquierda del menú de presbicia
      jQuery("#lateral-presbicia #menu-cirugia-submenu a").live(
        "click",
        function() {
          var href = jQuery(this).attr("href");
          goToContent(href);
          history.pushState(null, null, href);
          //AVISO GAnalytics cambio de página
          href = href.replace("https://" + document.domain, ""); //GA_CHANGE
          ga("send", "pageview", href);

          return false;
        }
      );

      jQuery("#leftFaqsPresbicia a").live("click", function() {
        var href = jQuery(this).attr("href");
        goToContent(href, jQuery(this).data("hashidselector"));
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace("https://" + document.domain, ""); //GA_CHANGE
        ga("send", "pageview", href);

        return false;
      });

      //Cargamos la función scroll to de la parte derecha de Operación Cataratas.
      /* jQuery('#rightFaqsSxCataratas li a').live('click', function () {
         scrollToElement(jQuery(jQuery(this).data('hashidselector')));

         return false;
     });*/

      //Cargamos ahora la función Onpopstate
      //El evento onpopstate está asociado al navegador no al link: Hay que poner el gotoMain o el gotoContent en función de función de la url.
      //La url destino te viene dada por el document.location

      window.onpopstate = function() {
        //Esto es para el primer onpopsate de Chrome.
        if (historyCount) {
          var urlActual = document.location;
          console.log("esto nos va a lelvar a " + urlActual);
          goToMain(urlActual);

          //window.location.href = urlActual;
          //Para mejorar la experiencia del usuario habrá que poner en qué casos hay goToMain y en cuales window.location.href
          console.log(
            "onpopstate activada. HistoryCount con valor: " + historyCount
          );
        } else {
          console.log("historyCount ha dado false");
          //historyCount = historyCount + 1;
        }
      };

      //El problema es que Firefox no dispara el evento onpopstate con el load de la primera página.

      jQuery(window).load(function() {
        console.log("1185");
        var isChrome =
          /Chrome/.test(navigator.userAgent) &&
          /Google Inc/.test(navigator.vendor);
        console.log("El hostname es: " + location.hostname);
        console.log("el docuemnt referer es: " + document.referrer);
        if (
          (jQuery.browser.mozilla &&
            !historyCount &&
            document.referrer.indexOf(location.hostname) == -1) ||
          (isChrome &&
            !historyCount &&
            document.referrer.indexOf(location.hostname) == -1)
        ) {
          href = window.location;
          history.pushState(null, null, href);
          historyCount = historyCount + 1;
          console.log("historyCount puesto a" + historyCount);
          console.log("Pushsate llevado a:" + href);
        }
        //No tenemos que forzar nosotros el pushState puesto que ya lo hace el propio nav pero resetea nuestro contador de historial
        //con lo que hay que reiniciarlo con valor 1.
        historyCount = historyCount + 1;
        console.log(
          "esta página se ha cargado viniendo del site, ponemos el history count a: 1"
        );
      });
    }
  }
}



//Creamos la función gotocontent para sólo cambiar el div id=content de la página.
function goToContent(href,hashScrollTo) {
    jQuery('#content').fadeTo('fast', 0.5);
           if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }

    console.log('Función GoToContent llamada');
    jQuery.ajax({
        url: href,
        //   cache: false,
        success: function (data) {

            //Cargamos los scripts de la respuesta.
            //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
            console.log('Petición Ajax realizada con éxito');
            var mainContent = jQuery(data).find('#content').html(); //Queremos sólo el interior de #content
            //console.log(mainContent.html());
            jQuery('#content').html(mainContent);
            console.log('Contenido Central Remplazado');
            //Exito
            if (jQuery("#loadingGif.loadingGeneral").length) {
            jQuery("#loadingGif.loadingGeneral").css({ "display": "none" });
            }
            jQuery('#content').fadeTo('fast', 1);

            //Vamos a detectar la función que actualiza el pannel.
            //Aquí hay que hacer una descarga selectiva de funciones como la que se ha hecho con GoToMain.


            //update the page title
            var title = jQuery('#main').find('h1').text();
            jQuery('head').find('title').text(title);
        },
        complete: function () {
            //jQuery('a[rel=lightbox]').colorbox();
            jQuery('a[rel*=lightbox],a[data-lightboxplus=lightboxplus]').colorbox({maxWidth:'90%', maxHeight:'90%'});
            //Metemos el ocultador del submenu de Mis Ojos.
            if (jQuery('#templateMisOjos').length) {
                showHideSubmenuMisOjos();
                //alert('condicion Template mis ojos detectada');
            }



            //Si el parámetro hashScrollTo está definido es que hay que direccionar
            if (typeof (hashScrollTo) != 'undefined') {
                scrollToElement(jQuery(hashScrollTo));
            }

            			if(jQuery(window).width() < 600){

          				//vamos a poner un par de scrolls  en función de los tipos de contenido porque el usuario del móvil no se dá cuenta de que se
									//ha descargado el contenido.

								/*	if(jQuery('.tipos-lente-intraocular').length){//page tipos de lente intraocular
										scrollToElement(jQuery('#content')); //QUITADO!!! AUNQUE SEA GOTOCONTENT, No se percibiía bien el cambio de contenido.
										}
*/
										//Vamos a poner la condición de que si está en móvil se mueva al inicio del content.
										//Mobile
										if(jQuery(window).width() < 600){
											if(jQuery('#content').length){
											scrollToElement(jQuery('#content'));
											console.log("Scroll realizado por gotomain al estar en Movil...");
										}
											if(jQuery('#content-quienes').length){
											scrollToElement(jQuery('#content-quienes'));}


										}




            			}



        }
    });
}
