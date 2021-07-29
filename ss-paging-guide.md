# SSPaging - Simple and Smart Pagination Library
<i>SSPaging adalah library untuk mengolah data pagination dari server yang sederhana namun mampu mengakomodir semua kebutuhan pagination.</i>

## Mengapa SSPaging?
SSPaging merupakan library pagination yang dikembangkan oleh engineer Wolestech sendiri dan telah digunakan oleh semua proyek aplikasi berbasis web milik Wolestech. Library ini memiliki API yang sederhana dan dapat diimplementasikan dengan mudah di manapun.

## SSPaging + Vuex
Di proyek Actudent-v2 ini kami hanya akan membahas cara penggunaan SSPaging secara khusus bersama Vuex sesuai dengan yang ada di dalam source code ini. Cara penggunaan SSPaging ini diasumsikan anda telah memahami cara kerja Vuex dan penerapannya dalam source code Actudent-v2.

## Import SSPaging
SSPaging dapat diimpor melalui `import { SSPaging as paging } from '../shared/ss-paging'`. Setelah itu masukkan modul SSPaging ke dalam Vuex module: `modules: { paging }`. Pastikan Vuex anda berada dalam mode namespace yang aktif dengan menambahkan opsi `namespaced: true`.

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
})
```
Seperti yang terlihat pada kode di atas, anda tidak perlu menuliskan URL API secara utuh karena SSPaging akan men-generate URL tersebut di belakang layar berdasarkan opsi yang anda masukkan saat inisialisasi.

## URL Splitting
Pada dasarnya, SSPaging membutuhkan URL dengan format sebagai berikut untuk bisa berjalan: `domain/controller/method/limit/offset/orderBy/searchBy/sort/whereClause/search`. Maka itu, pastikan API anda telah memenuhi kebutuhan format tersebut agar SSPaging dapat berjalan. Sementara untuk inisialisasi, anda cukup memasukkan bagian `domain/controller/method` saja, dan parameter yang lainnya akan diambil dari opsi pada saat inisialisasi.

## Update Pagination di Quasar pagination
Untuk menyesuaikan dengan Quasar pagination component, diperlukan tambahan action sebagai berikut:
```
onPaginationUpdate({ state, dispatch }) {
  if(Cookies.has(conf.cookieName)) {
    dispatch('nav', state.current - 1)
  } else {
    errorNotif()
  }
}
```
Kemudian tambahkan action tersebut pada Quasar component `@update:model-value="onPaginationUpdate"`. Seperti yang anda lihat, action tersebut akan mengeksekusi method `nav()` milik SSPaging yang biasa digunakan untuk melakukan navigasi halaman pada tabel.

## Akses API
API SSPaging dapat diakses melalui Vuex module anda. Misalnya untuk mengakses SSPaging untuk halaman siswa di dalam Vue component, anda dapat menggunakan `store.state.student.{stateName}`. Untuk mengakses action yang ada di SSPaging, cukup dengan `store.dispatch('student/{actionName})`. API yang biasa diakses untuk bekerja dengan SSPaging adalah:<br>
### `State`
- `data` - tempat menampung response yang dihasilkan dari server.
- `pageLinks` - jumlah halaman yang dibutuhkan untuk menampung data

### `Actions`
- `onSearchChanged` - event yang dipanggil ketika parameter pencarian berubah
- `nav` - method untuk melakukan navigasi halaman
- `filter` - method untuk menyaring data berdasarkan parameter pencarian
- `reloadData` - method untuk merefresh data jika terjadi perubahan di halaman lain
- `sortData` - method untuk melakukan sorting data
- `showPerPage` - method untuk menampilkan data berdasarkan jumlah yang diminta pengguna
- `runPaging` - method yang digunakan untuk menjalankan kembali pagination dengan opsi yang sudah diinisialisasi. Method ini biasa dipanggil setelah menambah, mengedit atau menghapus data.
- `getData` - method yang dipanggil saat pertama kali inisialisasi SSPaging