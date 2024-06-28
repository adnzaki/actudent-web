# Panduan Untuk Kontribusi Dalam Project Actudent (Web Version only)
<i>Panduan ini hanya diperuntukkan untuk developer Actudent</i>

## Panduan Umum
### Engines
- Minimum PHP Version: 8.1
- API Framework : CodeIgniter 4.5.0
- UI Framework : Quasar v2.15.1
- Javascript Framework : Vue 3.4.21
- Database : MySQL (MySQLi Driver)

### Struktur Folder Utama
- `api` <br>
Folder tempat menyimpan source code API dari CodeIgniter 4.
- `app` <br>
Folder tempat menyimpan user interface yang sudah dibuild beserta source codenya.

### Indentasi
Kami menggunakan jarak indentasi sebanyak 2 spasi untuk semua source code dalam folder `app/ui-src` dan 4 spasi untuk folder `api`. Untuk bisa menggunakan dua pengaturan ini, anda harus menyimpan pengaturan indentasi yang berbeda pada workspace code editor anda. Dalam hal ini, pengembangan API dan antarmuka aplikasi dibagi dalam workspace yang berbeda.

## Panduan Pengembangan di Sisi Server
### Struktur folder API
- `actudent`<br>
Root folder untuk semua modul Actudent. Modul-modul tersebut adalah `Admin`, `Core`, `Guru`, `Installer`, `Mobile` dan `Sync`.
- `app`<br>
Folder aplikasi default dari CodeIgniter, digunakan untuk menyimpan global config dan locale resource
- `public`<br>
Folder tempat menyimpan file-file publik seperti file yang diupload, termasuk `index.php`
- `queries` <br>
Tempat menyimpan backup database berupa file `.sql`
- `system` <br>
File sistem CodeIgniter, tidak boleh dimodifikasi.
- `writable` <br>
Tempat menyimpan logs, session, cache dan file yang diupload
### Modularisasi
Basis API Actudent menggunakan konsep [modularisasi](https://en.wikipedia.org/wiki/Hierarchical_model%E2%80%93view%E2%80%93controller) untuk memudahkan development dan maintenance aplikasi. Konsep ini dipilih karena memungkinkan Actudent dibagi ke dalam beberapa sub-sistem, seperti panel Admin, Guru, dan lain-lain.

### Struktur Modul
- `Admin`
Tempat menyimpan kode sumber modul Admin. Semua kode yang spesifik hanya untuk Admin harus disimpan di dalam modul ini.
- `Core`
Merupakan tempat menyimpan shared classes atau class inti yang dipakai oleh beberapa modul.
- `Guru`
Merupakan tempat menyimpan kode sumber modul Guru.
- `Installer`
Tempat menyimpan kode sumber setup/instalasi Actudent.
- `Mobile`
Tempat menyimpan kode sumber API untuk versi mobile (Android).
- `Sync`
Tempat menyimpan kode sumber <b>Sync API</b>.

### Core Controller
`Actudent` merupakan core controller yang wajib ada di semua controller Actudent. Tanpa class ini, Actudent tidak akan dapat berjalan sebagaimana mestinya. Hanya kontributor inti yang diperkenankan memodifikasi class ini. Meski berada dalam namespace `Actudent\Core\Controllers`, class ini hanya perlu dipanggil dengan `\Actudent`.

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
use Actudent\Core\Models\Connector;
$conn = new Connector;
```

### Database Query
Semua query wajib menggunakan Query Builder dari CodeIgniter 4 untuk menjaga konsistensi sekaligus memudahkan proses maintenance. Panduan menggunakan Query Builder  dapat dilihat pada [halaman ini](https://codeigniter.com/user_guide/database/query_builder.html).

### Authentication System (New in v2)
Actudent menggunakan JSON Web Tokens (JWT) untuk sistem autentikasi terbarunya. Hal ini dilakukan untuk mendukung konsep "One-for-All API" agar nantinya API dari aplikasi web Actudent dapat digunakan oleh berbagai platform. Penggunaan JWT juga untuk menggantikan session yang tidak mendukung cross-origin authentication dikarenakan pengembangan user interface Actudent saat ini menggunakan Node.js. Cara penggunaan JWT pada Actudent V2 dapat dilihat pada bagian berikutnya panduan ini.

### Validator (New in v2)
Actudent tidak lagi menggunakan filter dari CodeIgniter4. Tersedia 3 tipe validator untuk melakukan pengecekan layaknya session dalam versi 1.x yaitu `is_admin()` untuk mengecek apakah user yang sedang login memiliki akses sebagai Administrator, `is_teacher()` untuk mengecek apakah user yang sedang login memiliki akses sebagai Guru dan `valid_token()` untuk memberikan akses bagi user yang bertindak baik sebagai Admin maupun Guru selama memiliki token yang valid. Anda juga dapat mengambil Bearer Token yang dikirim oleh client dengan fungsi `bearer_token()`. Semua fungsi tersebut dapat dipanggil dari file manapun karena telah dimuat secara otomatis melalui core controller Actudent.

### Response Creator (New in v2)
Actudent menggunakan method baru dari core controller untuk mengirim response berupa JSON ke user interface yaitu `createResponse()`. Method ini memiliki 2 parameter, yang pertama adalah data yang ingin dikirim berupa PHP Array/Object dan parameter kedua adalah validator. Jika parameter kedua dikosongkan, maka akan menggunakan `valid_token` sebagai validator default. Contoh pemanggilan fungsi ini adalah: `$this->createResponse($response, 'is_admin')` untuk mengirim response yang hanya bisa diakses oleh Administrator.

### Running Validation (New in v2)
Karena penggunaan custom database group di versi terbaru ini, penggunaan method turunan `$this->validateData()` digantikan oleh helper `$this->validateForms()`. Cara penggunaan helper ini sama persis dengan `$this->validateData()` bawaan CodeIgniter, hanya saja di belakang layarnya sudah menggunakan custom DB Group terbaru dari Actudent.

## Panduan Pengembangan di Sisi Client (User Interface)
Antarmuka pengguna menjadi perubahan terbesar dari versi terbaru Actudent. Untuk memulai eksplorasi kode sumber antarmuka  Actudent, silakan buka folder `app/ui-src`. Berikut adalah penjelasan tentang cara berkontribusi untuk antarmuka terbaru Actudent.

### User Interface Framework
Actudent V2 menggunakan [Quasar](https://quasar.dev/) sebagai framework untuk membangun user interfacenya. Saat ini Actudent menggunakan Quasar versi 2.15.1 yang dibangun di atas Vue 3.4.21. Pastikan anda memahami versi terbaru Vue.js sebelum terjun langsung ke dalam pengembangan. 

### Advanced Vue.js
Pengembangan antarmuka pengguna Actudent V2 menggunakan seluruh kemampuan terbaik Vue.js dalam membangun user interface mencakup [Single-File Components (SFC)](https://vuejs.org/guide/scaling-up/sfc.html#single-file-components), [Composition API](https://vuejs.org/api/composition-api-setup.html), [Vue Router](https://router.vuejs.org/) serta [Pinia](https://pinia.vuejs.org/). Untuk development servernya sendiri kini menggunakan [Vite](https://vitejs.dev/). Pastikan anda telah memahami cara menggunakan Vue.js sebagai sebuah framework utuh bukan hanya sebagai library Javascript.

### Composition API
[Composition API](https://vuejs.org/api/composition-api-setup.html) merupakan fitur terbaru dari Vue 3 sebagai versi lebih yang lebih baik dari Options API untuk digunakan dalam Single-File Components. Walaupun Options API tetap dapat digunakan di Vue 3, namun Composition API menjanjikan manajemen code base yang lebih baik. 

### Axios
Actudent V2 menggunakan [Axios](https://github.com/axios/axios) untuk mengelola HTTP Request/Response. Axios dalam Actudent V2 telah disederhanakan penggunaannya, namun pastikan anda memahami cara penggunaan Axios secara lengkap.

### Pagination Library
Actudent tetap mempertahankan [SSPaging](https://lib.actudent.com/ss-paging/) sebagai library untuk mengelola pagination berbasis server. Library ini dikembangkan langsung oleh engineer Actudent sehingga memiliki integrasi yang sangat baik.

### Internationalization
Actudent menggunakan library [vue-i18n](https://vue-i18n.intlify.dev/) sebagai library untuk mengelola bahasa. Di Actudent V2, kami tetap mempertahankan pengelolaan utama bahasa di sisi server untuk kemudian diregistrasi pada sisi pengguna melalui booting Quasar app. 

### Global Configuration for User Interface
Actudent memiliki sebuah file bernama `globalConfig.js` yang berisi pengaturan inti untuk antarmuka aplikasi. File tersebut terdapat pada `app/ui-src/globalConfig.js`, silakan buka dan baca dengan baik petunjuk yang ada di dalam file tersebut untuk dapat menjalankan Actudent di server lokal ataupun mendeploy ke cloud hosting/production server.

### Struktur Folder User Interface
Folder untuk pengembangan user interface Actudent V2 terdapat di `app/ui-src`, berikutnya strukturnya:
- `.quasar`
Folder yang dibuat otomatis oleh Quasar Framework, bagian ini tidak perlu dimodifikasi.
- `.vscode`
Tempat menyimpan beberapa pengaturan VSCode.
- `dist`
Folder yang dibuat otomatis oleh Quasar untuk menyimpan file-file user interface yang sudah di-build dan siap untuk dideploy ke production.
- `node_modules`
Tempat menyimpan dependency Quasar dan Vue, dibuat otomatis oleh NPM.
- `public`
Tempat menyimpan file-file aset yang dapat diakses secara public seperti icon, gambar, dan sebagainya.
- `src`
Folder utama dari source code user interface Actudent.
- `src-pwa`
Folder yang dibuat otomatis oleh Quasar CLI untuk membuat Actudent berada dalam mode PWA (Progressive Web Apps).

### Konfigurasi
Terdapat 2 file konfigurasi di dalam Actudent, yang pertama adalah `quasar.conf.js` yang merupakan file konfigurasi untuk Quasar Framework dan yang kedua adalah `actudent.config.js` yang merupakan konfigurasi khusus untuk Actudent. Silakan berdiskusi dengan kontributor inti jika anda ingin mengubah beberapa konfigurasi di dalam kedua file tersebut.

### Struktur Folder Utama `src`
- `assets`
Tempat menyimpan file-file aset seperti icon dan gambar-gambar.
- `boot`
Tempat menyimpan file-file JS yang akan dipanggil pertama kali ketika aplikasi booting.
- `components`
Tempat menyimpan reusable components yang dapat dipanggil dari component utama
- `composables`
Tempat menyimpan file JS yang dapat di-inject ke dalam Composition API
- `css`
Tempat menyimpan file custom css.
- `i18n`
Tempat menyimpan file-file bahasa yang diambil dari server
- `layouts`
Tempat menyimpan layout utama user interface seperti header dan menu
- `mixins`
Tempat menyimpan module JS yang akan dijadikan mixins di dalam component utama
- `pages`
Tempat menyimpan halaman-halaman user interface. Misal: halaman <i>Kehadiran</i> disimpan di `pages/kehadiran`
- `pages_teacher`
Tempat menyimpan halaman-halaman user interface khusus untuk ruang lingkup guru saja. 
- `router`
Tempat menyimpan konfigurasi routing Single-Page App.
- `stores`
Tempat menyimpan file-file state management (Pinia)

### NPM and CLI Tools
NPM adalah software utama yang harus terinstal di komputer anda. Sebelum menginstall NPM, pastikan Node.js telah lebih dulu terpasang di komputer anda. Dengan NPM inilah anda dapat mengelola dependency yang ada dalam source code user interface Actudent mulai dari menginstal, mengupdate hingga menghapusnya. Anda diharuskan memahami penggunaan Command-Line Interface (CLI) dalam pengembangan antarmuka Actudent karena Quasar Framework bergantung pada CLI dalam penggunaannya, mulai dari menjalankan antarmuka di web server Node.js, membuat build-version untuk user interface agar dapat digunakan di production server, hingga menjaga konsistensi code base dengan ESLint dan lain-lain.