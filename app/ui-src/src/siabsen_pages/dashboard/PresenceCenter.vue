<template>
  <div class="q-mb-md row">
    <div :class="['col-12 col-sm-6', responsiveClass()]">
      <q-card :class="['my-card text-white', entryColor]">
        <q-card-section>
          <div class="text-h6 q-mb-md">{{ $store.state.siabsen.inStatus }}</div>
          <div class="row">
            <div class="col-12 col-md-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">{{ $t('siabsen_jam_masuk') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ $store.state.siabsen.config.presence_timein }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">{{ $t('siabsen_waktu_absen') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ $store.state.siabsen.absenceIn }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <q-btn color="light-blue-5" 
                rounded style="width: 100%" 
                :disable="disableEntry || !$store.state.siabsen.canInAbsent"
                @click="openDialog('masuk')">
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
          <div class="text-h6 q-mb-md">{{ $store.state.siabsen.outStatus }}</div>
          <div class="row">
            <div class="col-12 col-md-8 q-mb-lg">
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2">{{ $t('siabsen_jam_pulang') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ $store.state.siabsen.config.presence_timeout }}</div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="text-subtitle2 text-capitalize">{{ $t('siabsen_waktu_absen') }}:</div>
                </div>
                <div class="col-6">
                  <div class="text-subtitle2">{{ $store.state.siabsen.absenceOut }}</div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <q-btn color="light-blue-5" 
                rounded style="width: 100%" 
                :disable="disableOut || !$store.state.siabsen.canOutAbsent"
                @click="openDialog('pulang')">
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
import { useStore } from 'vuex'

export default {
  name: 'PresenceCenter',
  setup() {
    const $q = useQuasar()
    const store = useStore()
    const d = new Date()
    const disableEntry = ref(false)
    const disableOut = ref(false)
    const entryColor = ref('bg-blue')
    const outColor = ref('bg-blue')

    const openDialog = type => {
      store.state.siabsen.presenceType = type
      store.state.siabsen.showPresenceDialog = true
    }
   
    onMounted(() => {
      const prepare = async () => {
        store.commit('siabsen/getConfig')
        store.commit('siabsen/getTeacherStatus', 'masuk')
        store.commit('siabsen/getTeacherStatus', 'pulang')

        return new Promise((resolve, reject) => setTimeout(resolve, 2500))
      }

      prepare().then(() => {
        if(store.state.siabsen.canInAbsent) {
          disableEntry.value = false
          entryColor.value = 'bg-blue'
        } else {
          disableEntry.value = true
          entryColor.value = 'bg-blue-9'
        }  

        if(store.state.siabsen.canOutAbsent) {
          disableOut.value = false
          outColor.value = 'bg-blue'
        } else {
          disableOut.value = true
          outColor.value = 'bg-blue-9'          
        }  

        if(store.state.siabsen.isLate) {
          entryColor.value = 'bg-amber-10'
        }
      })

      const isLate = computed(() => store.state.siabsen.isLate)
      watch(isLate, () => {
        if(store.state.siabsen.isLate) {
          entryColor.value = 'bg-amber-10'
        }
      })
    })

    return {
      openDialog,
      disableEntry, entryColor,
      disableOut, outColor,
      responsiveClass: () => $q.screen.lt.sm ? 'q-mb-md' : 'q-pr-sm'
    }
  }
}
</script>