	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/x-icon" href="<?=admin()?>/favicon.ico">
	<meta name="color-scheme" content="light dark">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>

    <meta name="color-scheme" content="light dark">

    <!--START SEO-->
        <?=$seo;?>
    <!--END SEO-->
    <!--START GTMHEAD-->
        <?=$gtmHead;?>
    <!--END GTMHEAD-->

    <!--THEME-->
    <link rel="stylesheet" href="<?= asset("common", "css/plugins.bundle.css"); ?>" />
    <link rel="stylesheet" href="<?= asset("common", "css/style.bundle.css"); ?>" />

    <link rel="stylesheet" href="<?= asset("common", "css/common.min.css"); ?>" />
	<link rel="stylesheet" href="<?= asset($theme, "css/{$theme}.min.css"); ?>" />

    <!--PAGE STYLE-->
    <?= (!empty($cssFile)) ? '<link rel="stylesheet" href="' . asset($theme, "css/pages/$cssFile") . '"/>' : ""; ?>
