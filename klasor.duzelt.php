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
  <li class="active">Klasör Düzelt</li>
</ul>
<!-- #site-harita -->  

<!-- yüklediðim dosyalar -->
<div class="panel panel-default">
	<div class="panel-heading">
		Klasör Düzeltme
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
			else
			{
				$duzelt = $db->query("UPDATE ".MX."_klasor SET uye_id='$gitkullanici',klasor_adi='$klasor_adi',tarih='$tarih',saat='$saat' WHERE id='$klasor->id' ");
				if($duzelt)
				{ 
					echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Klasör bilgileri başarıyla düzeltildi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("klasor", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
					header("refresh: 2; url=".$astald->seo("klasor", site_url, "echo"));
				}
				else
				{
					echo "<div class=\"alert alert-error alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı bilgileri düzeltilemedi, lütfen tekrar dene. </div>";	
				}
			}
		}
		?>
		<form action="<?php $astald->seo("klasor.duzelt&id=$gitid", site_url) ?>" method="post"  role="form">
			<div class="form-group"> 
			<label  for="klasor_adi_id">Klasör Adı</label>
			<input type="text" class="form-control" name="klasor_adi" id="klasor_adi_id" value="<?php echo $klasor->klasor_adi ?>" />
			</div> 
			<button type="submit" class="btn btn-danger btn-sm">Klasör Düzelt</button>
		</form>	
	</div>
</div>
<!-- #yüklediðim dosyalar -->
<?php } } ?>