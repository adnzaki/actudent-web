<template>
  <div class="q-mb-md row">
    <div :class="['col-12 col-sm-6', responsiveClass()]">
      <q-card :class="['my-card text-white', entryColor]">
        <q-card-section>
          <div class="text-h6 q-mb-md">{{ store.inStatus }}</div>
          <div class="row">
            <div class="col-12 col-md-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">
                    {{ $t('siabsen_jam_masuk') }}:
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">
                    {{ store.dailySchedule.schedule_timein }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">
                    {{ $t('siabsen_waktu_absen') }}:
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ store.absenceIn }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <q-btn
                :color="presenceButton"
                rounded
                style="width: 100%"
                :disable="disableEntry || !store.canInAbsent"
                @click="openDialog('masuk')"
              >
                <q-icon name="touch_app" class="q-pb-sm" left size="3em" />
                <div>{{ $t('siabsen_do_absen') }}</div>
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
          <div class="text-h6 q-mb-md">{{ store.outStatus }}</div>
          <div class="row">
            <div class="col-12 col-md-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">
                    {{ $t('siabsen_jam_pulang') }}:
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">
                    {{ store.dailySchedule.schedule_timeout }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">
                    {{ $t('siabsen_waktu_absen') }}:
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ store.absenceOut }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <q-btn
                :color="presenceButton"
                rounded
                style="width: 100%"
                :disable="disableOut || !store.canOutAbsent"
                @click="openDialog('pulang')"
              >
                <q-icon name="touch_app" class="q-pb-sm" left size="3em" />
                <div>{{ $t('siabsen_do_absen') }}</div>
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
import { ref, onMounted, computed, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  name: 'PresenceCenter',
  setup() {
    const $q = useQuasar()
    const store = useSiabsenStore()
    const router = useRouter()
    const d = new Date()
    const disableEntry = ref(false)
    const disableOut = ref(false)
    const entryColor = ref('bg-blue')
    const outColor = ref('bg-blue')

    const openDialog = (type) => {
      store.presenceType = type

      if ($q.screen.lt.sm) {
        router.push('/absence/presence-action')
      } else {
        store.showPresenceDialog = true
      }
    }

    const setInStatus = () => {
      if (store.canInAbsent) {
        disableEntry.value = false
        entryColor.value = $q.dark.isActive ? 'bg-grey-7' : 'bg-blue'
      } else {
        disableEntry.value = true
        entryColor.value = $q.dark.isActive ? 'bg-grey-9' : 'bg-blue-9'
      }
    }

    const setOutStatus = () => {
      if (store.canOutAbsent) {
        disableOut.value = false
        outColor.value = $q.dark.isActive ? 'bg-grey-7' : 'bg-blue'
      } else {
        disableOut.value = true
        outColor.value = $q.dark.isActive ? 'bg-grey-9' : 'bg-blue-9'
      }

      if (store.isLate) {
        entryColor.value = 'bg-amber-10'
      }
    }

    store.getDailySchedule()
    store.getTeacherStatus('masuk', setInStatus)
    store.getTeacherStatus('pulang', setOutStatus)

    const isLate = computed(() => store.isLate)
    watch(isLate, () => {
      if (store.isLate) {
        entryColor.value = 'bg-amber-10'
      }
    })

    return {
      store,
      presenceButton: computed(() =>
        $q.dark.isActive ? 'grey-6' : 'light-blue-5'
      ),
      openDialog,
      disableEntry,
      entryColor,
      disableOut,
      outColor,
      responsiveClass: () => ($q.screen.lt.sm ? 'q-mb-md' : 'q-pr-sm'),
    }
  },
}
</script>
