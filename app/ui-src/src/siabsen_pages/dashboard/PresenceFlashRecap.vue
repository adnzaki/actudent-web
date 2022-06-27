<template>
  <div class="q-my-md row">
    <div :class="['col-12 col-md-4', responsiveClass()]">
      <q-card class="my-card bg-green">
        <q-card-section class="text-white">
          <div class="text-h2">52</div>
          <div class="text-subtitle1">Pegawai hadir hari ini</div>    
          <q-btn
            class="absolute check-btn"
            color="green-5" unelevated size="lg"
            icon="o_check_circle">    
            <btn-tooltip :label="'Cek kehadiran'" anchor="center end" self="center left" />  
          </q-btn>
        </q-card-section>
      </q-card>
    </div>
    <div :class="['col-12 col-md-4', responsiveClass()]">
      <q-card class="my-card bg-red">
        <q-card-section class="text-white">
          <div class="text-h2">4</div>
          <div class="text-subtitle1">Pegawai absen hari ini</div> 
          <q-btn
            class="absolute check-btn"
            color="red-5" unelevated size="lg"
            icon="o_cancel">    
            <btn-tooltip :label="'Cek kehadiran'" anchor="center end" self="center left" />  
          </q-btn>       
        </q-card-section>
      </q-card>
    </div>
    <div :class="['col-12 col-md-4', responsiveClass()]">
      <q-card class="my-card bg-amber-8">
        <q-card-section class="text-white">
          <div class="text-h2">6</div>
          <div class="text-subtitle1">Pegawai izin hari ini</div>  
          <q-btn
            class="absolute check-btn"
            color="amber-6" unelevated size="lg"
            icon="o_info">    
            <btn-tooltip :label="'Cek permintaan izin'" anchor="center end" self="center left" />        
          </q-btn>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
import { useQuasar } from 'quasar'

export default {
  setup() {
    const $q = useQuasar()

    return {
      responsiveClass: () => $q.screen.lt.sm ? 'q-mb-md' : 'q-pr-sm'
    }
  }
}
</script>