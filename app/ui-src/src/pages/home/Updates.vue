<template>
  <q-card class="my-card q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize">Riwayat Pembaruan</div>
      <div class="row q-mt-md">
        <p>Pembaruan yang terdapat dalam build saat ini (ac.v2.0022):
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
        key: 'Menu Kelas',
        desc: 'Di build terbaru ini kami telah menambahkan menu kelas untuk mengelola rombongan belajar'
      },
      {
        key: 'Pembaruan sistem translasi',
        desc: `Sistem translasi bahasa Indonesia dan Inggris telah ditulis ulang menggunakan
               plugin vue-i18n dengan metode one-time loading pada saat pengguna melakukan 
               full-reload, sehingga performa aplikasi menjadi jauh lebih cepat.`
      },
      {
        key: 'Menambahkan fungsi logout',
        desc: 'Sub-menu logout pada menu Akun telah diaktifkan'
      },
      {
        key: 'Perbaikan teks/kalimat',
        desc: `Beberapa kalimat/teks yang tidak sesuai antara 
               bahasa Indonesia dan Inggris kini telah diperbaiki`
      }
    ]

    return {
      updates
    }
  }
}
</script>
