<template>
  <q-page class="flex flex-center">
    <div class="q-pa-md row items-start q-gutter-md">
      <q-card class="my-card bg-secondary text-white">
        <q-card-section>
          <div class="text-h6">Our Changing Planet</div>
          <div class="text-subtitle2">by John Doe</div>
        </q-card-section>

        <q-card-section>
          {{ lang.page_title }}
        </q-card-section>

        <q-separator dark />

        <q-card-actions>
          <q-btn flat>Test me!</q-btn>
          <q-btn flat>Change the text!</q-btn>
        </q-card-actions>
      </q-card>

    </div>
  </q-page>
</template>

<script>
// import { defineComponent, ref, onMounted } from 'vue'
import { defineComponent } from 'vue'
import locale from '../../mixins/fetch-lang'

export default defineComponent({
  name: 'PageIndex',
  mixins: [locale],
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('AdminAbsensi')
    }, 1000)
  },
  setup () {
    return {
    }
  }
})
</script>
