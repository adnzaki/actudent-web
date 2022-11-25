<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_daily_recap') }}</div>
      <div class="row q-mb-md q-col-gutter-sm">
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card :title="$t('absensi_hadir')" :number="present" color="secondary" />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card :title="$t('absensi_alfa')" :number="absent" color="negative" />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card :title="$t('absensi_sakit')" :number="sick" color="orange" />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card :title="$t('absensi_izin')" :number="permit" color="light-blue" />
        </div>
      </div>
    </q-card-section>
  </q-card>
  
</template>

<script>
import PresenceCard from './PresenceCard.vue'
import { admin } from 'boot/axios'
import { conf, bearerToken } from 'src/composables/common'
import { ref } from 'vue'

export default {
  components: {
    PresenceCard
  },
  setup() {
    const present = ref(0)
    const absent = ref(0)
    const sick = ref(0)
    const permit = ref(0)

    const getTodayPresence = () => {
      admin.get('home/absen-harian', {
        headers: { Authorization: bearerToken },
      }).then(({ data }) => {
        present.value = data.present
        absent.value = data.absent
        sick.value = data.sick
        permit.value = data.permit
      })      
    }

    getTodayPresence()

    setInterval(getTodayPresence, 10000)
    
    return {
      present, absent, sick, permit
    }
  }
}

</script>
