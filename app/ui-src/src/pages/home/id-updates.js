export default {
  'beta-2.ac.v2.0044': [
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki ikon jurnal yang salah pada tampilan mobile'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki pesan error yang masih muncul setelah simpan data berhasil pada sebagian form'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki kesalahan warna dan background teks nama hari di kalendar agenda pada saat dark mode aktif'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki kesalahan menampilkan tanggal pada beberapa komponen pemilih tanggal (datepicker)'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki tombol kembali yg hilang pada halaman rekap kehadiran siswa di panel admin '
    },
    {
      key: 'Peningkatan-Internal]',
      desc: 'Memuat tahun secara dinamis untuk selector bulan dan periode'
    },
    {
      key: '[Peningkatan]',
      desc: 'Memperbaiki tampilan selector bulan dan tahun untuk rekap absensi siswa di layar tablet'
    },
    {
      key: '[Peningkatan]',
      desc: 'Menyeleraskan ukuran tombol "Tampilkan" rekap kehadiran dengan selector bulan'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki tombol Hapus agenda yang masih muncul di Form Tambah Agenda '
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki jumlah baris pagination yang kembali ke default setelah simpan data'
    },
    {
      key: '[Perbaikan]',
      desc: 'Memperbaiki bug guru tidak bisa mengakses menu agenda di versi lain Actudent (extensions)'
    },
    {
      key: '[Peningkatan]',
      desc: 'Memperbaiki notifikasi progress menyimpan data yang hilang sebelum proses berakhir'
    },
  ],
  'beta-1.ac.v2.0043': [
    {
      key: '[Baru] Agenda',
      desc: 'Menambahkan fitur agenda'
    },
    {
      key: '[Peningkatan] Halaman login',
      desc: 'Menyesuaikan style UI halaman login pada perangkat mobile dan tablet'
    }
  ],
  'alpha-2.ac.v2.0040': [
    {
      key: '[Baru] Menu khusus laporan untuk wali kelas',
      desc: 'Fitur cetak laporan kini memiliki menu khusus untuk guru yang berstatus sebagai wali kelas'
    },
    {
      key: '[Perbaikan] Menu cetak laporan untuk admin',
      desc: 'Mengembalikan menu cetak laporan harian untuk admin'
    }
  ],
  'alpha-1.ac.v2.0038': [
    {
      key: '[Baru] Jadwal dan Pelajaran untuk Guru',
      desc: 'Menambahkan akses guru disertai fitur jadwal mengajar dan kehadiran siswa'
    },
    {
      key: '[Perbaikan] Bug pada cetak/download PDF',
      desc: 'Memperbaiki masalah pada saat mencetak/download laporan PDF'
    },
    {
      key: '[Perbaikan] Bug pada komponen dropdown',
      desc: 'Memperbaiki bug gagal memuat opsi default dropdown pada form edit'
    }
  ],
  'ac.v2.0033': [
    {
      key: '[Peningkatan] Komponen Dropdown',
      desc: `Komponen pencarian dropdown kini menggunakan metode asynchronous yang lebih cepat minim bug`
    },
    {
      key: '[Peningkatan] Tabel rekapitulasi bulanan',
      desc: 'Tampilan tabel rekapitulasi absen bulanan kini telah disesuaikan untuk pengguna mobile'
    },
    {
      key: '[Perbaikan] Bug hak ases pengguna (Admin atau Guru)',
      desc: 'Memperbaiki bug gagal memuat jadwal pelajaran pada kehadiran siswa'
    },
    {
      key: '[Perbaikan] Bug komponen dropdown',
      desc: `Memperbaiki tidak adanya nilai default komponen dropdown saat memasuki halaman baru`
    }
  ],
  'ac.v2.0030': [
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
    }
  ],
  'ac.v2.0027': [
    {
      key: '[Baru] Jadwal Pelajaran',
      desc: `Fitur pengelolaan jadwal pelajaran kini telah ditambahkan`
    },
    {
      key: '[Baru] Sync API',
      desc: `Actudent kini dilengkapi Sync API untuk melakukan penarikan 
            data dari aplikasi Dapodik`
    },
    {
      key: 'Pagination',
      desc: `SSPaging kini memuat halaman yang terakhir kali dipilih
            saat pemuatan halaman pertama kali`
    },
    {
      key: 'Perbaikan tampilan data orang tua',
      desc: `Tampilan default jumlah baris per halaman pada SSPaging kini menjadi
             25 baris per halaman`
    },
    {
      key: 'Perbaikan form tambah kelas baru',
      desc: `Dropdown untuk pencarian guru kini menggunakan komponen baru
             yang lebih sederhana.`
    },
    {
      key: 'Perbaikan pencarian guru',
      desc: `Perbaikan daftar guru yang ditampilkan pada dropdown masih
             menampilkan pegawai selain guru (staff)`
    },
    {
      key: 'Perubahan ukuran form',
      desc: `Modal form kini tidak lagi menggunakan layar penuh untuk perangkat mobile`
    }
  ],
  'ac.v2.0024': [
    {
      key: 'Status Layanan',
      desc: `Perbaikan tampilan multi-line teks yang tidak terbaca pada 
             peringatan status layanan segera berakhir`
    },
    {
      key: 'Mata Pelajaran',
      desc: `Menambahkan fitur Mata Pelajaran untuk mengelola daftar mata pelajaran
             yang tersedia di sekolah`
    },
    {
      key: 'Perbaikan Pagination',
      desc: `Memperbaiki bug halaman saat ini tidak terupdate setelah menghapus data`
    },
    {
      key: 'Beranda',
      desc: `Menambahkan informasi riwayat pembaruan sebelumnya`
    },
    {
      key: 'Informasi Pembaruan',
      desc: `Informasi pembaruan kini tersedia dalam bahasa Indonesia dan Inggris`
    },
  ],
}