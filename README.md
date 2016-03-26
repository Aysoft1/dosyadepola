# Özel Dosya İndirme Scripti
Ücretsiz php özel dosya yükleme scripti.
Kendi sunucunuza anlık olarak özel dosyalarınızı yükleyip barındırmak istiyorsanız, pure php ile yapılmış dosya indirme scripti. Ücretsizdir dilediğiniz gibi kullanabilirsiniz.
"Not: Scripti yapmamın amacı 2013 üniversiteye başladığım zamanlar okuldaki ödevleri dökümanları kısa bir süre içinde kendi siteme yükleme için uygun zamanlarımda kodlamıştım. Şuanda bile kullanıyorum tabi dağınık bir yapı mevcut karışık çalışanlar için php başlangıç seviyesine giriş yapanlarında işine yarayabilecek düzeyde yapılmış sade basit dosya depolama scripti"

# Kurulum
Veritabanımızı oluşturduğumuz varsayalım.
**VERITABANI - SQL.sql** dosyasını oluşturmuş olduğumuz veritabanın içine aktarıyoruz.

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

# Önizleme
![DosyaDepola](http://indir.astald.com/dosyalar/login_db_56f66cb4372c7.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_1_db_56f66cb43e262.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_2_db_56f66cb4442c6.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_3_db_56f66cb449080.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_4_db_56f66cb44e9d3.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_5_db_56f66cb458747.png)
![DosyaDepola](http://indir.astald.com/dosyalar/screenshot_6_db_56f66cb45f659.png)

# Bilgi
www.astald.com
