<?php   
/****************** /// ASTALD.COM /// ******************
 * Sistem Yetkili Giriş
 * Özel Dosya Yükleme Servisi
 * www.ASTALD.com
 * Copyright ASTALD.com
***************************************/
require "ayar.php";
if(empty($_SESSION["dbdosya_kullanici"]) or empty($_SESSION["dbdosya_parola"]))
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="iso-8859-9">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="dosya yükleme">
    <meta name="author" content="Astald.com"> 
    <title>Özel Dosya Yükleme Servisi</title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet"> 
    <link href="dist/css/bootstrap.tema.css" rel="stylesheet"> 
    <!-- Custom styles for this template -->
    <link href="dist/css/giris.css" rel="stylesheet"> 
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
	
	<div class="row">
	<div class="col-xs-4"></div>
	<div class="col-xs-4">
	  <h1 class="text-center">Astald.com</h1>
	<div class="panel panel-default giris-golge">
	  <div class="panel-heading">
		<h3 class="panel-title">Kullanıcı Giriş Paneli</h3>
	  </div>
	  <div class="panel-body">
	   <?php     
	    if($_POST)
	    { 
			$kullanici = $astald->security($_POST["kullanici"]);
			$parola = $astald->security($_POST["parola"]); 
			if(empty($kullanici) or empty($parola))
			{
				echo ' <div class="alert alert-info"><strong>Uyarý!</strong> Kullanıcı adı veya şifre boş</div>'; 
			}
			else
			{
				$uyegiris = $db->get_row("SELECT * FROM ".MX."_uyeler WHERE kullanici='$kullanici' AND parola='$parola'");
				if(!$uyegiris)
				{
					echo '<div class="alert alert-danger"><strong>Hata!</strong> Yanlış Kullanıcı adı veya şifre adı</div>';	
				}
				else
				{
					@session_start(); 
					$_SESSION["dbdosya_kullanici_id"] = $uyegiris->id; 
					$_SESSION["dbdosya_kullanici"] = $uyegiris->kullanici."_".rand(1,98789789949);
					$_SESSION["dbdosya_parola"] = $uyegiris->parola."_".rand(1,99568598678); 
					echo header("location:".site_url); 
					$db->query("UPDATE ".MX."_uyeler SET giris_tarih='$tarih' WHERE kullanici='$uyegiris->kullanici'");
				} 
			}
	    }
	   
	   ?>
	   <form action="giris.php" method="post" class="form-giris">
		<fieldset> 
			<input type="text" name="kullanici" class="form-control col-xs-12" id="inputEmail" placeholder="Kullanıcı adı">
			<input type="password" name="parola" class="form-control col-xs-12" id="inputPassword" placeholder="şifre">
			<div class="clearfix"></div> <br />
			<button type="submit" name="submit" class="btn btn-primary col-xs-12">GİRİŞ YAP</button> 
		</fieldset>
	   </form>	 
	  </div>
	  <div class="panel-footer">
		www.astald.com
	  </div>
	</div>
	</div> 
	<div class="col-xs-4"></div>
    </div> 
 

    </div> <!-- /container --> 
</body>
</html>
<?php  
}
else 
{ 
	header("location:index.php"); 
}