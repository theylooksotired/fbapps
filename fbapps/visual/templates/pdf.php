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

    <?php echo $header;?>
    
</head>
<body tabindex="1" class="loadingInProgress">
    <?php echo $content;?>
</body>
</html>