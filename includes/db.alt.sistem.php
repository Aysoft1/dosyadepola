<?php       
/*********** /// Astald.COM /// ***********  
 * Özel Dosya Yükleme Servisi   
 * Osman YILMAZ
 * www.astald.com    
 * Copyright astald.com 
*******************************************/  
if (stristr(htmlentities($_SERVER['PHP_SELF']), "db.alt.sistem.php")) {die("<h1>Erisim Engellendi!.</h1>"); header("location:/index.php"); }
class _Astald extends Astald 
{
	public $value;
	public $settings;
	
	/*********************************
	 * DS klasör bulma
	 * -> klasor adI, id
	*********************************/
	public function klasor_bul ()
	{
		global $db;
		try 
		{
			$param = func_get_args();
			$query = $db->get_row("SELECT * FROM ".MX."_klasor WHERE id = '$param[0]'");
			if($query)
			{
				if($param[1] == 'klasor_adi')
					$this->value = $query->klasor_adi; 
				else
					$this->value = $query->id;
			}
			else
			{
				$this->value = "YOK";
			}
			return $this->value;
		}
		catch ( Exception $error )
		{
			return  $error->getMessage();
		}
	}
	
}

?>