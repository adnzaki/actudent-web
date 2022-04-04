const indonesia = [
  {
    key: '[Perbaikan] Perbaikan bug tidak bisa login di browser berbasis Chromium',
    desc: `Memperbaiki bug tidak dapat login menggunakan browser berbasis Chromium seperti Chrome, Edge dan sebagainya
          pada build ac.v2.0029`
  },
  {
    key: '[Baru] Kehadiran',
    desc: `Fitur kehadiran siswa kini telah dapat digunakan dengan penambahan laporan rekap bulanan dan semester yang tidak ada di Actudent versi sebelumnya`
  },
  {
    key: '[Baru] Halaman Login',
    desc: `Halaman login kini menggunakan tampilan baru dan telah terintegrasi dengan mode PWA
           seperti halnya bagian inti aplikasi`
  },
  {
    key: '[Peningkatan] Pagination',
    desc: `Penomoran baris data pada pagination kini telah disesuaikan dengan 
           jumlah data keseluruhan`
  },
  {
    key: '[Peningkatan] Internasionalisasi (Bahasa)',
    desc: `Peningkatan mekanisme pemuatan bahasa - kini berjalan sepenuhnya di sisi client
           untuk meningkatkan performa aplikasi`
  },
  {
    key: '[Peningkatan] Tombol Kembali sub-halaman',
    desc: `Tombol kembali ke halaman utama pada sub-halaman kini lebih sederhana dan memakai ruang lebih sedikit`
  },
  {
    key: '[Perbaikan] Autentikasi',
    desc: `Perbaikan validasi token dan mekanisme pengalihan halaman yang tidak dapat diakses`
  },
  {
    key: '[Perbaikan] Filter kelas siswa',
    desc: `Memperbaiki bug filter kelas tidak dapat memperbarui tabel siswa`
  },
  {
    key: '[Perbaikan] Tombol hapus sekaligus',
    desc: `Memperbaiki bug tombol hapus beberapa siswa tidak bekerja`
  },
]

const english = [
  {
    key: '[Fix] Fix bug unable to login on Chromium-based browser',
    desc: `Fix bug unable to login using Chromium-based browser like Chrome, Edge, etc. on build ac.v2.0029`
  },
  {
    key: '[New] Presence',
    desc: `Presence feature now able to used that comes with additional monthly and period report which have not been in the previous version of Actudent`
  },
  {
    key: '[New] Login Page',
    desc: `Login page now uses new interface dan has been integrated with PWA mode like the app's core`
  },
  {
    key: '[Improvement] Pagination',
    desc: `Data rows numbering on pagination has currently been matched with
           with whole data`
  },
  {
    key: '[Improvement] Internationalization (Language)',
    desc: `Improved language loading mechanism - now is fully running on client side to improve
           app performance`
  },
  {
    key: '[Improvement] Sub-page back button',
    desc: `Sub-page back button now becomes more simple and uses less space`
  },
  {
    key: '[Fix] Authentication',
    desc: `Fixed token validation and redirect mechanism of pages that are not allowed to be accessed`
  },
  {
    key: '[Fix] Student class selector',
    desc: `Fixed bug class selector cannot update the student table`
  },
  {
    key: '[Fix] Multiple delete button',
    desc: `Fixed bug multiple delete button not working`
  },
]

export { indonesia, english } 