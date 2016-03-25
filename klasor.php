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
  <li class="active">Klasörler</li>
</ul>
<!-- #site-harita --> 


<!-- yüklediðim dosyalar -->
<div class="panel panel-default">
	<div class="panel-heading">
		Klasör Listesi
	</div>
	<?php
	/*
	 *  Dosya listesi
	 * veritabanından kullanıcıya ait dosyaları çekiyoruz
	*/ 
	$klasorler = $db->get_results("SELECT * FROM ".MX."_klasor ORDER BY klasor_adi ASC");
	if($klasorler)
	{
	?>
	<table class="table table-hover table-bordered table-striped">
	<thead>
		<tr> 
			<th>#</th>
			<th>Dosya Adı</th> 
			<th>Kayıt Tarihi</th>
			<th>Kayıt Saati</th>
			<th colspan="2">#</th>
		</tr>
	</thead>
	<tbody>
		<?php  
		foreach($klasorler AS $klasor)
		{
		?>
		<tr> 
			<td width="5%"><?php echo $klasor->id ?></td> 
			<td><?php echo $klasor->klasor_adi ?></td>  
			<td width="10%"><?php echo $klasor->tarih ?></td> 
			<td width="10%"><?php echo $klasor->saat ?></td> 
			<td width="5%"><a href="<?php $astald->seo("klasor.duzelt&id=".$klasor->id, site_url); ?>" class="btn btn-primary btn-xs">Düzelt</a></td>
			<td width="5%"><a href="<?php $astald->seo("klasor.sil&id=".$klasor->id, site_url); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Dosyayı Silmek istediðinizden eminmisiniz?');">Sil</a></td>
		</tr>
		<?php } ?>
	</tbody> 
	</table> 
	<?php 
	}
	else
	{
		echo " <div class=\"panel-body\"> <div class=\"alert alert-info sayfalama\"> <strong>Bilgilendirme</strong> <p>Sisteme kayıtlı dosyanız yok, dosya yükledikten sonra dosyalarınız listelenecektir.</p> </div> </div>";
	}
	?> 
</div>
<!-- #yüklediðim dosyalar -->
<?php } 