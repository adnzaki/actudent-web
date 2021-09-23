<template>
  <q-card class="my-card q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize">Riwayat Pembaruan</div>
      <div class="row q-mt-md">
        <p>Pembaruan yang terdapat dalam build saat ini ({{ buildVersion }}):
          <ul>
            <li v-for="(item, index) in updates" :key="index">
              <strong>{{ item.key }} - </strong>{{ item.desc }}                 
            </li>
          </ul>
        </p>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
export default {
  name: 'Updates',
  setup () {
    const updates = [
      {
        key: 'Menu Ruangan',
        desc: `Di build terbaru ini kami telah menambahkan menu ruangan untuk 
               mengelola data ruang`
      },
      {
        key: 'Perbaikan Algoritma Penambahan Ruang',
        desc: `Di Actudent-v2, kini pengguna bisa menambahkan ruang baru menggunakan kode ruang
               dari ruangan yang sebelumnya telah dihapus`
      },
      {
        key: 'Perbaikan pagination',
        desc: `Memperbaiki bug pagination tidak dapat menampilkan rentang data 
               ketika pengguna melakukan full reload`
      },
      {
        key: 'Pembaruan sistem',
        desc: `Memperbarui framework CodeIgniter ke versi 4.1.4`
      },
      {
        key: 'Perbaikan dan peningkatan aplikasi',
        desc: `Perbaikan pada basis kode Actudent-v2 untuk meningkatkan performa aplikasi
               dan memperbaiki kesalahan-kesalahan kecil pada sistem`
      }
    ]

    return {
      updates
    }
  }
}
</script>
