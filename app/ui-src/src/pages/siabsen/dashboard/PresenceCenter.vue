<template>
  <div class="q-mb-md row">
    <div :class="['col-12 col-sm-6', responsiveClass()]">
      <q-card :class="['my-card text-white', entryColor]">
        <q-card-section>
          <div class="text-h6">{{ $t('siabsen_masuk') }}</div>
          <div class="row">
            <div class="col-12 col-sm-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">{{ $t('siabsen_jam_masuk') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ serverTime }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">{{ $t('siabsen_waktu_absen') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ localTime }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <q-btn color="teal-14" rounded style="width: 100%" size="lg" :disable="disableEntry">
                {{ $t('siabsen_do_absen') }}
              </q-btn>
            </div>
          </div>
        
        </q-card-section>
      </q-card>
    </div>
    <!-- Out card -->
    <div class="col-12 col-sm-6">
      <q-card :class="['my-card text-white', outColor]">
        <q-card-section>
          <div class="text-h6">{{ $t('siabsen_pulang') }}</div>
          <div class="row">
            <div class="col-12 col-sm-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">{{ $t('siabsen_jam_pulang') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">14:00</div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">{{ $t('siabsen_waktu_absen') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">14:29</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <q-btn color="teal-14" rounded style="width: 100%" size="lg" :disable="disableOut">
                {{ $t('siabsen_do_absen') }}
              </q-btn>
            </div>
          </div>
        
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
import { useQuasar } from 'quasar'
import { ref, onMounted, computed } from 'vue'
import { phpTimestamp, conf, bearerToken, axios } from 'src/composables/common'

export default {
  name: 'PresenceCenter',
  setup() {
    const $q = useQuasar()
    const d = new Date()
    const hours = ref(d.getHours())
    const minutes = ref(d.getMinutes())
    const disableEntry = ref(false)
    const disableOut = ref(false)
    const decimalHours = computed(() => hours.value + (60 / minutes.value))
    const entryColor = ref('')
    const outColor = ref('')
    const timestamp = ref(phpTimestamp(new Date))
    const serverTime = ref('')
    const localTime = ref(`${hours.value}:${minutes.value}`)
    
    onMounted(() => {
      axios.get(`${conf.siabsenAPI}get-server-time`, {
        headers: { Authorization: bearerToken }
      })
        .then(({ data }) => {
          serverTime.value = data.msg
        })
        
      if(decimalHours.value > 6 && decimalHours.value < 14) {
        disableEntry.value = false
        entryColor.value = 'bg-secondary'
        disableOut.value = true
        outColor.value = 'bg-cyan-9'
      } else {
        disableEntry.value = true
        entryColor.value = 'bg-cyan-9'
        disableOut.value = false
        outColor.value = 'bg-secondary'
      }
    })

    return {
      serverTime,
      localTime,
      timestamp,
      disableEntry, entryColor,
      disableOut, outColor,
      responsiveClass: () => $q.screen.lt.sm ? 'q-mb-md' : 'q-pr-sm'
    }
  }
}
</script>