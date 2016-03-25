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
	$klasor_liste = $astald->guvenlik($_GET["klasor"], "intval");
	$_liste_tip = $astald->guvenlik($_GET["liste"]);
	$liste_tip = (($_liste_tip == '') or empty($_liste_tip) or ($_liste_tip == 'listele')) ? 'listele' : 'galeri';
	$limit = 10;
	$_gitsayfa = $astald->guvenlik($_GET["sayfa"], "intval");
	$getirsayfa = (($_gitsayfa == '') or empty($_gitsayfa) or ($_gitsayfa <= 0) or !is_numeric($_gitsayfa)) ? $getirsayfa = 1 : $getirsayfa = $_gitsayfa;
	if(($klasor_liste == '') or ($klasor_liste <= 0) or empty($klasor_liste) or !is_numeric($klasor_liste))
	{
		$_klasor_listele = "";
		$_klasor_sayfa_liste = "";
	}
	else
	{
		$_klasor_listele = "WHERE klasor_id='$klasor_liste'";
		$_klasor_sayfa_liste = "&amp;klasor=".$klasor_liste;
	}
?>
<!-- site-harita -->
<ul class="breadcrumb">
  <li><a href="<?php echo site_url ?>">Anasayfa</a></li> 
  <li class="active">Dosyalarım</li>
</ul>
<!-- #site-harita --> 

<!-- yüklediğim dosyalar -->
<div class="panel panel-default"> 
	
	<div class="panel-heading">
		<span class="glyphicon glyphicon-download"></span>
		Yüklediğiniz Dosyalar 
		<!-- listele -->
		<div class="btn-group pull-right liste-tur">
		  <a href="<?php $astald->seo("dosyalar&amp;sayfa={$getirsayfa}&amp;klasor={$klasor_liste}&liste=listele", site_url) ?>" class="<?php echo (($_liste_tip == '') or ($_liste_tip == 'listele')) ? 'active' : '' ?> btn btn-primary btn-xs" title="Dosyaları Tablo olarak Listele"><span class="glyphicon glyphicon-th-list"></span> Liste</a> 
		  <a href="<?php $astald->seo("dosyalar&amp;sayfa={$getirsayfa}&amp;klasor={$klasor_liste}&liste=galeri", site_url) ?>" class="<?php echo ($_liste_tip == 'galeri') ? 'active' : '' ?> btn btn-primary btn-xs" title="Dosyaları Galeri olarak Listele"><span class="glyphicon glyphicon-th-large"></span> Galeri</a>
		</div>
		<!-- #listele -->

		<!-- klasör listele -->
		<div class="btn-group pull-right menu-listele">
		  <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
		    <span class="glyphicon glyphicon-list"></span> Klasöre Göre Listele <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu acilir-menu" role="menu">
		    <?php
			 $_klasor = $db->get_results("SELECT * FROM ".MX."_klasor ORDER BY klasor_adi DESC");
			 if($_klasor)
			 {
			 foreach($_klasor as $klasor)
			 { 
				$klasor_id_kontrol = $klasor->id == $klasor_liste ? 'class="active"' : '';
			    echo "<li {$klasor_id_kontrol}><a href=\"{$astald->seo("dosyalar&amp;sayfa=$getirsayfa&amp;klasor=$klasor->id&amp;liste=$liste_tip", site_url, 'echo')}\">{$klasor->klasor_adi}</a></li>";
			 }
			  $aktif = 0;
			  echo "<li class=\"divider\"></li>";
			 }
			 else
			 {
			 $aktif = 1;
			 }
			?>
			 <li <?php echo ($aktif == 1) ? 'class="active"' : ''; ?>><a href="<?php $astald->seo("dosyalar&amp;sayfa=$getirsayfa&amp;klasor=0&amp;liste=$liste_tip", site_url) ?>">Kategorisiz Listele</a></li>
		  </ul>
		</div>  
		<!-- #klasör listele -->
		<?php if($_liste_tip == 'galeri'){ ?>
		<div class="pull-right label label-default liste-tur-2"><label for="tumunu_sec"><input type="checkbox" id="tumunu_sec"/> Tümünü Seç </label></div>
		<?php } ?>
	</div>
	<form action="<?php $astald->seo("dosyalar&amp;sayfa={$getirsayfa}&amp;klasor={$klasor_liste}&liste=$liste_tip", site_url) ?>" method="post" class="form">
	<?php
	/*
	 *  Dosya listesi
	 * veritabanından kullanıcıya ait dosyaları çekiyoruz
	*/
	
	$_dosyaSayisi = $db->get_var("SELECT COUNT(id) FROM ".MX."_dosyalar $_klasor_listele");
	$baslangic = $getirsayfa * $limit - $limit;
	$dosyaSayisi = ceil($_dosyaSayisi / $limit);
	$dosyalar = $db->get_results("SELECT * FROM ".MX."_dosyalar $_klasor_listele ORDER BY id DESC LIMIT $baslangic, $limit");
	if($dosyalar)
	{
	/*
	 * Çoklu seçimden gelen verileri silelim hem veritabanı hemde dosya'yı silecez
	*/
	if(isset($_POST['silenecekler'])) 
	{
		$_silenecekler = ($_POST['silenecekler']);
		echo "<div class=\"panel-body\">";
		foreach($_silenecekler as $eleman_sil) 
		{
			$_dosyalar = $db->get_row("SELECT * FROM ".MX."_dosyalar WHERE id='$eleman_sil' ");
			chmod("dosyalar", 0755);
			$_dosya_sil = unlink("dosyalar/".$_dosyalar->dosya_adi);
			$_veritabani_sil = $db->query("DELETE FROM ".MX."_dosyalar WHERE id='$_dosyalar->id'");
			if( $_veritabani_sil AND $_dosya_sil)
			{ 
				echo "<div class=\"alert alert-success alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Tebrikler</strong> #{$_dosyalar->id} numaralı Dosya kaydı baþarıyla silindi, <a href=\"{$astald->seo("dosyalar&amp;sayfa={$getirsayfa}&amp;klasor={$klasor_liste}&liste=$liste_tip", site_url, "echo")}\">Lütfen Sayfayı Yenileyiniz.</a> </div>";
			}
			else
			{
				echo "<div class=\"alert alert-danger alert-dismissable\"> <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button> <strong>Hata!</strong> #{$_dosyalar->id} numaralı Dosya kayıt silme iþlemi gerçekleþtirilemedi, lütfen tekrar dene. </div>";	
			} 
		}
		echo "</div>";
	}  
 
	
	/**
	 * Dosya listeleme tipi
	*/

	switch($_liste_tip)
	{
	
	/*
	 *  Listeleme Tipi Galeri listeleme
	*/
	
	case "galeri": 
	
		$_galeri_listele = "&amp;klasor={$klasor_liste}&liste=galeri";
	
	?>
	<div class="panel-body"> 
	<div class="row"> 
		<?php   
		foreach($dosyalar AS $dosya)
		{
		?>
		<div class="col-xs-6 col-md-3">
			<div class="thumbnail">
			<div class="galeri-img-list">
			<a href="<?php echo $astald->_resim($dosya->dosya_adi, dosyalar, site_url) ?>" class="fancybox-thumbs" title="<?php echo $dosya->dosya_adi ?>" data-fancybox-group="thumb">
			<img src="<?php echo $astald->_resim($dosya->dosya_adi, dosyalar, site_url) ?>" alt="Resim Dosyası">
			  <div class="caption">
				<?php echo $dosya->dosya_adi ?>
			  </div>
			</a></div>
			<div class="btn-group">
			  <a href="<?php echo $astald->_resim($dosya->dosya_adi, dosyalar, site_url) ?>" target="_blank" title="Dosyayı yeni sekmede aç" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-new-window"></span> Dosyayı Aç</a>
			  <a href="<?php $astald->seo("dosya.duzelt&amp;&no=".$dosya->id, site_url); ?>" title="Dosya bilgilerini düzelt" class="btn btn-default btn-xs">Düzelt</a>
			  <a href="<?php $astald->seo("dosya.sil&amp;dosya=".$dosya->dosya_adi."&no=".$dosya->id, site_url); ?>" title="Dosyayı sil" class="btn btn-danger btn-xs" onclick="return confirm('Dosyayı Silmek istediğinizden eminmisiniz?');"> <span class="glyphicon glyphicon-remove"></span> Sil</a>
			</div> 
			<span class="label label-default label-sm pull-right"> <input type="checkbox" name="silenecekler[]" value="<?php echo $dosya->id ?>" class="eleman_sec" /></span>
			</div>
		</div>
		<?php } ?>
	</div>
	<hr />
	<div class="clearfix"></div>
	<button type="submit" class="btn btn-danger btn-sm pull-left" onclick="return confirm('Seçilen(leri) silmek istediğinizden Eminmisiniz?')">Sil</button>
	<!-- sayfalama -->
	<ul class="pagination pull-right sayfalama"> 
	<?php    
		if($getirsayfa > 1)  
			echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.($getirsayfa - 1).$_galeri_listele, site_url, 'echo').'">önceki &laquo;</a></li>';
		else
			echo '<li class="disabled"><a href="javascript:void(0);">önceki &laquo;</a></li>';
		
		for($i=$getirsayfa-saya_arasi_fark; $i<=$getirsayfa+saya_arasi_fark+1; $i++)
		{
			if($i>0  && $i<=$dosyaSayisi)
			{
				if($i==$getirsayfa)
					echo '<li class="active"><a href="#">'.$i.'</a></li>';
				else
					echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.$i.$_galeri_listele, site_url, 'echo').'">'.$i.'</a></li>';
			}
		}
		if($getirsayfa == $dosyaSayisi)
			echo '<li class="disabled"><a href="javascript:void(0);">sonraki &raquo;</a></li>';
		else
			echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.($getirsayfa + 1).$_galeri_listele, site_url, 'echo').'">sonraki &raquo;</a></li>';
	?> 
	</ul> 
	<!-- #sayfalama -->
	</div> 
	<?php  
	break;
	
	/*
	 * Varsayılan Tablo ile Listeleme Tipi Liste
	*/
	default:
	?>
	<table class="table table-hover table-striped">
	<thead>
		<tr> 
			<th><input type="checkbox" id="tumunu_sec"/></th>
			<th>#</th>
			<th>Klasör</th>
			<th>Dosya Adı</th>
			<th>Dosya Uzantı</th>
			<th>Dosya NOT</th>
			<th>Yüklenme Tarihi</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<?php   
		foreach($dosyalar AS $dosya)
		{
		?>
		<tr> 
			<td><input type="checkbox" name="silenecekler[]" value="<?php echo $dosya->id ?>" class="eleman_sec" /></td>
			<td><?php echo $dosya->id ?></td> 
			<td><a href="<?php $astald->seo("dosyalar&amp;listele=".$dosya->klasor_id, site_url) ?>"><?php echo $_astald->klasor_bul($dosya->klasor_id, "klasor_adi") ?></a></td> 
			<td><a href="<?php echo $astald->_resim($dosya->dosya_adi, dosyalar, site_url) ?>" class="fancybox-thumbs" target="_blank"><?php echo $dosya->dosya_adi ?></a></td> 
			<td><?php echo $dosya->dosya_uzanti ?></td> 
			<td><?php echo $astald->metin_kisalt($dosya->dosya_not, 0, 20, 20 ) ?></td> 
			<td><?php echo $dosya->tarih ?></td> 
			<td width="19%">
			<div class="btn-group">
			<a href="<?php echo $astald->_resim($dosya->dosya_adi, dosyalar, site_url) ?>" target="_blank" title="Dosyayı yeni sekmede aç" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-new-window"></span> Dosyayı Aç</a>
			<a href="<?php $astald->seo("dosya.duzelt&amp;&no=".$dosya->id, site_url); ?>" title="Dosya bilgilerini düzelt" class="btn btn-default btn-xs">Düzelt</a>
			<a href="<?php $astald->seo("dosya.sil&amp;dosya=".$dosya->dosya_adi."&no=".$dosya->id, site_url); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Dosyayı Silmek istediğinizden eminmisiniz?');"><span class="glyphicon glyphicon-remove"></span> Sil</a>
			</div>
			</td>
		</tr>
		<?php  } ?>
	</tbody>
	<thead>
	<tr> 
		<td colspan="2">
			<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Seçilen(leri) silmek istediğinizden Eminmisiniz?')">Sil</button>
		</td>
		<td colspan="7"> 
		<!-- sayfalama -->
		<ul class="pagination pull-right sayfalama"> 
		<?php    
			if($getirsayfa > 1)  
				echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.($getirsayfa - 1).$_klasor_sayfa_liste, site_url, 'echo').'">önceki &laquo;</a></li>';
			else
				echo '<li class="disabled"><a href="javascript:void(0);">önceki &laquo;</a></li>';
			
			for($i=$getirsayfa-saya_arasi_fark; $i<=$getirsayfa+saya_arasi_fark+1; $i++)
			{
				if($i>0  && $i<=$dosyaSayisi)
				{
					if($i==$getirsayfa)
						echo '<li class="active"><a href="#">'.$i.'</a></li>';
					else
						echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.$i.$_klasor_sayfa_liste, site_url, 'echo').'">'.$i.'</a></li>';
				}
			}
			if($getirsayfa == $dosyaSayisi)
				echo '<li class="disabled"><a href="javascript:void(0);">sonraki &raquo;</a></li>';
			else
				echo '<li><a href="'.$astald->seo('dosyalar&sayfa='.($getirsayfa + 1).$_klasor_sayfa_liste, site_url, 'echo').'">sonraki &raquo;</a></li>';
		?> 
		</ul> 
		<!-- #sayfalama -->
		</td>
	</tr>
	</thead>
	</table> 
	<?php 
	break;
	} 
	?>
	<?php 
	}
	else
	{
		echo "<div class=\"panel-body\"><div class=\"alert alert-info sayfalama\"> <strong>Bilgilendirme</strong> <p>Sisteme kayıtlı dosyanız yok, dosya yükledikten sonra dosyalarınız listelenecektir.</p> </div></div>";
	}
	?> 
	</form>
</div>
<!-- #yüklediğim dosyalar -->
<?php } ?>