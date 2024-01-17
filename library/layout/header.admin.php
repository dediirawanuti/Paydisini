<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $_CONFIG['description']; ?>">
        <meta name="author" content="VICRENA CODE">
        <meta name="keywords" content="<?= $_CONFIG['title']; ?>, Rumah Bisnis, Free Followers, SMM Cheap, Se7Code SMM, SMM Panel, SMM Murah, API Integration, Cheap SMM Panel, Admin panel instagram, admin panel twitter, autofollowers instagram, jasa tambah followers instagram murah, jasa tambah followers, Cara menambah followers instagram, Panel SMM, Track Your Activity, Instagram Followers, Free Followers, Free Retweets, Costumer Service, Free Subcribe, Free Views, Beli Followers Instagram, Beli Followers, Social Media, Reseller, Smm, Panel, SMM, Fans, Instagram, Facebook, Youtube, Cheap, Reseller, Panel, Top, 10, Social, Rankings, Working, Fast, Cheap, Free, Safe, Automatic, Instant, Not, Manual, perfect, followersindo, followers gratis, followers ig, followers boom, followers instagram terbanyak, followers instagram bot, followers tk, followers jackpot, instagram followers, followers for instagram, free instagram followers, buy instagram followers, how to get more followers on instagram, get followers on instagram, Mahirdepay, Hirpayzcode">
        <meta content="1 days" name="revisit-after"/>
        <meta content="id" name="language"/>
        <meta content="id" name="id.ID"/>
        <meta content="Indonesia" name="geo.placename"/>
        <meta content="all-language" http-equiv="Content-Language"/>
        <meta content="global" name="Distribution"/>
        <meta content="global" name="target"/>
        <meta content="Indonesia" name="geo.country"/>
        <meta content="all" name="robots"/>
        <meta content="all" name="googlebot"/>
        <meta content="all" name="msnbot"/>
        <meta content="all" name="Googlebot-Image"/>
        <meta content="all" name="Slurp"/>
        <meta content="all" name="ZyBorg"/>
        <meta content="all" name="Scooter"/>
        <meta content="ALL" name="spiders"/>
        <meta content="all" name="audience"/>

        <title><?= $_CONFIG['title']; ?></title>

        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <!-- App css -->
        <link href="<?= base_url(); ?>library/assets/css/bootstrap.min.css?time=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>library/assets/css/icons.css?time=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>library/assets/css/style.css?time=<?= time(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('libs/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= assets('libs/datatables/responsive.bootstrap4.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= assets('libs/datatables/buttons.bootstrap4.css') ?>" rel="stylesheet" type="text/css">
        <link href="<?= assets('libs/datatables/select.bootstrap4.css') ?>" rel="stylesheet" type="text/css">

        <script src="<?= base_url(); ?>library/assets/js/modernizr.min.js?time=<?= time(); ?>"></script>
        <script src="//cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>  

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62751496-1', 'auto');
  ga('send', 'pageview');

</script>
<script src='https://www.google.com/recaptcha/api.js'></script>


    </head>

    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">

                    <!-- Logo container-->
                <div class="logo">
                <a href="<?= base_url(); ?>" class="logo">
                <span class="logo-small"><i class="mdi mdi-cart"></i></span>
                <span class="logo-large"><i class="mdi mdi-cart"></i><?= $_CONFIG['title']; ?></span>
                </a>
                    </div>
                    <!-- End Logo container-->
                      <div class="menu-extras topbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">
            
                            <li class="menu-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
                    <li class="menu-item">
                        <a href="<?= base_url(); ?>deposit/new" class="nav-link nav-user text-uppercase text-white">Saldo: Rp <?= currency($data_user['balance']) ?></a>
                    </li>
                    <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="<?= $avatar ?>" alt="user" class="rounded-circle"> <span class="ml-1 pro-user-name"><?php echo $sess_username; ?> <i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="<?= base_url(); ?>account/profile" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i> <span>Edit Profile</span>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= base_url(); ?>auth/logout" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- / brand -->
            
  <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <?php require 'sidebar.admin.php'; ?>
                        </ul>
        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
        <div class="wrapper">
            <div class="container-fluid">
                
            <br><br><br>
            <? require _DIR_('library/session/result'); ?>