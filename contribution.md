# Panduan Untuk Kontribusi Dalam Project Actudent
<i>Panduan ini hanya diperuntukkan untuk developer Actudent</i>

### Engines
- Server-side Language : PHP 7.2
- Web Framework : CodeIgniter 4
- UI Framework : Vue.js 2.5.17
- Android : Java
- Database : MySQL
- DBMS Software : PHPMyAdmin
- API Response : JSON

### Struktur Folder Utama
- `actudent`<br>
Root folder untuk semua modul Actudent. Modul yang ada saat ini adalah `Admin` dan `Core`
- `app`<br>
Folder aplikasi default dari CodeIgniter, digunakan untuk menyimpan global config dan locale resource
- `public`<br>
Folder tempat menyimpan file aset yang dapat dibaca oleh browser seperti CSS, Javascript, dokumen atau gambar
- `queries` <br>
Tempat menyimpan backup database berupa file `.sql`
- `system` <br>
File sistem CodeIgniter, tidak boleh dimodifikasi.
- `writable` <br>
Tempat menyimpan logs, session, cache dan file yang diupload

### Modularisasi
Basis kode Actudent menggunakan konsep modularisasi untuk memudahkan development dan maintenance aplikasi. Konsep ini dipilih karena memungkinkan Actudent dibagi ke dalam beberapa sub-sistem, seperti panel Admin, Guru, Orang Tua, Shared Classes, dan Mobile API. Meski dibagi ke dalam sub-sistem, namun antar modul masih bisa saling berkomunikasi seperti layaknya konsep OOP standar.

### Struktur Modul
- `Admin`
Tempat menyimpan kode sumber modul Admin. Semua kode yang spesifik hanya untuk Admin harus disimpan di dalam modul ini.
- `Core`
Merupakan tempat menyimpan shared classes atau class inti yang dipakai oleh beberapa modul.

### Core Class
Seperti halnya pada CodeIgniter 3, core class `Actudent` tetap ada. Untuk versi web, class ini wajib untuk dipanggil pada semua Controller. Perbedaannya, class `Actudent` kini tidak lagi di-extend oleh tiap controller melainkan dipanggil secara manual.

### Namespace
Penggunaan namespace adalah <b>wajib</b> untuk semua class karena dengan namespace inilah nantinya antar class bisa berkomunikasi, termasuk Controller dan Model. Cara penggunaan namespace dapat dipelajari di dokumentasi resmi [PHP](https://www.php.net/manual/en/language.namespaces.php).

### Autoloader
Dengan Autoloader pada CodeIgniter, memanggil class cukup dengan menggunakan statement `use`. Contoh:<br>
```
use Actudent\Core\Controllers\Actudent;
$ac = new Actudent;
```

### View Parser
Actudent menggunakan template parser engine dari CodeIgniter 4 dengan tambahan plugin `include` dan `menu_active`. Lihat pada folder `Views` untuk mengetahui cara penggunaan plugin custom Actudent tersebut. Untuk panduan penggunaan View Parser selengkapnya dapat dilihat di halaman dokumentasi CodeIgniter 4 [berikut ini](https://codeigniter4.github.io/CodeIgniter4/outgoing/view_parser.html).

### Model
Setiap model harus meng-extend class `\Actudent\Core\Models\ModelHandler`. Semua query wajib menggunakan Query Builder dari CodeIgniter 4. Panduan menggunakan Query Builder  dapat dilihat pada [halaman ini](https://codeigniter4.github.io/CodeIgniter4/database/query_builder.html).

### Per-page User Checking
Actudent menggunakan `Filter` dari CodeIgniter 4. Semua halaman Actudent diproteksi menggunakan filter ini. Berbeda dengan versi CodeIgniter 3 yang melakukan filter pada tiap class constructor, pada CodeIgniter 4 filter hanya dilakukan pada satu class yaitu `\Actudent\Admin\Filters\AdminFilter` untuk panel admin.

### Style Guide
Aturan dalam penulisan kode mengikuti standar yang ditetapkan oleh CodeIgniter 4 yang dapat dilihat pada [halaman ini](https://github.com/codeigniter4/CodeIgniter4/blob/develop/contributing/styleguide.rst). Standar kode ini harus diikuti untuk menjaga konsistensi code base Actudent.