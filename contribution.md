# Panduan Untuk Kontribusi Dalam Project Actudent (Web Version only)
<i>Panduan ini hanya diperuntukkan untuk developer Actudent</i>

## Panduan Umum
### Engines
- Server-side Language : PHP 7.4
- Web Framework : CodeIgniter 4.0.4
- UI Framework : Vue.js 2.6.12
- Database : MySQL
- API Response Format : JSON

### Struktur Folder Utama
- `actudent`<br>
Root folder untuk semua modul Actudent. Modul-modul tersebut adalah `Admin`, `Core` dan `Guru`
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

## Panduan Pengembangan di Sisi Server
### Modularisasi
Basis kode Actudent menggunakan konsep [modularisasi](https://en.wikipedia.org/wiki/Hierarchical_model%E2%80%93view%E2%80%93controller) untuk memudahkan development dan maintenance aplikasi. Konsep ini dipilih karena memungkinkan Actudent dibagi ke dalam beberapa sub-sistem, seperti panel Admin, Guru dan Core System. 

### Struktur Modul
- `Admin`
Tempat menyimpan kode sumber modul Admin. Semua kode yang spesifik hanya untuk Admin harus disimpan di dalam modul ini.
- `Core`
Merupakan tempat menyimpan shared classes atau class inti yang dipakai oleh beberapa modul.
- `Guru`
Merupakan tempat menyimpan kode sumber modul Guru.

### Core Controller
`Actudent` merupakan core controller yang wajib ada di semua controller Actudent. Tanpa class ini, Actudent tidak akan dapat berjalan sebagaimana mestinya. Hanya kontributor inti yang diperkenankan memodifikasi class ini. Class ini tersedia dengan namespace `Actudet\Core\Controllers\Actudent`.

### Database Connector
Actudent tidak menggunakan model bawaan CodeIgniter4, sementara untuk koneksi databasenya, Actudent
memiliki sebuah class `Connector` yang tersedia dengan namespace `Actudent\Core\Models\Connector`.
Setiap model Actudent harus mengextend class ini agar dapat berinteraksi dengan database.

### Admin's shared model
Khusus untuk modul admin, tersedia sebuah shared class model yaitu `SharedModel` yang dapat dipanggil via `Actudent\Admin\Models\SharedModel`. Model ini menyediakan beberapa tabel yang sering digunakan oleh model-model lain. Karena class ini memiliki cukup banyak properti, disarankan hanya menggunakan class ini jika anda membutuhkannya.

### Namespace
Penggunaan namespace adalah <b>wajib</b> untuk semua class karena dengan namespace inilah nantinya antar class bisa berkomunikasi, termasuk Controller dan Model. Cara penggunaan namespace dapat dipelajari di dokumentasi resmi [PHP](https://www.php.net/manual/en/language.namespaces.php).

### Autoloader
Dengan Autoloader terbaru pada CodeIgniter4, memanggil class cukup dengan menggunakan statement `use`. Contoh:<br>
```
use Actudent\Core\Controllers\Actudent;
$ac = new Actudent;
```

### View Parser
Actudent menggunakan template parser engine dari CodeIgniter 4 dengan tambahan plugin `include` dan `menu_active`. Lihat pada folder `Views` untuk mengetahui cara penggunaan plugin custom Actudent tersebut. Untuk panduan penggunaan View Parser selengkapnya dapat dilihat di halaman dokumentasi CodeIgniter 4 [berikut ini](https://codeigniter4.github.io/CodeIgniter4/outgoing/view_parser.html).

### Database Query
Semua query wajib menggunakan Query Builder dari CodeIgniter 4 untuk menjaga konsistensi sekaligus memudahkan proses maintenance. Panduan menggunakan Query Builder  dapat dilihat pada [halaman ini](https://codeigniter4.github.io/CodeIgniter4/database/query_builder.html).

### Per-page User Checking
Actudent menggunakan `Filter` dari CodeIgniter 4. Semua halaman Actudent diproteksi menggunakan filter ini. Berbeda dengan versi CodeIgniter 3 yang melakukan filter pada tiap class constructor, pada CodeIgniter 4 filter hanya dilakukan pada satu class yaitu `\Actudent\Admin\Filters\AdminFilter` untuk panel admin atau `\Actudent\Guru\Filters\GuruFilter` untuk panel guru. Sementara untuk kebutuhan validasi masa aktif layanan Actudent, terdapat filter khusus yaitu `\Actudent\Core\Filters\CoreFilter`.

### Style Guide
Aturan dalam penulisan kode mengikuti standar yang ditetapkan oleh CodeIgniter 4 yang dapat dilihat pada [halaman ini](https://github.com/codeigniter4/CodeIgniter4/blob/develop/contributing/styleguide.rst). Standar kode ini harus diikuti untuk menjaga konsistensi code base Actudent.

## Panduan Pengembangan di Sisi Client (Pengguna)
### Markup Language
HTML5 menjadi bahasa standar untuk menyusun tampilan web Actudent. Selengkapnya tentang HTML5 dapat dibaca pada [halaman ini](https://www.w3.org/TR/2011/WD-html5-20110405/).

### User Interface Framework
Template Actudent menggunakan Bootstrap sebagai frameworknya. Pengetahuan tentang Bootstrap sangat diperlukan untuk dapat menyusun komponen-komponen web serta interaksi pengguna Actudent. Dokumentasi lengkap Bootstrap dapat anda lihat di [sini](https://getbootstrap.com/docs/4.0/getting-started/introduction/).

### Scripting Language
Bahasa script yang digunakan adalah Javascript dengan standar ECMASCRIPT (ES) 6. Kontributor wajib memahami standar penulisan kode ES6 seperti `let`, `const`, `(arrowFunction) => {}`, `Promise`, ES Module dan lain-lain. Penggunaan ES6 dimaksudkan untuk memaksimalkan kemampuan Javascript dalam membangun web yang semakin kompleks. Untuk mengetahui fitur-fitur terbaru ES6 dapat anda lihat di [halaman ini](http://es6-features.org).

### Javascript Framework
Actudent menggunakan Vue.js sebagai framework Javascript-nya. Vue.js dipilih karena memiliki fitur yang lengkap, penulisan kode yang mudah dengan konsep <i>declarative rendering</i> serta performa yang tinggi. Panduan lengkap penggunaan Vue.js dapat anda lihat di [sini](https://vuejs.org/v2/guide/).

### Javascript Libraries
Template Actudent dibangun menggunakan jQuery sebagai library utamanya. Pengetahuan tentang jQuery sangat dibutuhkan agar dapat mengintegrasikan framework utama Vue.js dan library UI yang sebagian besar menggunakan jQuery.