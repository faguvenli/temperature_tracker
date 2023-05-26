## ISI TAKİP SİSTEMİ

Öncelikle laboratuvarlardaki tıbbi cihazların ısı değerlerini takip etmek ve raporlamak için hazırlanmış bir sistemdir.

### Kurulum

<p>Sistem birden fazla veritabanı kullanmaktadır.</p>
<p>Birincil veritabanında kullanıcı bilgileri, yetkiler, bölgeler bulunurken, ikincil veritabanı(ları)nda laboratuvara ait cihazların listesi ve ısı değerleri tutulmaktadır.</p>
<p>İlk kurulumda çalıştırılması gereken komut:</p>

- php artisan migrate:fresh --seed

<p>Sisteme yeni bir firma eklendiğinde öncelikli olarak firmaya ait bir veritabanı manuel olarak oluşturulmalı, ardından terminalde aşağıdaki komut çalıştırılmalıdır.</p>

- php artisan migrate:tenants veritabanı_adı

<p>Örneğin Ondokuz Mayıs Üniversitesi Laboratuvarı için kurulum yapacaksak;</p>

- iot_ilmed adında yeni bir veritabanı oluşturuyoruz.
- php artisan migrate:tenants iot_ilmed komutunu terminalde çalıştırıyoruz.
- mevcut tenant veritabanını temizlemek için --fresh komutunu ekleyebiliriz. Bu durumda komut satırına
<p>php artisan migrate:tenants iot_ilmed --fresh</p> yazmamız gerekir.
