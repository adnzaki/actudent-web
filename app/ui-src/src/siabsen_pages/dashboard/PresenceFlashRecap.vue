<template>
  <div>
    <div class="q-my-md row" v-if="!showSpinner">
      <div :class="['col-12 col-md-4', responsiveClass()]">
        <q-card class="my-card bg-green">
          <q-card-section class="text-white">
            <div class="text-h2">{{ todaySummary.present }}</div>
            <div class="text-subtitle1">{{ $t('siabsen_hadir_harian') }}</div>
            <q-btn
              to="/teacher-presence/manage"
              class="absolute check-btn"
              color="green-5"
              unelevated
              size="lg"
              icon="o_check_circle"
            >
              <btn-tooltip
                :label="$t('siabsen_cek_hadir')"
                anchor="center end"
                self="center left"
              />
            </q-btn>
          </q-card-section>
        </q-card>
      </div>
      <div :class="['col-12 col-md-4', responsiveClass()]">
        <q-card class="my-card bg-red">
          <q-card-section class="text-white">
            <div class="text-h2">{{ todaySummary.absent }}</div>
            <div class="text-subtitle1">{{ $t('siabsen_absen_harian') }}</div>
            <q-btn
              to="/teacher-presence/manage"
              class="absolute check-btn"
              color="red-5"
              unelevated
              size="lg"
              icon="o_cancel"
            >
              <btn-tooltip
                :label="$t('siabsen_cek_hadir')"
                anchor="center end"
                self="center left"
              />
            </q-btn>
          </q-card-section>
        </q-card>
      </div>
      <div :class="['col-12 col-md-4', responsiveClass()]">
        <q-card class="my-card bg-amber-8">
          <q-card-section class="text-white">
            <div class="text-h2">{{ todaySummary.permit }}</div>
            <div class="text-subtitle1">{{ $t('siabsen_izin_harian') }}</div>
            <q-btn
              to="/teacher-presence/permit"
              class="absolute check-btn"
              color="amber-6"
              unelevated
              size="lg"
              icon="o_info"
            >
              <btn-tooltip
                :label="$t('siabsen_cek_izin')"
                anchor="center end"
                self="center left"
              />
            </q-btn>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <div class="q-my-md row" v-else>
      <div class="col">
        <spinner-orbit text="Getting today's employee attendance..." />
      </div>
    </div>
    <q-card class="q-my-md" v-if="recentPresence.length > 0">
      <q-card-section>
        <div class="text-h6 text-capitalize">
          {{ $t('siabsen_recent_presence') }}
        </div>
      </q-card-section>
      <q-list bordered separator>
        <q-item
          clickable
          v-ripple
          v-for="(item, index) in recentPresence"
          :key="index"
        >
          <q-item-section>
            <q-item-label>{{ item.staff_name }}</q-item-label>
            <q-item-label caption>
              {{ $t('siabsen_present_time') }}:
              {{ item.presence_datetime.split(' ')[1] }}
            </q-item-label>
          </q-item-section>
          <q-item-section side top>
            <q-badge color="teal" :label="presenceLabel(item.presence_tag)" />
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { onBeforeRouteLeave } from 'vue-router'
import { siabsen, bearerToken, t } from 'src/composables/common'

export default {
  setup() {
    const $q = useQuasar()
    const todaySummary = ref({
      absent: 0,
      present: 0,
      permit: 0,
    })

    const recentPresence = ref([])
    const showSpinner = ref(true)

    const getDailyRecap = () => {
      siabsen
        .get('rekap-harian', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          todaySummary.value = {
            absent: data.absent,
            present: data.present,
            permit: data.permit,
          }
          showSpinner.value = false

          recentPresence.value = data.recent
        })
    }

    // run when page firstly loaded
    getDailyRecap()

    // run task every 10 secs
    const updateRecap = setInterval(getDailyRecap, 10000)

    // clear task after route leave
    onBeforeRouteLeave(() => clearInterval(updateRecap))

    return {
      showSpinner,
      presenceLabel: (type) => {
        return type === 'masuk' ? t('siabsen_in') : t('siabsen_out')
      },
      recentPresence,
      todaySummary,
      responsiveClass: () => ($q.screen.lt.md ? 'q-mb-md' : 'q-pr-sm'),
    }
  },
}
</script>
