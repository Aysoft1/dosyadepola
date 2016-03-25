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
  <li class="active">Dosya Yükleme</li>
</ul>
<!-- #site-harita --> 
<!-- dosya yükle -->
<div class="panel panel-default">
	<!-- baslik -->
	<div class="panel-heading panel-baslik">
		<a href="<?php $astald->seo("dosyalar", site_url) ?>" class="btn btn-primary btn-sm pull-right "> <span class="glyphicon glyphicon-list"></span> Dosyalar</a>
		<h2 class="panel-baslik">Dosya Yükleme</h2>
	</div>
	<!-- #baslik -->
	<div class="panel-body"> 
	<div class="row">
	<div class="col-md-4">
	<!-- dosya yükle -->
	<form action="dosya.yukle.php" method="post" id="form" enctype="multipart/form-data" role="form">
	  <input type="hidden" name="git" value="<?php echo $gitkullanici ?>" />
	  <div class="form-group">
		<label for="dosya_sec">Dosya SEÇ</label>
		<input type="file" name="files[]" min="1" max="25" multiple id="dosya_sec">
		<p class="help-block">Yüklenmesini istediğiniz dosyayı seçiniz</p>
	  </div>
	  <div class="form-group">
		<label for="dosya_not_id">Eklemek istediğin bir şeyler varsa</label>
		<input type="text" name="dosya_not" class="form-control" id="dosya_not_id" placeholder="Eklemek istediğiniz bir şeyler varsa" />
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
				echo "<option value=\"{$klasor->id}\">{$klasor->klasor_adi}</option>";
			 }
			   
			 }
			?>
		</select> 
		
	    </div>
	  <button type="submit" class="btn btn-danger btn-sm"> <span class="glyphicon glyphicon-cloud-upload"></span> Dosyayı Yükle</button>
	</form>
	<div class="clearfix"></div>
	<div id="progressbar1" class="progress progress-striped active">
		<div class="progress-bar percent_1" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
	</div>
	</div> 
	<!-- dosya yükle --> 
	<div class="col-md-8">
		<div id="dosya_sonuc"></div>
	</div>
	</div>
	<div class="clearfix"></div>
	</div>
</div>
<!-- #dosya yükle -->
<?php } ?>