<!DOCTYPE html>
<html lang="<?php echo Lang::active();?>">
<head>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo $metaDescription;?>"/>
    <meta name="keywords" content="<?php echo $metaKeywords;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php echo Params::param('metainfo-google-webmasters');?>

    <meta property="og:title" content="<?php echo $title;?>" /> 
    <meta property="og:description" content="<?php echo $metaDescription;?>" />    
    <?php echo $metaImage;?>

    <link rel="shortcut icon" href="<?php echo BASE_URL;?>visual/img/favicon.ico"/>
    <link rel="canonical" href="<?php echo $metaUrl;?>" />

    <title><?php echo $title;?></title>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />

    <link href="<?php echo BASE_URL;?>visual/css/stylesheets/public.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?php echo BASE_URL; ?>libjs/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>libjs/public.js"></script>

    <?php echo $header;?>
    
</head>
<body>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.8&appId=182759458876787";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div id="bodyFrame">
        <?php echo $content;?>
    </div>
</body>
</html>