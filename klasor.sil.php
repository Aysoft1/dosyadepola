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
	$gitid = $astald->guvenlik($_GET["id"], "intval");
	$klasor = $db->get_row("SELECT * FROM ".MX."_klasor WHERE id='$gitid' ");
	if(!$klasor OR empty($gitid))
	{
		header("location:index.php");
	}
	else
	{
?> 
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li> 
  <li><a href="<?php $astald->seo("klasor", site_url) ?>">Klasörler</a></li>
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
		$sil = $db->query("DELETE FROM ".MX."_klasor WHERE id='$klasor->id'");
		if($sil)
		{ 
			echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Klasör kaydı başarıyla silindi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("klasor", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
			header("refresh: 2; url=".$astald->seo("klasor", site_url, "echo"));
		}
		else
		{
			echo "<div class=\"alert alert-error alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı kayıt silme işlemi gerçekleştirilemedi, lütfen tekrar dene. </div>";	
		} 
		?> 
	</div>
</div>
<!-- #yüklediðim dosyalar -->
<?php } } ?>