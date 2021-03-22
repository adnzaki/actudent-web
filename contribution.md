# Panduan Untuk Kontribusi Dalam Project Actudent (Web Version only)
<i>Panduan ini hanya diperuntukkan untuk developer Actudent</i>

## Panduan Umum
### Engines
- Server-side Language : PHP 7.4
- Web Framework : CodeIgniter 4.0.4
- UI Framework : Quasar v2.0.0-beta.9 (based on Vue 3)
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
- `Installer`
Tempat menyimpan kode sumber setup/instalasi Actudent 
- `UITest`
Tempat menyimpan kode sumber untuk keperluan test interaksi user interface dengan API

### Core Controller
`Actudent` merupakan core controller yang wajib ada di semua controller Actudent. Tanpa class ini, Actudent tidak akan dapat berjalan sebagaimana mestinya. Hanya kontributor inti yang diperkenankan memodifikasi class ini. Class ini tersedia dengan namespace `Actudet\Core\Controllers\Actudent`.

### Database Connector
Actudent tidak menggunakan model bawaan CodeIgniter4, sementara untuk koneksi databasenya, Actudent
memiliki sebuah class `Connector` yang tersedia dengan namespace `Actudent\Core\Models\Connector`.
Setiap model Actudent harus mengextend class ini agar dapat berinteraksi dengan database.

### Admin's shared model
Tersedia sebuah shared class model yaitu `SharedModel` yang dapat dipanggil via `Actudent\Admin\Models\SharedModel`. Model ini menyediakan beberapa tabel yang sering digunakan oleh model-model lain. Karena class ini memiliki cukup banyak properti, disarankan hanya menggunakan class ini jika anda membutuhkannya.

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

### Authentication System (New in v2)
Actudent menggunakan JSON Web Tokens (JWT) untuk sistem autentikasi terbarunya. Hal ini dilakukan untuk mendukung konsep "One-for-All API" agar nantinya API dari aplikasi web Actudent dapat digunakan oleh berbagai platform. Penggunaan JWT juga untuk menggantikan session yang tidak mendukung cross-origin authentication dikarenakan pengembangan user interface Actudent saat ini menggunakan Node.js. Cara penggunaan JWT pada Actudent v2 dapat dilihat pada bagian berikutnya panduan ini.

### Validator (New in v2)
Actudent tidak lagi menggunakan filter dari CodeIgniter4. Tersedia 3 tipe validator untuk melakukan pengecekan layaknya session dalam versi 1.x yaitu `is_admin()` untuk mengecek apakah user yang sedang login memiliki akses sebagai Administrator, `is_teacher()` untuk mengecek apakah user yang sedang login memiliki akses sebagai Guru dan `valid_token()` untuk memberikan akses bagi user yang bertindak baik sebagai Admin maupun Guru selama memiliki token yang valid. Ketiga fungsi tersebut dapat dipanggil dari file manapun karena telah dimuat secara otomatis melalui `wolesdev_helper`.

### Response Creator (New in v2)
Actudent menggunakan method baru dari core controller untuk mengirim response berupa JSON ke user interface yaitu `createResponse()`. Method ini memiliki 2 parameter, yang pertama adalah data yang ingin dikirim berupa PHP Array/Object dan parameter kedua adalah validator. Jika parameter kedua dikosongkan, maka akan menggunakan `valid_token` sebagai validator default. Contoh pemanggilan class ini adalah: `$this->createResponse($response, 'is_admin')` untuk mengirim response yang hanya bisa diakses oleh Administrator.

### Style Guide
Aturan dalam penulisan kode mengikuti standar yang ditetapkan oleh CodeIgniter 4 yang dapat dilihat pada [halaman ini](https://github.com/codeigniter4/CodeIgniter4/blob/develop/contributing/styleguide.rst). Standar kode ini harus diikuti untuk menjaga konsistensi code base Actudent.

## Panduan Pengembangan di Sisi Client (Pengguna)
Antarmuka pengguna menjadi perubahan terbesar dari versi terbaru Actudent. Tampilan lama hanya menyisakan halaman login dan instalasi, sementara di bagian dalamnya ditulis ulang menggunakan Quasar Framework. Untuk memulai eksplorasi kode sumber antarmuka  Actudent, silakan buka di `public/ui`. Berikut adalah penjelasan tentang cara berkontribusi untuk antarmuka terbaru Actudent.

### User Interface Framework
Actudent v2 menggunakan [Quasar](https://quasar.dev/) sebagai framework untuk membangun user interfacenya. Saat ini Actudent menggunakan Quasar versi 2.0.0-beta.9 yang dibangun di atas Vue 3.0. Pastikan anda memahami versi terbaru Vue.js sebelum terjun langsung ke dalam pengembangan. Untuk penggunaan Quasar versi terbaru dapat anda baca di halaman [ini](https://next.quasar.dev/introduction-to-quasar).

### Advanced Vue.js
Pengembangan antarmuka pengguna Actudent v2 menggunakan seluruh kemampuan terbaik Vue.js dalam membangun user interface mencakup Single-File Components (SFC), Composition API, Vue Router dan lain-lain. Pastikan anda telah memahami cara menggunakan Vue.js sebagai sebuah framework utuh bukan hanya sebagai progressive-library.

### NPM and CLI Tools
NPM adalah software utama yang harus terinstal di komputer anda. Dengan NPM inilah anda dapat mengelola dependency yang ada dalam source code user interface ini mulai dari menginstal, mengupdate hingga menghapusnya. Anda diharuskan memahami penggunaan Command-Line Interface (CLI) dalam pengembangan antarmuka Actudent. Namun di balik NPM dan CLI tools di dalamnya terdapat Node.js yang tentu harus lebih dulu terpasang di komputer anda.

### About jQuery and Bootstrap
Sayangnya Actudent hampir tidak bisa mempertahankan penggunaan kedua framework tersebut di v2. Bootstrap mungkin masih tersisa di halaman instalasi dan login, tapi jQuery tidak mendapat tempat lagi di manapun. Kami mencoba membangun sebuah antarmuka pengguna yang jauh lebih modern dengan software yang juga lebih modern, semuanya agar kualitas versi terbaru Actudent ada di performa terbaiknya.