<template>
  <q-page-sticky class="mobile-hide" position="top-right" :offset="[15, 40]">
    <q-btn icon="print" color="secondary" class="btn-print" 
      :href="exportPdf()" target="_blank" />   
  </q-page-sticky>
</template>
<style lang="scss" scoped>
.btn-print {
  transition: all 0.25s ease;
  border-radius: 25px 0 0 25px;
  padding: 10px 30px;
}
.btn-print:hover {
  padding: 10px 60px;
}

</style>

<script>
import { inject } from 'vue'

export default {
  setup() {
    const { conf, route, $q } = inject('print')

    const exportPdf = () => {
      return `${conf.siabsenAPI}print-rekap-individu/` +
             `${route.params.staffId}/` + 
             `${route.params.userId}/` + 
             `${route.params.period}/${$q.cookies.get(conf.cookieName)}`
    }

    return {
      exportPdf
    }
  },
}
</script>