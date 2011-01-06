<?php

$error = false;
if (isset($_FILES['inputfile'])) {
  if ($_FILES['inputfile']['error'] > 0) {
    $error = 'Грешка: ' . $_FILES['inputfile']['error'];
  } elseif ($_FILES['inputfile']['type'] != 'application/zip') {
    $error = 'Невалиден файл. Трябва да подаденете архива свален от сайта на Vivacom с име подобно на 13296161001_201012.zip';
  } else {
    // generate temporary dir
    while (true) {
        $dir = tempnam(sys_get_temp_dir(), 'vig');
        unlink($dir);
        if (@mkdir($dir))
            break;
    }

    $filename = $_FILES['inputfile']['tmp_name'];
    $inname = str_replace('.zip', '.xml', $_FILES['inputfile']['name']);
    $outname = str_replace('.zip', '.html', $_FILES['inputfile']['name']);
    
    $error = '<pre>' . shell_exec("cd $dir; unzip $filename; xsltproc -o $outname v_images/einvoice_v21.xsl $inname");
    $result = @readfile($dir.'/'.$outname);
    $error .= shell_exec("rm -rf $dir; rm $filename");
    $error .= '</pre>';
    
    if ($result)
      die($result);
  }
}

?><!doctype html>  

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!-- encoding must be specified within the first 512 bytes www.whatwg.org/specs/web-apps/current-work/multipage/semantics.html#charset -->

  <!-- meta element for compatibility mode needs to be before all elements except title & meta msdn.microsoft.com/en-us/library/cc288325(VS.85).aspx --> 
  <!-- Chrome Frame is only invoked if meta element for compatibility mode is within the first 1K bytes code.google.com/p/chromium/issues/detail?id=23003 -->    


  <title>Генериране на оригинална фактура от Vivacom</title>
  <meta name="description" content="Генериране на оригинална фактура от Vivacom">
  <meta name="author" content="Geno Roupsky">

  <!--  Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="css/style.css?v=2">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

  <div id="container">
    <header> Header </header>
    <div id="main" role="main">
<?php 
  if ($error): 
    echo $error;
  else: 
?>
      <form method="post" enctype="multipart/form-data">
        <label for="inputfile">Архив, свален от сайта на Vivacom:</label>
        <input type="file" name="inputfile" id="inputfile" />
        <br/>
        <input type="submit" />
<?php endif; ?>
      </form>
    </div>
    <footer> Footer </footer>
  </div> <!--! end of #container -->


  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.4.4.js"%3E%3C/script%3E'))</script>
  
  
  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix('img, .png_bg'); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

  <!-- yui profiler and profileviewer - remove for production -->
  <script src="js/profiling/yahoo-profiling.min.js"></script>
  <script src="js/profiling/config.js"></script>
  <!-- end profiling code -->


  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
       change the UA-XXXXX-X to be your site's ID -->
  <script>
   var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>
  
</body>
</html>
