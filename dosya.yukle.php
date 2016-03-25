<?php       
/*********** /// Astald.COM /// ***********  
 * Özel Dosya Yükleme Servisi   
 * Osman YILMAZ
 * www.astald.com    
 * Copyright astald.com 
*******************************************/  
if(@$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{
sleep(1);
include_once "ayar.php";
if (isset($_POST) && $_SERVER["REQUEST_METHOD"] == 'POST')
{
    $git_uye_id = $astald->guvenlik($_POST["git"], "intval");
	if(empty($_FILES["files"]["name"]) or empty($git_uye_id))
	{
		echo ' <div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Bilgilendirme!</h4><p>Lütfen dosya seçiniz, işlem gerçekleştirilemedi.</p></div>';
	} 
	else 
	{
		$klasor_id = $astald->guvenlik($_POST["dosya_klasor"],"intval");
		$dosya_not = iconv("utf-8", "ISO-8859-9//TRANSLIT", $astald->guvenlik($_POST["dosya_not"]));
		$tarih = date("d.m.Y");
		$saat = date("H:i:s");
		$max_boyut = 20 * 1024 * 1024;
		$uzantilar = array('png','gif','jpg','jpeg','JPG','bmp','doc','docx','xls','ppt','pdf','tar.gz','rar','zip');
		$dosya_sayisi = count($_FILES["files"]["name"]);
		$i = 0;
		foreach($_FILES["files"]["error"] AS $upload => $error)
		{
			
			$dosya_boyut = $_FILES["files"]['size'][$upload];
			$file_name = $_FILES['files']["name"][$upload];
			if ($error == UPLOAD_ERR_OK) 
			{
			$dosya_uzanti = @end(explode(".", $_FILES["files"]["name"][$upload]));
			if (in_array($dosya_uzanti, $uzantilar) AND  $dosya_boyut < $max_boyut)
			{ 
				if (is_uploaded_file($_FILES["files"]["tmp_name"][$upload]))
				{ 
					$_dosya_adi = substr($_FILES['files']["name"][$upload], 0, -4);
					$dosya_adi = $astald->seola($_dosya_adi).'_db_'.uniqid().'.'.$dosya_uzanti;
					$temp = dir_names."/".dosyalar."/".$dosya_adi;
					if (move_uploaded_file($_FILES['files']["tmp_name"][$upload], $temp))
					{
						$dosya_link = $astald->_resim($dosya_adi, dosyalar, site_url);
						$insert = $db->query("INSERT INTO ".MX."_dosyalar (uye_id,klasor_id,dosya_adi,dosya_uzanti,dosya_not,tarih,saat) VALUE ('$git_uye_id','$klasor_id','$dosya_adi','$dosya_uzanti','$dosya_not','$tarih','$saat')"); 						
						if($insert)
						{
						  $sonuc = "<div class=\"panel panel-default\">
								<div class=\"panel-heading\">Dosya Adı: {$file_name} - Boyut: {$astald->boyut($dosya_boyut)}</div>
								<div class=\"panel-body\">";
							$sonuc .= "<div class=\"row\"><div class=\"col-md-5\">";
							
							if(in_array($dosya_uzanti, array('png','gif','jpg','jpeg','JPG','bmp')))
							{
								$sonuc .= '<img src="'.$dosya_link.'" alt="dosya adi" class="thumbnail" width="100%" height="50%" />';
							}
							else
							{
								$sonuc .= '<img src="'.site_url.'/dist/img/files.png" alt="dosya adi" class="thumbnail" width="100%" height="50%" />'; 
							}
							$sonuc .= "</div>";
							$sonuc .= "<div class=\"col-md-7\">";
							$sonuc .= '<div class="form-group"><label for="dosyaAdresi_'.$i.'">Dosya Adresi</label><input type="text" class="form-control" id="dosyaAdresi_'.$i.'" value="'.$dosya_link.'"  onClick="TumunuSec(\'dosyaAdresi_'.$i.'\');" /></div> ';
							$sonuc .= '<div class="form-group"><label for="dosyaSilme_'.$i.'">Dosya Silme Adresi</label><input type="text" class="form-control" id="dosyaSilme_'.$i.'" value="'.$astald->seo("dosya.sil&dosya=".$dosya_adi."&no=".$db->insert_id, site_url, "echo").'" onClick="TumunuSec(\'dosyaSilme_'.$i.'\');" /></div> ';
							$sonuc .= "</div></div>";
							$sonuc .= "</div>
						  </div>";
							echo $sonuc;
						}
						else
						{
							echo '<div class="alert alert-danger"><h4>Hata!</h4><p>Dosya veritabanı kaydı yapılamadı.</p></div>';
						}
					}
					else
					{
						echo ' <div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>
						<h4>Uyarı!</h4><p>Dosya yüklendi ancak taşınamadı, lütfen dosyanın chmod ayarlarının yazdırılabilir olduğundan emin olunuz.</p></div>';
					} 
					 
				}
				else 
				{ 
					echo '<div class="alert alert-danger"><h4>Hata!</h4><p>Bir sorun oluştu ve dosya yüklenemedi!!.</p></div>';
				}
				
			}
			else 
			{ 
				echo '<div class="alert alert-info"><h4>Hata!</h4><p>Yüklemeye çalıştığınız dosya uzantısı geçerli değil veya dosya boyutu çok büyük.</p></div>';
			} 
			}
			$i++;
		}
	}
}
}
else
{
die("Hata! islem gerceklesitirlemedi!!");
}
?>