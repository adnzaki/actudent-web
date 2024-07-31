<template>
  <q-card class="q-mb-md">
    <q-card-section v-if="!showSpinner">
      <div class="text-h6 text-capitalize q-mb-md">
        {{ $t('dashboard_daily_recap') }}
      </div>
      <div class="row q-mb-md q-col-gutter-sm">
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card
            :title="$t('absensi_hadir')"
            :number="present"
            color="secondary"
          />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card
            :title="$t('absensi_alfa')"
            :number="absent"
            color="negative"
          />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card
            :title="$t('absensi_sakit')"
            :number="sick"
            color="orange"
          />
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <presence-card
            :title="$t('absensi_izin')"
            :number="permit"
            color="light-blue"
          />
        </div>
      </div>
    </q-card-section>
    <q-card-section v-else
      ><spinner-orbit text="Getting today recap..." v-if="showSpinner"
    /></q-card-section>
  </q-card>
</template>

<script>
import PresenceCard from './PresenceCard.vue'
import { admin } from 'boot/axios'
import { bearerToken } from 'src/composables/common'
import { ref } from 'vue'
import { onBeforeRouteLeave } from 'vue-router'

export default {
  components: {
    PresenceCard,
  },
  setup() {
    const present = ref(0)
    const absent = ref(0)
    const sick = ref(0)
    const permit = ref(0)
    const showSpinner = ref(true)

    const getTodayPresence = () => {
      admin
        .get('home/absen-harian', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          present.value = data.present
          absent.value = data.absent
          sick.value = data.sick
          permit.value = data.permit
          showSpinner.value = false
        })
    }

    getTodayPresence()

    const intervalId = setInterval(getTodayPresence, 20000)
    onBeforeRouteLeave(() => clearInterval(intervalId))

    return {
      present,
      absent,
      sick,
      permit,
      showSpinner,
    }
  },
}
</script>
