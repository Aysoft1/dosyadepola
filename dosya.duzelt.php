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
	$dosyalar = $db->get_row("SELECT * FROM ".MX."_dosyalar WHERE id='$gitid' ");
	if(!$dosyalar OR empty($gitid))
	{
		header("location:index.php");
	}
	else
	{
?> 
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li> 
  <li><a href="<?php $astald->seo("dosyalar", site_url) ?>">Dosyalar</a></li>
  <li class="active">Dosya Düzelt</li>
</ul>
<!-- #site-harita -->  

<!-- yüklediðim dosyalar -->
<div class="panel panel-default">
	<div class="panel-heading">
		Dosya Düzeltme
	</div> 
	<div class="panel-body"> 
		<?php   
		if($_POST)
		{
			$dosya_adi = $astald->guvenlik($_POST["dosya_adi"]);
			$dosya_not = $astald->guvenlik($_POST["dosya_not"]);
			$klasor_id = $astald->guvenlik($_POST["dosya_klasor"]);
			$tarih = date("d.m.Y");
			$saat = date("H:i:s");
			if(empty($dosya_adi))
			{
				echo "<div class=\"alert alert-warning alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Uyarı!</strong> Dosya adı girmediniz, lütfen dosya adı gir. </div>";
			}  
			else
			{  
				$duzelt = $db->query("UPDATE ".MX."_dosyalar SET dosya_adi='$dosya_adi',dosya_not='$dosya_not',klasor_id='$klasor_id' WHERE id='$dosyalar->id' ");
				if($duzelt)
				{ 
					echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> Dosya bilgileri başarıyla düzeltildi, lütfen bekle yönlendiriliyorsun. <a href=\"{$astald->seo("klasor", site_url, "echo")}\">Yönlendirme başlamadıysa tıkla.</a> </div>";
					header("refresh: 2; url=".$astald->seo("dosyalar", site_url, "echo"));
				}
				else
				{
					echo "<div class=\"alert alert-error alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> Veritabanı bilgileri düzeltilemedi, lütfen tekrar dene. </div>";	
				}
			}
		}
		?>
		<form action="<?php $astald->seo("dosya.duzelt&no=$gitid", site_url) ?>" method="post"  role="form">
			<div class="form-group"> 
			<label  for="dosya_adi_id">Dosya Adı</label>
			<input type="text" class="form-control" name="dosya_adi" id="dosya_adi_id" value="<?php echo $dosyalar->dosya_adi ?>" />
			</div> 		
			<div class="form-group"> 
			<label  for="dosya_not_id">Dosya Not</label>
			<input type="text" class="form-control" name="dosya_not" id="dosya_not_id" value="<?php echo $dosyalar->dosya_not ?>" />
			</div> 

			<div class="form-group">
				<label for="dosya_klasor_id">Klasör Seçiniz</label>
				<select name="dosya_klasor" class="form-control" id="dosya_klasor_id">
					<option value="0">Klasör Olmasın</option>
					<?php
					$_klasor = $db->get_results("SELECT * FROM ".MX."_klasor ORDER BY klasor_adi DESC");
					 if($_klasor)
					 {
					 foreach($_klasor as $klasor)
					 { 
						echo '<option value="'.$klasor->id.'" '.($dosyalar->klasor_id == $klasor->id ? "selected" : "").'>'.$klasor->klasor_adi.'</option>';
					 }}
					?>
				</select> 
				
			</div>
			<button type="submit" class="btn btn-danger btn-sm">Dosyayı Düzelt</button>
		</form>	
	</div>
</div>
<!-- #yüklediðim dosyalar -->
<?php } } ?>