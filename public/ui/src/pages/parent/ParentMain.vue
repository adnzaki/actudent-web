<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6">Our Changing Planet</div>
        <div class="text-subtitle2">by John Doe</div>
      </q-card-section>
      <parent-table />
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import locale from '../../mixins/fetch-lang'
import ParentTable from './ParentTable'

export default defineComponent({
  name: 'ParentMain',
  mixins: [locale], 
  components: { ParentTable },
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminOrtu')
    }, 500)
  },
  setup () {
    return {
      
    }
  }
})
</script>
