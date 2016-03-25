<?php       
/*********** /// Astald.COM /// ***********  
 * Özel Dosya Yükleme Servisi   
 * Osman YILMAZ
 * www.astald.com    
 * Copyright astald.com 
*******************************************/  
if (stristr(htmlentities($_SERVER['PHP_SELF']), "db.sistem.php")) {die("<h1>Erişim Engellendi!.</h1>"); header("location:/index.php"); }
class Astald 
{ 
	/*****************
	 *  Value
	 * var value, image
	******************/  
	public $sonucu;
	public $tarih;
	public $gecti_kaldi;
	var $value;
	var $image;
	var $seo;
	
	/*********
	 * Array Post List
	 * json list
	********/
	public function __data ()
	{
		$param__ = func_get_args();
		foreach($param__[0] AS $param){
			if($param__[1] == 'get')
				echo '$'.$param.'_post = $_GET["'.$param.'"];';
			else
				echo '$'.$param.'_post = $_POST["'.$param.'"];';
			
		}
	}
	
	/*****************
	 *  Sql injection açık önlemleri
	 * guvenlik fnk., sayısal fonksyino
	******************/ 
	public function guvenlik ()
	{ 
		global $db;
		$param = func_get_args();
		try
		{
			if($param[1] == "intval")
				return $db->escape(intval($param[0])); 
			else
				return $db->escape(trim($param[0])); 
		} 
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	public function security ($invalue)
	{ 
		global $db;
		try
		{
			return $db->escape(trim($invalue)); 
		} 
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	function intvall ($invalue)
	{ 
		try
		{
			return $this->value = intval($invalue); 
		}
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	public function yonlendir ($invalue)
	{
		try
		{
			return $this->value = '<script type="text/javascript">window.location.href="'.$invalue.'"</script>';
		}
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	public function print_ ($value)
	{
		try
		{
			echo '<pre>';
				print_r($value);
			echo '</pre>';
		}
		catch (Exception $error)
		{
			return $error->getMessage();
		}
	}
	public function metin_kisalt ($deger, $baslangic, $bitis)
	{ 
		try
		{
			if(empty($deger))
			{
				return "Yok";
			}
			else
			{
				if($baslangic >= $limit)
					$uc_nokta = "...";
				else
					$uc_nokta = "";
				return substr($deger, $baslangic, $bitis).$uc_nokta;
			}
		}
		catch (Exception $error)
		{
			return $error->getMessage();
		}
	}
	public function page_uri ()
	{
		try
		{
			$this_page = basename($_SERVER['REQUEST_URI']);
			if (strpos($this_page, "?") !== false) 
				$this->value = reset(explode("?", $this_page));
				return $this->value;
		}
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	public function request_URI () 
	{
		try 
		{ 
			if(!isset($_SERVER['REQUEST_URI'])) 
			{
				$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
				if($_SERVER['QUERY_STRING'])
					$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
			return $_SERVER['REQUEST_URI'];
		} 
		catch ( Exception $error ) 
		{ 
			return $error->getMessage();
		}
	}
	/*****************
	 *  Tarih Hesaplama
	 * tarih sonucunu direkt bastırabilir, tarih, geçti kaldı, veya kutucuk için 
	******************/ 
	public function tarih_hesapla ()
	{
		try 
		{ 
			$param = func_get_args();
			$tarih_1 = strtotime($param[0]);  
			$simdiki_tarih = strtotime(date("d.m.Y"));
			$tarih_2 = explode(".", (int) (($tarih_1 - $simdiki_tarih)/(60*60*24)));
			$tarih_3 = explode("-", $tarih_2[0]);  
			if($param[1] == 'tam_tarih')
			{
				$this->tarih = (empty($tarih_3[1]) or ($tarih_3[1]=='')) ? $tarih_3[0] : $tarih_3[1];
				$this->gecti_kaldi = (empty($tarih_3[0]) or ($tarih_3[0]=='')) ? 'Geçti' : 'Kaldı';
				if(empty($this->tarih) or ($this->tarih == ''))
					$this->sonucu = 'Bu Gün SON';
				else
					$this->sonucu = $this->tarih. ' Gün '.$this->gecti_kaldi;
			}
			else
			{
				if($param[1] == "kutucuk")
					$this->sonucu = (empty($tarih_3[0]) or ($tarih_3[0]=='')) ? 'danger' : 'success';
				else if($param[1] == "gecti_kaldi")
					$this->sonucu = (empty($tarih_3[0]) or ($tarih_3[0]=='')) ? 'Geçti' : 'Kaldı';
				else
					$this->sonucu = (empty($tarih_3[1]) or ($tarih_3[1]=='')) ? $tarih_3[0] : $tarih_3[1];
			} 
			return $this->sonucu;
			} 
		catch ( Exception $error ) 
		{ 
			return $error->getMessage();
		}
	}
	/*****************
	 *  Curl
	 * curl browser user
	******************/ 
	public function curl( $url, $post = false )
	{
		try 
		{
			$user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; tr; rv:1.9.0.6) Gecko/2009011913 Firefox/3.0.6';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, $post ? true : false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post ? $post : false);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			$content = curl_exec($ch);
			curl_close($ch);
			return $content;
		} 
		catch ( Exception $error ) 
		{
			return $error->getMessage();
		}
		
	}
	public function encodeToUtf8($string) 
	{
		try
		{
			return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "ISO-8859-9", true));
		}
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}  
	public function curl_content($start, $finish, $content)
	{
		try
		{
			@preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($finish, '/').'/i', $content, $m);
			return @$m[1];
		}
		catch ( Exception $error )
		{
			return $error->getMessage();
		}
	}
	
	/*****************
	 *  Seo
	 * sef link adress create funct
	******************/ 
	public function seo ()
	{  
		
		$param = func_get_args();
		$this->seo = $param[1].'/index.php?astald='.$param[0]; 
		if(empty($param[2]))
			echo $this->seo; 
		return $this->seo; 
	}
	public function _resim ()
	{
		$param = func_get_args(); 
		return $param[2].'/'.$param[1].'/'.$param[0];
	}
	
	/********************
	 * function name: file_path_img 
	 * func type of img -> file name 
	 * func type of dir -> file directory 
	 * func type of print -> file output to the screen 
	 * func type of temp -> file temp
	 // old func system > $img, $site_url, $dir, $print = null, $temp = null
	*********************/
	public function file_path_img ()
	{
		try
		{
			// param 1 --> img name
			// param 1 --> site_url
			// param 2 --> dir
			// param 3 --> print
			// param 4 --> temp 
			$param = func_get_args();
			if(isset($param[4]))
				$this->image = 'uploads/'.$param[2].'/'.$param[0];
			else 
				$this->image = $param[1].'/uploads/'.$param[2].'/'.$param[0];
			if(empty($param[3]))
				echo $this->image;
			return $this->image;
		}
		catch ( Exception $error )
		{
			return $eror->getMessage();
		}
	} 
	
	/*****************
	 *  resim boyutlandırma
	 * imgthumb
	 * örnekler kullanım - araç listelemede kullanılan şekli
	 * $astald->imgtuhmb('cars', $arac->arac_resim_1, site_url, 190, 150)
	******************/ 
	public function imgtuhmb()
	{
		global $db;
		try
		{
			$param = func_get_args(); 
			if(empty($param[0]) or empty($param[1]))
				return $this->image = "ERROR#003";
			else if(!empty($param[3]) or !empty($param[4]))
				return $this->image = "{$param[2]}/imagethumb.php?dir={$param[0]}&amp;file={$param[1]}&amp;w={$param[3]}&amp;h={$param[4]}";
			else  
				return $this->image = "{$param[2]}/imagethumb.php?dir={$param[0]}&amp;file={$param[1]}";
			echo $this->image;
		}
		catch ( Exception $error )
		{
			return $eror->getMessage();
		}
	}
	
	/*****************
	 *  Seo
	 * sef oluşturma fonk.-> create funct
	******************/ 
	public function seola($s) 
	{
		$tr = array('ş','Ş','i','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','&uuml;','ı','&amp;','&nbsp;');
		$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','u','i','','');
		$s = str_replace($tr,$eng,$s);
		$s = strtolower($s);
		$s = preg_replace('/&.+?;/', '', $s);
		$s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
		$s = preg_replace('/\s+/', '-', $s);
		$s = preg_replace('|-+|', '-', $s);
		$s = trim($s, '-');
		return strip_tags($s);
	}
	
	public function seola_($degistir)
	{
		$bunu = array('+');
		$bununla = array('_');
		$degistir = str_replace($bunu,$bununla,$degistir);
		return strip_tags($degistir);
	}

	/* File path name */
	public function file_path_img_name($s) 
	{
		$tr = array('a','b','c','Ç','ç','d','e','f','g','ğ','Ğ','h','ı','i','I','İ','j','k','l','m','n','o','ö','Ö','p','r','s','ş','Ş','t','u','ü','Ü','v','y','z','&uuml;','&amp;','&nbsp;');
		$eng = array('A','B','C','C','C','D','E','F','G','G','G','H','I','I','I','I','J','K','L','M','N','O','O','O','P','R','s','S','S','T','U','U','U','V','Y','Z','','','');
		$s = str_replace($tr,$eng,$s);
		$s = strtolower($s);
		$s = preg_replace('/&.+?;/', '', $s);
		$s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
		$s = preg_replace('/\s+/', '-', $s);
		$s = preg_replace('|-+|', '-', $s);
		$s = trim($s, '-');
		return strip_tags($s);
	}
	
	function boyut($bayt) 
	{
		if($bayt < 1024) 
		{ 
			return "$bayt byte"; //Byte cinsini alıyoruz
		} 
		else
		{
			$kb = $bayt / 1024;
			if ($kb < 1024)
			{
				return sprintf("%01.2f", $kb)." KB"; //KB cinsine dönüştürüyoruz
			}else
			{
				$mb = $kb / 1024;
				if($mb < 1024)
				{
					return sprintf("%01.2f", $mb)." MB"; //MB cinsine dönüştürüyoruz
				}
				else
				{
					$gb = $mb / 1024;
					return sprintf("%01.2f", $gb)." GB"; //GB cinsine dönüştürüyoruz
				}
			}
		}
	}

} 

?>