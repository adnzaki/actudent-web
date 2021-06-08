<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">Selamat datang di Actudent-v2</div>
        <div class="row q-mt-md">
          <p>Aplikasi ini merupakan pengembangan dari Actudent-v1 yang mengusung Progressive Web Apps.
            Beberapa keunggulan utama dari versi terbaru ini dibanding pendahulunya
            diantaranya sebagai berikut:
            <ul>
              <li v-for="(item, index) in pros" :key="index">
                <strong>{{ item.key }} - </strong>{{ item.desc }}                 
              </li>
            </ul>
            Aplikasi ini masih dalam tahap awal pengembangan. Untuk saat ini menu yang sudah terbuka
            hanya Beranda dan Data > Orang Tua (terbatas pada menampilkan dan menambahkan data).
          </p>
          <p>Informasi tentang pengembangan Actudent-v2 dapat anda simak melalui blog resmi Actudent
            <strong><a href="https://actudent.com/blogs/">di sini.</a></strong></p>
        </div>
      </q-card-section>
      <add-parent-form :lang="lang" />
      <parent-table :lang="lang" />
    </q-card>
  </div>
</template>

<script>
import locale from '../../mixins/fetch-lang'

export default {
  name: 'PageIndex',
  mixins: [locale],
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('AdminAbsensi')
    }, 1000)
  },
  setup () {
    const pros = [
      {
        key: 'High Performance',
        desc: 'performa yang mendekati aplikasi desktop/native'
      },
      {
        key: 'Modern and Clean UI',
        desc: `antarmuka pengguna yang lebih bersih dan rapi dengan
              membawa Material Design milik Google`
      },
      {
        key: 'Adaptive',
        desc: `mampu menyesuaikan berbagai ukuran layar, mulai dari
              mobile hingga layar beresolusi tinggi (>1080p)`
      },
      {
        key: 'Installable',
        desc: `dapat diinstal ke smartphone ataupun perangkat desktop`
      },
      {
        key: 'More Secure',
        desc: `menerapkan sistem keamanan terbaru yang lebih modern dan canggih`
      },
      {
        key: 'Simultaneous Update',
        desc: `semua sekolah akan selalu mendapat update secara serentak`
      }
    ]

    return {
      pros
    }
  }
}
</script>
