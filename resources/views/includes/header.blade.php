<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="<?= CURRENT_LOCALE_DIRECTION ?>">
	<head>
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>@yield('head-title') : <?= getStoreSettings('name') ?></title>
		<!-- Custom fonts for this template-->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link rel="shortcut icon" href="public/<?= getStoreSettings('favicon_image_url') ?>" type="image/x-icon">
        <link rel="icon" href="public/<?= getStoreSettings('favicon_image_url') ?>" type="image/x-icon">

		<!-- Primary Meta Tags -->
		<meta name="title" content="@yield('page-title')">
		<meta name="description" content="@yield('description')">
		<meta name="keywordDescription" property="og:keywordDescription" content="@yield('keywordDescription')">
		<meta name="keywordName" property="og:keywordName" content="@yield('keywordName')">
		<meta name="keyword" content="@yield('keyword')">
		<!-- Google Meta -->
		<meta itemprop="name" content="@yield('page-title')">
		<meta itemprop="description" content="@yield('description')">
		<meta itemprop="image" content="@yield('page-image')">
		<!-- Open Graph / Facebook -->
		<meta property="og:type" content="website">
		<meta property="og:url" content="@yield('page-url')">
		<meta property="og:title" content="@yield('page-title')">
		<meta property="og:description" content="@yield('description')">
		<meta property="og:image" content="@yield('page-image')">
		<!-- Twitter -->
		<meta property="twitter:card" content="@yield('twitter-card-image')">
		<meta property="twitter:url" content="@yield('page-url')">
		<meta property="twitter:title" content="@yield('page-title')">
		<meta property="twitter:description" content="@yield('description')">
		<meta property="twitter:image" content="@yield('page-image')">

		<!-- Custom styles for this template-->
		<?= __yesset([
            'public/dist/css/public-assets-app*.css',
            'public/dist/fa/css/all.min.css',
            "public/dist/css/vendorlibs-datatable.css",
            "public/dist/css/vendorlibs-photoswipe.css",
            "public/dist/css/vendorlibs-smartwizard.css",
			'public/dist/css/custom*.css',
			'public/dist/css/messenger*.css',
			'public/dist/css/login-register*.css',
			'public/frontend/css/ppm-custom.css'       
		], true) ?>
        @stack('header')
              <link href="{{ asset('public/dist/css/style.css') }}" rel="stylesheet" type="text/css">
              <?= __yesset([
    'public/backend/style.css'    
], true) ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	</head>