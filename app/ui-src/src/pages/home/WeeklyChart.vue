<template>
  <q-card class="q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize q-mb-md">{{ $t('dashboard_weekly_chart') }}</div>
      <div style="width: 100%" class="chart-container">
        <canvas id="presence-chart"></canvas>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { Chart } from 'chart.js/auto'
import { ref, onMounted }  from 'vue'

export default {
  setup() {
    const data = ref([
      { year: 2010, count: 10 },
      { year: 2011, count: 20 },
      { year: 2012, count: 15 },
      { year: 2013, count: 25 },
      { year: 2014, count: 22 },
      { year: 2015, count: 30 },
      { year: 2016, count: 28 },
    ])

    const CHART_COLORS = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgb(75, 192, 192)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(201, 203, 207)'
    };

    onMounted(() => {
      setTimeout(() => {
        const chartId = document.getElementById('presence-chart')

        const chart = () => { 
          new Chart(chartId, {
            type: 'line',
            options: {
              responsive: true,
              interaction: {
                intersect: false,
              },
            },
            data: {
              labels: data.value.map(row => row.year),
              datasets: [
                {
                  label: 'Acquisitions by year',
                  data: data.value.map(row => row.count),
                  borderColor: CHART_COLORS.red,
                  fill: false,
                  cubicInterpolationMode: 'monotone',
                  tension: 0.4
                }
              ]
            },
          })
        }

        chart()
        setInterval(chart, 10000)

      }, 2000)
    })
    
    return {}    
  }
}
</script>