<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_weekly_chart') }}</div>
      <div style="width: 100%" class="chart-container">
        <canvas :height="canvasHeight" id="presence-chart"></canvas>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { Chart } from 'chart.js/auto'
import { ref, onMounted, computed }  from 'vue'
import { admin } from 'boot/axios'
import { bearerToken, t } from 'src/composables/common'
import { useQuasar } from 'quasar'

export default {
  setup() {
    const present = ref([])
    const absent = ref([])
    const sick = ref([])
    const permit = ref([])
    const days = ref([])
    const $q = useQuasar()    

    const CHART_COLORS = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgb(75, 192, 192)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(201, 203, 207)'
    }
    
    onMounted(() => {
      
      setTimeout(() => {
        const getLastSevenDays = () => {
          admin.get('home/absen-seminggu', {
            headers: { Authorization: bearerToken },
          }).then(({ data }) => {
            present.value = data.present
            absent.value = data.absent
            sick.value = data.sick
            permit.value = data.permit
            days.value = data.date

            const labels = days.value

            const datasets = [
              {
                label: t('absensi_hadir'),
                data: present.value,
                borderColor: CHART_COLORS.green,
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
              },
              {
                label: t('absensi_alfa'),
                data: absent.value,
                borderColor: CHART_COLORS.red,
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
              },
              {
                label: t('absensi_sakit'),
                data: sick.value,
                borderColor: CHART_COLORS.orange,
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
              },
              {
                label: t('absensi_izin'),
                data: permit.value,
                borderColor: CHART_COLORS.blue,
                fill: false,
                cubicInterpolationMode: 'monotone',
                tension: 0.4
              },
            ]
    
            // update the chart
            setTimeout(() => {
              chart.data.labels = labels
              chart.data.datasets = datasets
              chart.update('none')
            }, 500)
          })      
        }
        
        getLastSevenDays()
    
        const chartId = document.getElementById('presence-chart')    
    
        const chart = new Chart(chartId, {
          type: 'line',
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              intersect: false,
            },
          },
          data: {
            labels: [],
            datasets: []
          },
        })      

        setInterval(getLastSevenDays, 24000)

      }, 2000)
    })
    
    return {
      canvasHeight: computed(() => $q.screen.lt.sm ? 300 : 320)
    }    
  }
}
</script>