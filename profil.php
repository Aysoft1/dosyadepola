<?php       
/*********** /// Astald.COM /// ***********  
 * Özel Dosya Yükleme Servisi   
 * Osman YILMAZ
 * www.astald.com    
 * Copyright astald.com 
*******************************************/  
if(!defined("ASTALDDOSYASISTEM"))
{ 
	ob_start();
	session_start();
	session_destroy(); 
	header("location:/"); 
}
else
{    
	$profil = $db->get_row("SELECT * FROM ".MX."_uyeler WHERE id='$gitkullanici' ");
?> 
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li>  
  <li class="active">Hesabım</li>
</ul>
<!-- #site-harita -->  

<!-- profil -->
<div class="panel panel-default">
	<div class="panel-heading">
		Hesabım
	</div> 
	<div class="panel-body"> 
		<?php   
		if($_POST)
		{
			$kullanici_adi = $astald->guvenlik($_POST["kullanici_adi"]); 
			$kullanici_parola = $astald->guvenlik($_POST["parola"]); 
			$e_posta = $astald->guvenlik($_POST["e_posta"]); 
			$ad_soyad = $astald->guvenlik($_POST["ad_soyad"]); 
			if(empty($kullanici_adi) or empty($kullanici_parola))
			{
				echo "<div class=\"alert alert-warning alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Uyarı!</strong> Kullanıcı adı veya kullanıcı parola alanı boş, lütfen alan(ları) doldurunuz. </div>";
			}  
			else if(empty($e_posta) or empty($ad_soyad))
			{
				echo "<div class=\"alert alert-warning alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Uyarı!</strong> E-posta adresinizi veya ad soyad alanını boş bıraktınız. lütfen alan(ları) doldurunuz. </div>";
			}
			else
			{
				$duzelt = $db->query("UPDATE ".MX."_uyeler SET kullanici='$kullanici_adi',parola='$kullanici_parola',e_posta='$e_posta',ad_soyad='$ad_soyad'  WHERE id='$profil->id' ");
				if($duzelt)
				{ 
					echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Kullanıcı bilgileriniz başarıyla düzeltildi, lütfen bekle yönlendiriliyorsun. <a href=\"".site_url."\">Yönlendirme başlamadıysa tıkla.</a> </div>";
					header("refresh: 2; url=".site_url);
				}
				else
				{
					echo "<div class=\"alert alert-error alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı bilgileri düzeltilemedi, lütfen tekrar dene. </div>";	
				}
			}
		}
		?>
		<form action="<?php $astald->seo("profil", site_url) ?>" method="post"  role="form">
			<div class="form-group"> 
			  <label  for="kullanici_adi_id">Kullanıcı Adı</label>
			  <input type="text" class="form-control" name="kullanici_adi" id="kullanici_adi_id" value="<?php echo $profil->kullanici ?>" />
			</div> 
			<div class="form-group"> 
			  <label  for="kullanici_parola_id">Kullanıcı Parola</label>
			  <input type="password" class="form-control" name="parola" id="kullanici_parola_id" value="<?php echo $profil->parola ?>" />
			</div> 
			<div class="form-group"> 
			  <label  for="ad_soyad_id">Adınız Soyadınız</label>
			  <input type="text" class="form-control" name="ad_soyad" id="ad_soyad_id" value="<?php echo $profil->ad_soyad ?>" />
			</div> 
			<div class="form-group"> 
			  <label  for="e_posta_id">E-Posta Adresi</label>
			  <input type="text" class="form-control" name="e_posta" id="e_posta_id" value="<?php echo $profil->e_posta ?>" />
			</div> 
			<button type="submit" class="btn btn-danger btn-sm">Hesabı Düzelt</button>
		</form>	
	</div>
</div>
<!-- #profil -->
<?php } ?>