<?php   
/****************** /// ASTALD.COM /// ******************
 * Sistem Ayar Dosyası
 * Özel Dosya Yükleme Servisi
 * www.astald.com
 * Copyright astald.com
***************************************/
	
/* test if the browser support gz compression */
if( ! ob_start("ob_gzhandler") ) 
  /* if the browser don't support gz compression init the regular output buffer */
  ob_start();
  /* session cookie start */
  @session_start();
 
/* error_reporting(E_ALL); */
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
 
/* Sabit Deðiþkenler */
define("includes", "includes"); 
define("MX", "db"); 

 
/* Özel Dosya Yükleme sistemi */
require_once includes . "/db.sistem.php";
$astald = new Astald; 

require "veritabani.php";

/* Dosya yükleme sınıfı */
require_once includes . "/class.upload.php";

/* ezSQL veritabanı dosyaları */
require_once includes . "/ezsql/ez_sql_core.php";
require_once includes . "/ezsql/ez_sql_mysql.php";

/* ezSQL veritabanı baðlantısı */
try
{
  $db = new ezSQL_mysql(db_mysql_kullanici, db_mysql_parola, db_veritabani, db_host);
}
catch( PDOException $access )
{
  echo $access->getMessage();
  exit();
}


/* mysql UTF8 */
$db->query("SET NAMES 'latin5' ");
$db->query("SET CHARACTER SET latin5 ");
$db->query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");



require_once includes . "/db.alt.sistem.php";
$_astald = new _Astald; 


define("kullanici_adi","admin");
define("kullanici_parola","admin");

/* realpath */
define("dir_names", realpath(dirname(__FILE__)));  
define("dosyalar", "dosyalar");
define("saya_arasi_fark", 3);