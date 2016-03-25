# Özel Dosya İndirme Scripti
Ücretsiz php özel dosya yükleme scripti.
Kendi sunucunuza anlık olarak özel dosyalarınızı yükleyip barındırmak istiyorsanız, pure php ile yapılmış dosya indirme scripti. Ücretsizdir dilediğiniz gibi kullanabilirsiniz.

# Kurulum
**veritabani.php** dosyasını açıyoruz.
```php
/* Veritabanı Bilgileri */ 
define("db_host", "localhost"); 
define("db_veritabani", "indir_veritabani"); 
define("db_mysql_kullanici", "indir_kullanici_adi"); 
define("db_mysql_parola", "123"); 

/* Site URL */
define("site_url", "http://dosyadepo.astald.com"); // ÖRNEK ADRESTİR
```

gerekli ayarları yaptıktan sonra kurulumunu yaptığımız adrese bağlanıp scriptimizi kullanmaya başlayabiliriz. :)
