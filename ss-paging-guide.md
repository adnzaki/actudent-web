# SSPaging - Simple and Smart Pagination Library
<i>SSPaging adalah library untuk mengolah data pagination dari server yang sederhana namun mampu mengakomodir semua kebutuhan pagination.</i>

## Mengapa SSPaging?
SSPaging merupakan library pagination yang dikembangkan oleh engineer Wolestech sendiri dan telah digunakan oleh semua proyek aplikasi berbasis web milik Wolestech. Library ini memiliki API yang sederhana dan dapat diimplementasikan dengan mudah di manapun.

## SSPaging + Vuex
Di proyek Actudent-v2 ini kami hanya akan membahas cara penggunaan SSPaging secara khusus bersama Vuex sesuai dengan yang ada di dalam source code ini. Cara penggunaan SSPaging ini diasumsikan anda telah memahami cara kerja Vuex dan penerapannya dalam source code Actudent-v2.

## Import SSPaging
SSPaging dapat diimpor melalui `import { SSPaging as paging } from '../shared/ss-paging'`. Setelah itu masukkan modul SSPaging ke dalam Vuex module: `modules: { paging }`. Pastikan Vuex module anda berada dalam mode namespace yang aktif dengan menambahkan opsi `namespaced: true`.

## Inisialisasi
Untuk inisialisasi SSPaging, dapat menggunakan method `dispatch` dari Vuex. Secara default, SSPaging menggunakan 10 baris sebagai nilai default untuk tampilan data per halaman. Jika anda menginginkan nilai selain itu, maka anda harus memutasikannya terlebih dahulu. Berikut adalah penerapan SSPaging pada halaman data siswa dengan limit 25 data per halaman:
```
const limit = 25
state.paging.rows = limit

dispatch('getData', {
  token: bearerToken,
  lang: pengguna.value.user_language,
  limit,
  offset: 0,
  orderBy: 'student_name',
  searchBy: [
    'student_nis', 'student_name'
  ],
  sort: 'ASC',
  where: null,
  search: '',
  url: `${conf.adminAPI}siswa/get-siswa/`,
  autoReset: {
    active: true,
    timeout: 500
  },
  delay: {
    active: true,
    timeout: 300
  }
})
```
Seperti yang terlihat pada kode di atas, anda tidak perlu menuliskan URL API secara utuh karena SSPaging akan men-generate URL tersebut di belakang layar berdasarkan opsi yang anda masukkan saat inisialisasi.

## Available `getData()` options
```
getData({
  token: String,
  lang: String,
  limit: Number,
  offset: Number,
  orderBy: String,
  searchBy: String|Array,
  sort: String,
  where: Null|String,
  search: String,
  url: String,
  autoReset: {
    active: Boolean,
    timeout: Number
  },
  delay: {
    active: Boolean,
    timeout: Number
  }
})
```

## URL Splitting
Pada dasarnya, SSPaging membutuhkan URL dengan format sebagai berikut untuk bisa berjalan: `domain.com/{controller}/{method}/limit/offset/orderBy/searchBy/sort/whereClause/search`. Maka itu, pastikan API anda telah memenuhi kebutuhan format tersebut agar SSPaging dapat berjalan. Sementara untuk inisialisasi, anda cukup memasukkan bagian `domain.com/{controller}/{method}` saja, dan parameter yang lainnya akan diambil dari opsi pada saat inisialisasi.

## Akses API
API SSPaging dapat diakses melalui Vuex module anda. Misalnya untuk mengakses SSPaging untuk halaman siswa di dalam Vue component, anda dapat menggunakan `store.state.student.{stateName}`. Untuk mengakses action yang ada di SSPaging, cukup dengan `store.dispatch('student/{actionName})`. API yang biasa diakses untuk bekerja dengan SSPaging adalah:<br>
### `State`
- `data` - tempat menampung response yang dihasilkan dari server.
- `pageLinks` - tempat menampung nomor halaman (1,2,3, dst.)

### `Actions`
- `onSearchChanged()` - event yang dipanggil ketika parameter pencarian berubah
- `nav(page: int)` - method untuk melakukan navigasi halaman
- `filter()` - method untuk menyaring data berdasarkan parameter pencarian
- `reloadData()` - method untuk merefresh data jika terjadi perubahan di halaman lain
- `sortData(orderBy: string)` - method untuk melakukan sorting data
- `showPerPage()` - method untuk menampilkan data berdasarkan jumlah yang diminta pengguna
- `runPaging()` - method yang digunakan untuk menjalankan kembali pagination dengan opsi yang sudah diinisialisasi. Method ini biasa dipanggil setelah menambah, mengedit atau menghapus data.
- `getData(options: object)` - method yang dipanggil saat pertama kali inisialisasi SSPaging

### `Getters`
- `rowRange` - menampilkan rentang data pada halaman aktif pagination
- `itemNumber(index: int)` - menampilkan nomor urut untuk setiap baris data pagination berdasarkan argumen index yang didapat dari key index setiap baris data tersebut

## Ready-to-use Components
Di Actudent-v2, kami menyediakan komponen siap pakai untuk dapat digunakan di semua komponen Actudent. Komponen ini telah diregister saat proses booting aplikasi, sehingga anda tidak perlu mengimpor komponen tersebut satu per satu, cukup dengan memanggil langsung dari dalam template Vue. Berikut adalah beberapa komponen siap pakai yang sudah tersedia di Actudent-v2:
### SSPaging
`SSPaging` merupakan komponen yang berfungsi untuk melakukan navigasi halaman serta menampilkan informasi tentang data yang ditampilkan. Komponen ini akan memanggil fungsi `nav()` di latar belakang untuk anda. Selain itu, komponen ini juga secara otomatis mengelola state `pageLinks` dari balik layar. Untuk memanggil komponen ini, anda hanya perlu menuliskan sebaris kode berikut:
```
<ss-paging vuex-module="namaVuexModule" />
```
### SearchBox
`SearchBox` berfungsi menjalankan fungsi pencarian berdasarkan kata kunci yang diberikan pengguna. Komponen ini akan mengakomodir pemanggilan fungsi `onSearchChanged()` dan `filter()` di latar belakang. `SearchBox` dapat dipanggil dengan menuliskan kode berikut:
```
<search-box label="Cari berdasarkan..." vuex-module="namaVuexModule" class="q-mt-sm" />
```
### RowDropdown
`RowDropdown` adalah komponen yang digunakan untuk memilih jumlah tampilan data per halaman. Opsi yang tersedia adalah 10, 25, 50, 100 dan 250. Dengan komponen ini, anda tidak perlu memanggil fungsi `showPerPage()` secara manual karena telah diselesaikan di latar belakang. Komponen ini dapat dipanggil dengan menuliskan kode berikut:
```
<row-dropdown vuex-module="namaVuexModule" class="q-mt-sm" root-class="col-12 col-md-2" />
```

## Sorting Data
API `sortData` biasanya diletakkan di bagian header pada table. Fungsi ini membutuhkan satu parameter yaitu nama kolom pada field database, misalnya `sortData('nama_field')`.

## Auto Reset dan Delay pada fungsi `filter()`
Anda dapat mengatur opsi `autoReset` untuk membuat SSPaging mereset hasil pencarian dan kembali ke tampilan data utama jika parameter pencarian kosong selama rentang waktu tertentu. Anda dapat mengaturnya pada saat inisialisasi melalui opsi berikut:
```
autoReset: {
  active: true,
  timeout: 500
}
```
Pengaturan di atas akan me-reset SSPaging jika parameter pencarian telah kosong selama 500 milidetik.<br>
Selain itu, anda juga dapat mengatur `delay` pada SSPaging yang berfungsi menunda eksekusi pencarian selama rentang waktu tertentu setelah pengguna menekan enter atau mensubmit pencarian. Anda dapat mengatur opsi ini ketika inisialisasi sebagai berikut:
```
delay: {
  active: true,
  timeout: 500
}
```
Dalam pengaturan di atas, SSPaging akan menunda eksekusi pencarian selama 500 milidetik sebelum dikirim ke server.

## Yang harus dihindari dari `getData()`
Fungsi `getData()` hanya boleh dipanggil satu kali, yaitu pada saat inisialisasi awal SSPaging. Setelah itu, jika anda perlu melakukan refresh data, gunakan fungsi `runPaging()` yang akan memuat ulang data berdasarkan opsi-opsi yang sebelumnya sudah diatur saat inisialisasi menggunakan `getData()`.

## Authorization
SSPaging menggunakan Bearer Token untuk proses otorisasi ke server. Untuk mendapatkan token tersebut, anda cukup mengimpornya dengan `import { bearerToken } from '../../composables/common'`.

## Informasi Tambahan
Secara keseluruhan, penggunaan SSPaging di dalam Vuex jauh lebih mudah dibandingkan menggunakannya sebagai mixins. Dengan Single-File Components, SSPaging juga dapat diakses lebih mudah dengan beberapa komponen siap pakai yang mampu menyelesaikan beberapa tugas utama dari balik layar, sehingga anda bahkan tidak perlu menyentuh API SSPaging secara langsung. Library ini akan terus diperbarui terutama untuk mendukung project Actudent-v2, namun untuk saat ini kontributor non-inti hanya diperkenankan menambah fitur SSPaging untuk project Actudent-v2 secara spesifik tanpa menyentuh core API dari SSPaging.