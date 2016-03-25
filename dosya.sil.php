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
	$gitid = $astald->guvenlik($_GET["no"], "intval");
	$gitdosya = $astald->guvenlik($_GET["dosya"]);
	$_dosyalar = $db->get_row("SELECT * FROM ".MX."_dosyalar WHERE id='$gitid' ");
	if($_dosyalar or !empty($gitid))
	{  
		$silinecek_dosya = $_dosyalar->dosya_adi;
	}
	else
	{
		$silinecek_dosya = $gitdosya;
	}
?> 
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li> 
  <li><a href="<?php $astald->seo("dosyalar", site_url) ?>">Dosyalar</a></li>
  <li class="active">Klasör Silme</li>
</ul>
<!-- #site-harita -->  

<!-- yüklediðim dosyalar -->
<div class="panel panel-default">
	<div class="panel-heading">
		Klasör Silme
	</div> 
	<div class="panel-body"> 
		<?php       
		$_dosya_sil = @unlink("dosyalar/".$silinecek_dosya);
		if($_dosya_sil)
		{ 
			echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Dosya kaydı başarıyla silindi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("dosyalar", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
		}
		else
		{
			echo "<div class=\"alert alert-danger alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Dosya bulunamadıðından dolayı silme işlemi gerçekleştirilemedi, lütfen tekrar dene. </div>";	
		} 
			
		if($_dosyalar or !empty($gitid))
		{  
			$sil = $db->query("DELETE FROM ".MX."_dosyalar WHERE id='$_dosyalar->id'");
			if($sil)
			{ 
				echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Veritabanı kaydı başarıyla silindi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("dosyalar", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
				header("refresh: 4; url=".$astald->seo("dosyalar", site_url, "echo"));
			}
			else
			{
				echo "<div class=\"alert alert-danger alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı kayıt silme işlemi gerçekleştirilemedi, lütfen tekrar dene. </div>";	
			}  
		} 
		?> 
	</div>
</div>
<!-- #yüklediðim dosyalar -->
<?php } ?>