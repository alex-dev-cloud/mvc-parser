<?php $uri = $_SERVER['REQUEST_URI']?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
            <?php if (!isset($_SESSION['user'])):?>
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
