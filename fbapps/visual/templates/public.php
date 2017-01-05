<!DOCTYPE html>
<html lang="<?php echo Lang::active();?>">
<head>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo $metaDescription;?>"/>
    <meta name="keywords" content="<?php echo $metaKeywords;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php Params::param('metainfo-google-webmasters');?>

    <meta property="og:title" content="<?php echo $title;?>" /> 
    <meta property="og:description" content="<?php echo $metaDescription;?>" />    
    <meta property="og:image" content="<?php echo $metaImage;?>" /> 

    <link rel="shortcut icon" href="<?php echo BASE_URL;?>visual/img/favicon.ico"/>
    <link rel="canonical" href="<?php echo $metaUrl;?>" />

    <title><?php echo $title;?></title>

    <link href="<?php echo BASE_URL;?>visual/css/stylesheets/public.css" rel="stylesheet" type="text/css" />

    <?php echo $header;?>
</head>
<body>
    <div id="bodyFrame">
        <?php echo $content;?>
    </div>
</body>
</html>