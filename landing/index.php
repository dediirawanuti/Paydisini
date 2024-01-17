<?php
require("../connect.php");

	$check_order = mysqli_query($call, "SELECT SUM(price) AS total FROM trx_socmed WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);
	$check_depo = mysqli_query($call, "SELECT SUM(amount) AS total FROM deposit WHERE user = '$sess_username'");
	$data_depo = mysqli_fetch_assoc($check_depo);
	$total_deposit = $data_depo;
	$count_users = mysqli_num_rows(mysqli_query($call, "SELECT * FROM users"));
	$count_sosmed = mysqli_num_rows(mysqli_query($call, "SELECT * FROM trx_socmed WHERE user = '$sess_username'"));


    // widget
	$check_worder = mysqli_query($call, "SELECT SUM(price) AS total FROM trx_socmed"); //total pesanan
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($call, "SELECT * FROM trx_socmed");
	$count_worder = mysqli_num_rows($check_worder);
	
	$check_wuser = mysqli_query($call, "SELECT SUM(balance) AS total FROM users");// total user
	$data_wuser = mysqli_fetch_assoc($check_wuser);
	$check_wuser = mysqli_query($call, "SELECT * FROM users");
	$count_wuser = mysqli_num_rows($check_wuser);
	
	$check_wser = mysqli_query($call, "SELECT * FROM srv_socmed");
	$count_wser = mysqli_num_rows($check_wser);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= $_CONFIG['title']; ?> adalah sebuah platform bisnis yang menyediakan berbagai bisnis serta layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat belajar berbisnis serta menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll. Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.">
<meta name="author" content="<?= $_CONFIG['title']; ?> Team">
<meta name="keywords" content="bisnis, bisnis pelajar, irv, irvan kede, panel, smm, auto followers, selebgram, smm panel reseller, smm panel indonesia, panel all sosmed, daftar panel all sosmed, smm reseller, smm reseller panel, smm panel">
<link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">
<title><?= $_CONFIG['title']; ?></title>
<link href="<?= base_url(); ?>landing/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url(); ?>landing/assets/css/style.css?time=<?= time(); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url(); ?>landing/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
<link rel="stylesheet" href="<?= base_url(); ?>landing/assets/fonts/pe-icon-7-stroke/css/helper.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.8/typed.min.js"></script>

</head>
<body style="padding-top: 80px;">
<nav class="navbar navbar-default navbar-custom navbar-fixed-top sticky">
<div class="container">

<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="<?= base_url(); ?>"><?= $_CONFIG['title']; ?></a>
</div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">
<li><a href="<?= base_url(); ?>">Halaman Utama</a></li>
<li><a href="<?= base_url(); ?>contact">Kontak</a></li>
<li><a href="<?= base_url(); ?>terms">Ketentuan Layanan</a></li>
<li><a href="<?= base_url(); ?>faq">Pertanyaan Umum</a></li>
</ul>
</div>

</div>

</nav>
<div class="clearfix"></div>
<section class="section-lg home-alt bg-solid" id="home">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="home-wrapper text-center">
<p style="font-size: 25px; font-weight: normal;" class="text-muted"><?= $_CONFIG['title']; ?>  Official Website</p>
<h1><span id="typed"></span></h1>
<a href="<?= base_url(); ?>auth/login" class="btn btn-dark">Masuk</a>
<a href="<?= base_url(); ?>auth/register" class="btn btn-white">Daftar</a>
</div>
</div>
</div>
</div>
</section>
<div class="clearfix"></div>
<section>
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="facts-box text-center">
<div class="row">
<div class="col-md-4">
<h2><?php echo number_format($count_wuser,0,',','.'); ?></h2>
<p class="text-muted">Total Member Bergabung</p>
</div>
<div class="col-md-4">
<h2><?php echo number_format($count_worder,0,',','.'); ?></h2>
<p class="text-muted">Total Transaksi</p>
</div>
<div class="col-md-4">
<h2><?php echo number_format($count_wser,0,',','.'); ?></h2>
<p class="text-muted">Total Layanan</p>
</div>
 </div>
</div>
</div>
</div>
</div>
</section>
<div class="clearfix"></div>
<section class="section" id="features">
<div class="container">
<div class="row">
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="pe-7s-science" style=""></span>
</div>
<h3>Bisnis Berkualitas</h3>
<p class="text-muted">Kami selalu mengutamakan kualitas terbaik untuk bisnis dan layanan yang kami sediakan demi kepercayaan client.</p>
</div>
</div>
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="pe-7s-light" style=""></span>
</div>
<h3>Proses Mudah</h3>
<p class="text-muted">Dengan <?= $_CONFIG['title']; ?>  anda bisa menghasilkan banyak uang, serta anda dapat mengakses panel server selebgram kami, dari followers,like,views dan lain lainnya hanya dalam waktu 1x24Jam.</p>
</div>
</div>
<div class="col-sm-4">
<div class="features-box text-center">
<div class="feature-icon">
<span class="pe-7s-display1" style=""></span>
</div>
<h3>Terpercaya</h3>
<p class="text-muted">Sudah banyak Pemuda serta Remaja yang telah bergabung bersama kami, jadi kami sangat bisa Dipercaya, Karena Hanya Mengajak orang bergabung , kalian dapat menghasilkan keuntungan.</p>
</div>
</div>
</div>
</div>
</section>
<section class="section bg-white" id="about">
<div class="container">
<div class="row text-center">
<div class="col-sm-12">
<h2 class="title">Tentang Kami</h2>
<p class="title-alt"><?= $_CONFIG['title']; ?>  adalah sebuah platform bisnis yang menyediakan bisnis untuk pemuda pemudi calon penerus bangsa, serta berbagai layanan social media marketing yang bergerak terutama di Indonesia.<br />Dengan bergabung bersama kami, Anda dapat berbisnis dan menghasilkan uang hanya dengan mengajak teman anda. Serta menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.<br>Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.</p>
</div>
</div>
</div>
</section>
<section class="section" id="faqs">
<div class="container">
<div class="row text-center">
<div class="col-sm-12">
<h2 class="title">Pertanyaan Umum</h2>
<p class="title-alt">Berikut telah kami rangkum beberapa pertanyaan yang sering ditanyakan client terkait layanan kami.</p>
<div class="row text-left">
<div class="col-sm-6">
<div class="question-box">
<h4><span class="text-colored">Q.</span> Apa itu <?= $_CONFIG['title']; ?> ?</h4>
<p><span><b>A.</b></span> <?= $_CONFIG['title']; ?>  adalah sebuah platform bisnis berbasis website / online yang menyediakan bisnis untuk pemuda , serta berbagai layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.</p>
</div>
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara mendaftar di <?= $_CONFIG['title']; ?> ?</h4>
<p><span><b>A.</b></span> Silahkan menghubungi Admin untuk mendapatkan kode undangan, silahkan menuju halaman CONTACT untuk melihat kontak Admin. Atau Silahkan Ke menu Daftar member untuk meng Contact Salah Satu member / reseller kami untuk bergabung.</p>
</div>
<div class="question-box">
<h4><span class="text-colored">Q.</span> Apa Keuntungan Bergabung di <?= $_CONFIG['title']; ?> ?</h4>
<p><span><b>A.</b></span> Keuntungannya adalah kalian dapat Menghasilkan Income / uang serta pulsa. Hanya dengan Mengajak teman kalian , apabila ingin income lebih besar. Saldo bisa di convert menjadi Saldo di Panel SelebGram.</p>
</div>
</div>
<div class="col-sm-6">
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara kerjanya ?</h4>
<p><span><b>A.</b></span> Untuk menghasilkan uang / pulsa , kalian hanya perlu mengajak teman kalian untuk bergabung. Setelah ia Bergabung, kalian akan mendapatkan keuntungan yang besar bahkan lebih dari 50% dari harga kalian bergabung di Rumah Bisnis. </p>
</div>
<div class="question-box">
<h4><span class="text-colored">Q.</span> Bagaimana cara melakukan deposit/isi saldo?</h4>
<p><span><b>A.</b></span> Untuk melakukan deposit/isi saldo, Anda hanya perlu masuk terlebih dahulu ke akun Anda dan menuju halaman deposit dengan mengklik menu yang sudah tersedia. Kami menyediakan deposit melalui bank , ovo, dan pulsa.</p>
</div>
</div>
</div>
</div>

</div>
</div>
</section>
<footer class="bg-dark footer-one" style="padding-top: 0;">
<div class="footer-one-alt" style="margin-top: 0;">
<div class="container">
<div class="row">
<div class="col-lg-8">
<p class="m-b-0 font-13 copyright">2019 &copy; <?= $_CONFIG['title']; ?> - With BY <a href="https://www.instagram.com/aikosans" target="_blank"><?= $_CONFIG['title']; ?></a></p>
</div> 

</div>
</div>
</div>
</footer>

<script src="<?= base_url(); ?>landing/assets/js/3.js"></script>
<script src="<?= base_url(); ?>landing/assets/js/4.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>landing/assets/js/5.js"></script>

<script src="<?= base_url(); ?>landing/assets/js/2.js" type="text/javascript"></script>

<script src="<?= base_url(); ?>landing/assets/js/1.js"></script>
<script type="text/javascript">
var typed = new Typed('#typed',{
  strings : ['Recommended Bagi Khalangan Remaja','Mudah Diakses Serta Digunakan dan Dikembangkan','Pelayanan terbaik ',' Amanah & Terpercaya ',' Menguntungkan '],
  typeSpeed : 90,
  delaySpeed : 310,
  loop : true
});
		</script>
</body>
</html>