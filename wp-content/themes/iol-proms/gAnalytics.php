<?php
   
//Si es ajax tapoco veo por qué tiene que se necesario esto... ya estamos ejecutando el evento con ga send... creo

//if( !(! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest') ) {

if(get_locale()=='es_MX'){
?> 
    <!-- Google Analytics Mexico -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-2',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>
<?php }?>

<?php if(get_locale()=='es_ES'){ ?>
<script>

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date(); a = s.createElement(o),
    m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-45337158-1',  {  'siteSpeedSampleRate': 100  });
    ga('send', 'pageview');

</script>
<?php }?>

<?php if(get_locale()=='en_GB'){ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-3',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>
<?php }?>


<!-- g Analytics Aleman -->
<?php if(get_locale()=='de_DE'){ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  //ga('create', 'UA-45337158-4', 'neuelinsen.com');
  ga('create', 'UA-45337158-4',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>
<?php }?>

<!-- g Analytics de Colombia -->
<?php if(get_locale()=='es_CO'){ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-5',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>
<?php }?>
<!-- Fin g Analytics Alemán-->


<!-- g Analytics de Francia -->
<?php if(get_locale()=='fr_FR'){?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-6',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>
<?php }?>

<!-- Fin de g Analytics de Francia -->

<!-- g Analytics de Chile -->
<?php if(get_locale()=='es_CL'){?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-7',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>

<?php }?>

<!-- Fin de g Analytics de Chile -->

<!-- g Analytics de Chile -->
<?php if(get_locale()=='de_AT'){?>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-8',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>


<?php }?>

<!-- Fin Google Analytics -->

<!-- g Analytics de USA -->
<?php if(get_locale()=='en_US'){?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45337158-9',  {  'siteSpeedSampleRate': 100  });
  ga('send', 'pageview');

</script>


<?php }?>