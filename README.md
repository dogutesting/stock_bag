# stock_bag

## PC
### PC SS 1:
![Screenshot_1](https://github.com/dogutesting/stock_bag/assets/80362520/855547db-2356-47ba-81cf-fb869265bc29)
### PC SS 2:
![Screenshot_3](https://github.com/dogutesting/stock_bag/assets/80362520/7aa88bca-874f-4f63-aba4-526e69a26a02)
### PC SS 3:
![Screenshot_4](https://github.com/dogutesting/stock_bag/assets/80362520/e3151a66-c782-4adf-9235-99c437b0b03c)
## Mobile
### Mobile SS 1:
![phone_0](https://github.com/dogutesting/stock_bag/assets/80362520/164bc87a-7de1-4634-9f8c-4982e54098f5)
### Mobile SS 2:
![phone_1](https://github.com/dogutesting/stock_bag/assets/80362520/986bddf3-8b30-4b49-9467-df28236a4208)

## Language Shortcuts
- [DE](#de)
- [EN](#en)
  
# TR
##### Not: 04.04.2023 tarihinde üzerinde uğraştığım bir proje bilgisayarımda duracağına github'a yüklemek istedim.
### Tanım: 
> Hisse değerlerine bakılabilir ve çantaya eklenip, kâr-zarar oranı takip edilebilir mini bir site.

### Amaç:
> Hisse almış olsaydım kâr zararım ne olurdu görmek için böyle bir uygulama kodladım.

### Kullanılan Diller:
- Html
- Css
- Javascript(+jQuery)
- PHP
- MySql

### Kurulum
- Web sunucu paketini indirip, kurun. Örnek: Xampp https://www.apachefriends.org/tr/index.html
- xampp/htdocs klasörü içerisine bu repoyu kopyalayın
- Xammp uygulamasını çalıştırıp Apache ve MySql'i başlatın.
- localhost/phpmyadmin sayfasına gidip sync_notes_db adında bir database oluşturun.
- Repo içerisindeki a_sql_file klasöründe bulunan sql'i içe aktarın.
- php klasörü içerisindeki server.php dosyasını düzenleyin.
- İstediğiniz modifikasyonları yapın.

## Sorunlar:
- Stabil olmayan hisse veri kütüphanesi kullanılıyor. Sürekli güncelleme gerekli, kütüphane geliştiricisi desteği keserse proje çalışmayı durdurur.
- Uygulama yavaş açılıyor
- Bazı arama terimlerinde hata veriyor, ekrana yazdırılması engellenmesi lazım

# EN
##### Note: On 04.04.2023, I worked on a project that I wanted to upload to GitHub instead of keeping it on my computer.
### Description:
> A mini website where stock values can be viewed, stocks can be added to a portfolio, and profit-loss ratio can be tracked.

### Purpose: 
> I coded this application to see what profit or loss I would have made if I had purchased stocks.

### Used Languages:
- Html
- Css
- Javascript(+jQuery)
- PHP
- MySql

### Installation:
- Download and install a web server package. Example: Xampp https://www.apachefriends.org/en/index.html
- Copy this repository to the xampp/htdocs folder.
- Start the Xampp application and run Apache and MySql.
- Go to localhost/phpmyadmin and create a database named "sync_notes_db".
- Import the SQL file found in the "a_sql_file" folder of the repository.
- Edit the "server.php" file inside the "php" folder.
- Make any desired modifications.

## Issues:
- An unstable stock data library is being used. Continuous updates are necessary, and if the library developer discontinues support, the project will cease to function.
- The application has a slow startup time.
- There are some errors in certain search terms, preventing them from being displayed on the screen.
