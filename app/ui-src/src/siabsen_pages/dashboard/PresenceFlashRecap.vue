<template>
  <div class="q-my-md row">
    <div :class="['col-12 col-md-4', responsiveClass()]">
      <q-card class="my-card bg-green">
        <q-card-section class="text-white">
          <div class="text-h2">{{ todaySummary.present }}</div>
          <div class="text-subtitle1">{{ $t('siabsen_hadir_harian') }}</div>    
          <q-btn
            to="/teacher-presence/manage"
            class="absolute check-btn"
            color="green-5" unelevated size="lg"
            icon="o_check_circle">    
            <btn-tooltip :label="$t('siabsen_cek_hadir')" anchor="center end" self="center left" />  
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
            color="red-5" unelevated size="lg"
            icon="o_cancel">    
            <btn-tooltip :label="$t('siabsen_cek_hadir')" anchor="center end" self="center left" />  
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
            color="amber-6" unelevated size="lg"
            icon="o_info">    
            <btn-tooltip :label="$t('siabsen_cek_izin')" anchor="center end" self="center left" />        
          </q-btn>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
import { useQuasar } from 'quasar'
import { ref } from 'vue'
import { siabsen, bearerToken } from 'src/composables/common'

export default {
  setup() {
    const $q = useQuasar()
    const todaySummary = ref({
      absent: 0,
      present: 0,
      permit: 0
    })

    siabsen.get('rekap-harian', {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        todaySummary.value = {
          absent: data.absent,
          present: data.present,
          permit: data.permit
        }
      }) 

    return {
      todaySummary,
      responsiveClass: () => $q.screen.lt.sm ? 'q-mb-md' : 'q-pr-sm'
    }
  }
}
</script>