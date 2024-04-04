//Función para evitar el flickeo a la izquierda del menú superior.

jQuery(document).ready(function() {
  updateMenuQaItem();
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

/*jQuery(document).ready(function() {
  jQuery(document).tooltip({ tooltipClass: "nc-tooltip", fixed: "true" }); //Para las posiciones ->,  position: { my: "left-10 center-5",at: "right center"}
});
*/
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

/* Metemos js que había en el plugin de lente intraocular y debería venir aquí */
//Cargamso la variable con la url del sitio en función del get locale.
/*
if (ncSITE.Country) {
  //console.log('Lo ha cogido y es: '+site.Country);
  switch (ncSITE.Country) {
    case "es_ES":
      urlSITE = "www.nuevocristalino.es";
      break;
    case "es_MX":
      urlSITE = "www.nuevocristalino.mx";
      break;
    case "en_GB":
      urlSITE = "www.newlens.co.uk";
      break;
    case "de_DE":
      urlSITE = "www.neuelinsen.com";
      break;
    case "es_CO":
      urlSITE = "www.nuevocristalino.co";
      break;
    case "fr_FR":
      urlSITE = "www.nouveaucristallin.com";
      break;
    case "es_CL":
      urlSITE = "www.nuevocristalino.cl";
      break;
    case "de_AT":
      urlSITE = "www.neuelinsen.at";
      break;
    case "en_US":
      urlSITE = "www.mylifestylelens.com";
      break;

    default:
      urlSITE = "www.nuevocristalino.es";
  }
} else {
  urlSITE = "www.nuevocristalino.es";
}*/

function getPartOfTheSite() {
  var url = window.location.href;
  var splits = url.replace("https://", "").split("/");
  var PartesSite = new Array(
    "wp-admin",
    "forums",
    "preguntas-cirujano-ocular",
    "tecnologia-lentes-intraoculares"
  );

  if (PartesSite.indexOf(splits[1]) > -1) {
    console.log("ajax deshabilitado");
    return false;
  } else {
    console.log("ajax habilitado");
    return true;
  }
  return false;
}

if (getPartOfTheSite()) {
  if (typeof history.pushState !== "undefined") {
    console.log("historyCount puesto a 0");
    var historyCount = 0;
    //A continuación estamos asignando la función gotoMain...
    //A los links que no necesitan un remplazo de toda la página puesto que están en un submenú(:el main de ese grupo ya se ha descargado), tendremos que asignarles el gotoContent.
    var urlSITE = window.location.hostname;

    var selectorsArrayNoGoToMain = new Array(
	  "#main-header a",
      "#menu-top-menu a",
      "#mVisitedIols a",
      "#mVisitedClinics a",
      'a[href *= "https://' + urlSITE + '/wp-admin"]',
      'a[href*="https://' + urlSITE + '/logout"]',
      "#changeFilter a",
      'a[href*="https://' + urlSITE + '/logout"]',
      "#dc_jqmegamenu_widget-2-item ul#menu-menu-site li:nth-child(7) .sub-container.non-mega li:nth-child(2) a",
      "a[rel=lightbox]",

      "#footer-wrap a",
      "#helpTitle a",
      ".noGotoMain",
      "nogotomain",
      "#loginStuff a.noGotoMain",
      "#rightLogin a",
      "#community.rightProfile a",
      ".slideImgWrapper a",
      "li#qa-current-url a",
      "div.question-summary h3 a",
      "div.yarpp-related a",
      "#qSugLinks ul li a",
      "#changeModeHelp",
      ".firstPoint a",
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
      "body.single-question .answer-content li a",
      ".comment-content.comment a",
      "#widgetblog #mainClinics a",
       "div.testresults a",
      "div#loginStuff a",
      "#whyregisterwrapper a",
      "li.mega-noGotoMain a",
      "li.noGotoMain a",
      "#wizard a",
      "#postophomeblock a",
      "#opTypeLinksWrapper a",
      ".patogrey a",
      "div.downloadable a",
      ".noGotoMain a"
    );
    var selectorsStringNoStandardGoToMain = selectorsArrayNoGoToMain.join(",");

    //alert('Modificación de historial del navegador');
    jQuery(
      ' a[href*="https://' +
        urlSITE +
        '"]:not(' +
        selectorsStringNoStandardGoToMain +
        ")"
    ).live("click", function() {
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
    jQuery("div.dwqa-pagination a").live("click", function() {
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

/* La función goToMain */

//Vamos ahora a implementar ajax en los links del menú principial que vayamos viendo -> cambiará también la url.

function goToMain(href, selectorsNotToFade, scrollTop, dragchecker) {
  console.log("Función goToMain llamada");
  //sabemos que cualquier goToMain llamado desde el home implicará que el fakeDiv no esté visible
  if (jQuery("#sliderMBloqsWrapper #slider").length) {
    //fakeDivGenerator();
    fakeDivHidder();
  }
  console.log("POINT 7");
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
  console.log("POINT 6");
  //Vamos a meter la lógica para que se respete el posicionamiento de los accordions sobre los que se ha hecho dragg.

  console.log("POINT 5");

  console.log("POINT 2");

  console.log("POINT 1");
  //menu qa.
  if (jQuery("#menu-menu-cat-qa li a").length) {
    updateMenuQaItem();
  }

  /*Voy a cambiar el jQuery Aja por el Load creo...*/
  console.log("REALIZANDO PETICION AJAX");
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

      console.log("pasando por aqu");
      if (jQuery("#menu-menu-cat-qa li a").length) {
        updateMenuQaItem();
        console.log("TENIENDO LUGAR updateMenuQaItem");
      }
    },
    complete: function(data) {
      console.log("con redes sociales en ajax a medias");

      if (typeof scrollTop !== "undefined") {
        //alert('scroll top activado');
        console.log(
          "Por ejemplo en los links del footer habrá que hacerle scroll."
        );
        if (jQuery("#menu-qa").length) {
          jQuery("html, body").animate(
            //#menu-qa
            { scrollTop: jQuery("div.dwqa-question-filter").offset().top },
            2000
          );
        } /*
        if (jQuery("#menu-site").length) {
          jQuery("html, body").animate(
            { scrollTop: jQuery("#menu-site").offset().top },
            2000
          ); //Cambiamos #primary por menu-site
        }*/
      }

      //Vamos a poner la condición de que si está en móvil se mueva al inicio del content.
      //Mobile
      if (jQuery(window).width() < 600) {
        if (jQuery("#content").length) {
          scrollToElement(jQuery("#content"));
          console.log("Scroll realizado por gotomain al estar en Movil...");
        }
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
function versionNcUpdater() {
  if (userEsPaciente()) {
    jQuery(".pteNoDisplay").css("display", "none");
    jQuery(".pteDisplay").css("display", "block");
    console.log("Mostrando pteDisplay y ocultano pteNoDisplay");
    //Single IOL
    if (jQuery("#primary.site-content-single.single-lente").length) {
      //Ojo porque si es móvil la propiedad CSS cambia.
      if (jQuery(window).width() > 600) {
        jQuery("#primary.site-content-single.single-lente").css("width", "68%"); //68%
      } else {
        jQuery("#primary.site-content-single.single-lente").css("width", "95%");
      }

      if (jQuery("#main").width() > 970) {
        jQuery("#preButtonSetSingle #helpTitle a").css("left", 832);
      } else {
        console.log("#preButtonSetSingle #helpTitle a, puesto a 520");
        jQuery("#preButtonSetSingle #helpTitle a").css("left", 520);
      }

      //Añadimo el contenido y marcado específico para pacientes correspondiente a esa lente.
      addSingleIolPatientContent();

      console.log("single IOl updateada");
    }
    //Vamos a meter también la lógica de updatear el combo para dejarnos de lios.
    if (jQuery("#changeModeLink").length) {
      jQuery("span.profChangeVersion.active").removeClass("active");
      jQuery("span.modeSpanActive.modeProf").removeClass("modeSpanActive");
      jQuery("span.modeProf").addClass("modeSpanInactive");

      jQuery("span.pteChangeVersion").addClass("active");
      jQuery("span.modeSpanInactive.modePte").removeClass("modeSpanInactive");
      jQuery("span.modePte").addClass("modeSpanActive");
    }
  } else {
    jQuery(".pteNoDisplay").css("display", "block");
    jQuery(".pteDisplay").css("display", "none");
    console.log("Ocultando pteDisplay y mostrando pteNoDisplay");
    //Single IOL
    if (jQuery("#primary.site-content-single.single-lente").length) {
      if (jQuery(window).width() > 600) {
        jQuery("#primary.site-content-single.single-lente").css("width", "51%"); //51
      } else {
        jQuery("#primary.site-content-single.single-lente").css("width", "95%"); //64
      }

      if (jQuery("#main").width() > 970) {
        jQuery("#preButtonSetSingle #helpTitle a").css("left", 615);
      } else {
        console.log("#preButtonSetSingle #helpTitle a, puesto a 520");
        jQuery("#preButtonSetSingle #helpTitle a").css("left", 520);
      }

      console.log("single IOl updateada");
    }
    //Vamos lógica de updatear el combo.
    if (jQuery("#changeModeLink").length) {
      jQuery("span.pteChangeVersion.active").removeClass("active");
      jQuery("span.modeSpanActive.modePte").removeClass("modeSpanActive");
      jQuery("span.modePte").addClass("modeSpanInactive");

      jQuery("span.profChangeVersion").addClass("active");
      jQuery("span.modeSpanInactive.modeProf").removeClass("modeSpanInactive");
      jQuery("span.modeProf").addClass("modeSpanActive");
    }
  }
}

function userEsPaciente() {
  if (jQuery.cookie("ncpatient") == "ncpatient") {
    // , { path: '/' } && jQuery.cookie('ncpatient') != 'null'
    console.log("ESTAMOS EN MODO PACIENTE");
    return true;
  } else {
    console.log("NO ESTAMOS EN MODO PACIENTE");
    return false;
  }
}

function updateMenuQaItem() {
  console.log("TENIENDO LUGAR updateMenuQaItem");
  jQuery("#menu-menu-cat-qa li a").each(function() {
    console.log("click detectado");
    console.log(location.href.split("?")[0]);
    if (jQuery(this).attr("href") === location.href.split("?")[0]) {
      jQuery(this).addClass("selected");
    } else {
      jQuery(this).removeClass("selected");
    }
  });
}


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

