<?php       
/*********** /// Astald.COM /// ***********  
 * Özel Dosya Yükleme Servisi   
 * Osman YILMAZ
 * www.astald.com    
 * Copyright astald.com 
*******************************************/  
/* Ayar Dosyası */   
require_once "ayar.php";  

/* Güvenlik önlemi */  
define( "ASTALDDOSYASISTEM", true);  

/* Oturum kontrol */
if(empty($_SESSION["dbdosya_kullanici"]) or empty($_SESSION["dbdosya_parola"]) or empty($_SESSION["dbdosya_kullanici_id"]))
{
	session_destroy();
	header("location:giris.php");
}
else
{  

/* değişkenler */
$gitkullanici = $_SESSION["dbdosya_kullanici_id"];
$gitsayfa = @$astald->guvenlik($_GET["astald"]); 
$gitliste = @$astald->guvenlik($_GET["liste"]); 
 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Özel Dosya yükleme servisi">
    <meta name="author" content="astald.com">
    <link rel="shortcut icon" href="dist/img/favicon.png"/>
    <title>Dosya Yükleme - Osman YILMAZ</title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet"/> 
    <link href="dist/css/bootstrap.tema.css" rel="stylesheet"/> 
    <!-- Template -->
    <link href="dist/css/style.css" rel="stylesheet"/>
    <script src="dist/js/jquery.js"></script> 
    <script src="dist/js/jquery.form.min.js"></script>
    <script src="dist/js/dosya.js"></script>	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
</head>
<body>
<div class="container">
<!-- üst menü -->
<div class="navbar navbar-inverse" role="navigation">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="index.php">DOSYA YÜKLE</a> 
	</div>
	<div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav">
          <li <?php echo ($gitsayfa == '' or empty($gitsayfa)) ? 'class="active"' : ''; ?>><a href="index.php">Anasayfa</a></li>
          <li <?php echo ($gitsayfa == 'yukle') ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("yukle", site_url) ?>"><span class="glyphicon glyphicon-upload"></span> Dosya Yükle</a></li>
          <li <?php echo ($gitsayfa == 'dosyalar') ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("dosyalar", site_url) ?>"><span class="glyphicon glyphicon-import"></span> Yüklediğim Dosyalar</a></li>
		  <li class="dropdown <?php echo ($gitsayfa == 'klasor' or $gitsayfa == 'klasor.ekle' or $gitsayfa == 'klasor.duzelt' or $gitsayfa == 'klasor.sil') ? 'active' : ''; ?>">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="glyphicon glyphicon-folder-open"></span>&nbsp; Klasörler <b class="caret"></b></a>
			<ul class="dropdown-menu acilir-menu">
			  <li <?php echo ($gitsayfa == 'klasor') ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("klasor", site_url) ?>">Klasör Listesi</a></li>
			  <li <?php echo ($gitsayfa == 'klasor.ekle') ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("klasor.ekle", site_url) ?>">Yeni Klasör Ekle</a></li>  
			</ul>
		   </li>
	  </ul> 
	  <ul class="nav navbar-nav navbar-right">
          <li <?php echo ($gitsayfa == 'profil') ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("profil", site_url) ?>"><span class="glyphicon glyphicon-user"></span> Hesabım</a></li>
          <li><a href="<?php $astald->seo("cikis", site_url) ?>" onclick="return confirm('Sistemden çıkış yapmak üzeresiniz! ');"><span class="glyphicon glyphicon-log-out"></span> Çıkış Yap</a></li>
	  </ul>
	</div><!--/.nav-collapse -->
</div>
<!-- #üst menü -->
<?php   
/*
 * Site içerik
*/
Switch($gitsayfa)
{ 
/*  
 * Anasayfa
*/  
default: 

$_profil = $db->get_row("SELECT * FROM ".MX."_uyeler WHERE id='$gitkullanici' ");

?>
<!-- site -->
<div class="jumbotron">
	<h1>Hoşgeldin, <?php echo ucwords($_profil->ad_soyad); ?></h1>
	<p> Bulunduğun bilgisayardan dosya veya resim yükleyip başka bir adrese göndermen gerekiyorsa bu hizmetten rahatlıkla faydalanabilirsin. Hemen faydalanmaya başla...  </p>
	<p> <a class="btn btn-lg btn-primary" href="index.php?dodbod=yukle" role="button"><span class="glyphicon glyphicon-upload"></span> Dosya yüklemeye başla &raquo;</a></p>
</div>
<?php   
break;

/*
 * Dosya Yükle
*/
case "yukle":	
	include "yukle.php";
break;  


/*
 * Yüklediğim Dosyalar
 * dosya yükle, sil
*/

/*--  Dosyalar Listesi --*/
case "dosyalar":
	include "dosyalar.php";
break;

/*--  Dosya Düzelt --*/
case "dosya.duzelt":
	include "dosya.duzelt.php";
break;
/*--  Dosya Sil --*/
case "dosya.sil":
	include "dosya.sil.php";
break;

/*
 * Klasör 
 * liste, ekle, düzelt, sil
*/

/*--  Klasör Listesi --*/
case "klasor":
	include "klasor.php";
break;

/*--  Klasör Ekle --*/
case "klasor.ekle":
	include "klasor.ekle.php";
break;

/*--  Klasör Düzelt --*/
case "klasor.duzelt":
	include "klasor.duzelt.php";
break;

/*--  Klasör Sil --*/
case "klasor.sil":
	include "klasor.sil.php";
break; 

/*--  Profil --*/
case "profil":
	include "profil.php";
break; 
 
/*
 * Cikis
*/
case "cikis":  
  session_destroy();   
  header("location:giris.php");   
break;  

} 

?>

<!-- alt -->
<div class="row">
  <div class="col-md-12"> <hr />&copy; Copyright 2014 - Dosya Yükleme Servisi <span class="pull-right"><a href="http://www.astald.com">www.astald.com</a></span>	 </div>
</div>
<!-- #alt -->
</div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="dist/js/dodbod.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="dist/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="dist/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="dist/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="dist/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script> 
	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="dist/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="dist/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script> 
	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="dist/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
</body>
</html>
<?php  
} 
?>