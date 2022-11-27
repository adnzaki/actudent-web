<template>
  <div class="row q-col-gutter-sm">
    <div class="col-12 col-md-6">
      <q-card class="q-mb-md">
        <q-card-section>
          <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_high_rank') }}</div>
          <q-list bordered separator>
            <q-item clickable v-ripple v-for="(item, index) in highest" :key="index">
              <q-item-section>
                <q-item-label>{{ item.grade_name }}</q-item-label>
                <q-item-label caption>
                  {{ $t('dashboard_presence_level') }}:
                  {{ item.present }}%
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-card>
    </div>
    <div class="col-12 col-md-6">
      <q-card class="q-mb-md">
        <q-card-section>
          <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_low_rank') }}</div>
          <q-list bordered separator>
            <q-item clickable v-ripple v-for="(item, index) in lowest" :key="index">
              <q-item-section>
                <q-item-label>{{ item.grade_name }}</q-item-label>
                <q-item-label caption>
                  {{ $t('dashboard_presence_level') }}:
                  {{ item.present }}%
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-card>
    </div>
  </div>
  
</template>

<script>
import { ref } from 'vue'
import { admin } from 'boot/axios'
import { bearerToken, t } from 'src/composables/common'

export default {
  setup() {
    const highest = ref([])
    const lowest = ref([])
    
    const getPercentage = () => {
      admin.get('home/absen-harian-kelas', {
        headers: { Authorization: bearerToken },
      }).then(({ data }) => {
        highest.value = data.highest
        lowest.value = data.lowest
      }) 
    }

    getPercentage()
    setInterval(getPercentage, 22000)
    
    return {
      highest, lowest
    }
  }
}
</script>