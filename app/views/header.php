<?php $uri = $_SERVER['REQUEST_URI']?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="<?=URL . 'public/assets/js/JQuery.js'?>"></script>
    <script src="<?=URL . 'public/assets/js/bootstrap.min.js'?>"></script>
    <link rel="stylesheet" href="<?=URL . 'public/assets/css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?=URL . 'public/assets/css/style.css'?>">
    <link rel="stylesheet" href="<?=URL . 'public/assets/css/preloader.css'?>">
    <script src="<?=URL . 'public/assets/js/preloader.js'?>"></script>
    <title><?=$data['title']?></title>
</head>
<body>
<div class="preloader-overlay"><div class="preloader"></div></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a href="<?=URL.'home'?>" class="nav-link <?=($uri == '/home' || $uri == '/')?'active':''?>">Home</a>
            </li>
            <li class="nav-item">
                <a href="<?=URL.'movie'?>" class="nav-link <?=($uri == '/movie')?'active':''?>">Movies</a>
            </li>
            <li class="nav-item">
                <a href="<?=URL.'user'?>" class="nav-link <?=($uri == '/user')?'active':''?>">Users</a>
            </li>
            <?php if (!\core\Session::checkUser()):?>
                <li class="nav-item">
                    <a href="<?=URL.'user/login'?>" class="nav-link <?=($uri == '/user/login')?'active':''?>">Sign in</a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL.'user/registration'?>" class="nav-link <?=($uri == '/user/registration')?'active':''?>">Sign up</a>
                </li>
            <?php else:?>
                <li class="nav-item">
                    <a href="<?=URL.'user/logout'?>" class="nav-link <?=($uri == '/user/logout')?'active':''?>">Log out</a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</nav>
<div class="content-container"> <!--content container begin-->
