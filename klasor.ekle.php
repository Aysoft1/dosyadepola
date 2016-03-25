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
?> 
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li> 
  <li><a href="<?php $astald->seo("klasor", site_url) ?>">Klasörler</a></li>
  <li class="active">Klasör Ekle</li>
</ul>
<!-- #site-harita -->  

<!-- yüklediğim dosyalar -->
<div class="panel panel-default">
	<div class="panel-heading">
		Yeni Klasör Ekle
	</div> 
	<div class="panel-body"> 
		<?php   
		if($_POST)
		{
			$klasor_adi = $astald->guvenlik($_POST["klasor_adi"]);
			$tarih = date("d.m.Y");
			$saat = date("H:i:s");
			if(empty($klasor_adi))
			{
				echo "<div class=\"alert alert-warning alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Uyarı!</strong> Klasör adı girmediniz, lütfen klasör adı gir. </div>";
			} 
			else if($db->get_var("SELECT COUNT(klasor_adi) FROM ".MX."_klasor WHERE klasor_adi='$klasor_adi'") >= 1)
			{
				echo "<div class=\"alert alert-info alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Üzgünüm!</strong> Klasör adı sistemde kayıtlı klasörün adını değiştirsen iyi olur, lütfen farkı klasör adı gir. </div>";
			}
			else
			{
				$ekle = $db->query("INSERT INTO ".MX."_klasor (uye_id,klasor_adi,tarih,saat) VALUE ('$gitkullanici','$klasor_adi','$tarih','$saat') ");
				if($ekle)
				{ 
					echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Klasör başarıyla eklendi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("klasor", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
					header("refresh: 2; url=".$astald->seo("klasor", site_url, "echo"));
				}
				else
				{
					echo "<div class=\"alert alert-danger alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı kayıt işlemini gerçekleştirilemedim, lütfen tekrar dene. </div>";	
				}
			}
		}
		?>
		<form action="<?php $astald->seo("klasor.ekle", site_url) ?>" method="post"  role="form">
			<div class="form-group"> 
			<label  for="klasor_adi_id">Klasör Adı</label>
			<input type="text" class="form-control" name="klasor_adi" id="klasor_adi_id" placeholder="Klasör Adı" />
			</div> 
			<button type="submit" class="btn btn-danger btn-sm">Klasör Ekle</button>
		</form>	
	</div>
</div>
<!-- #yüklediğim dosyalar -->
<?php } ?>