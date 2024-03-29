	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/x-icon" href="<?= admin() ?>/favicon.ico">
	<meta name="color-scheme" content="light dark">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

	<meta name="color-scheme" content="light dark">

	<!--START SEO-->
	<?= $seo; ?>
	<!--END SEO-->
	<!--START GTMHEAD-->
	<?= $gtmHead; ?>
	<!--END GTMHEAD-->

	<link rel="stylesheet" href="<?= asset("common", "css/common.min.css"); ?>" />
	<link rel="stylesheet" href="<?= asset($theme, "css/{$theme}.min.css"); ?>" />