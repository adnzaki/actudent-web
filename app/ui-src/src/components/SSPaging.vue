<template>
  <div class="q-pa-sm">
    <div class="row">
      <div class="col-12 col-md-6 q-mt-sm">
        <p> {{ $store.getters[`${vuexModule}/rowRange`] }} </p>
      </div>
      <div class="col-12 col-md-2 offset-md-4" v-if="totalPages() > 0">
        <q-pagination
          v-model="$store.state[vuexModule]['current']"
          :max="totalPages()"
          input
          @update:model-value="onPaginationUpdate"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'
import { conf, errorNotif } from 'src/composables/common'

export default {
  name: 'SSPaging',
  props: ['vuexModule'],
  setup (props) {
    const store = useStore()
    const $q = useQuasar()
    const totalPages = () => {
      const pageLinks = computed(() => store.state[props.vuexModule]['paging']['pageLinks'])

      return pageLinks.value.length
    }

    const onPaginationUpdate = () => {
      if($q.cookies.has(conf.cookieName)) {
        const current = computed(() => store.state[props.vuexModule]['current']).value
        store.dispatch(`${props.vuexModule}/nav`, current - 1)
      } else {
        errorNotif()
      }
    }

    return {
      totalPages,
      onPaginationUpdate
    }
  }
}
</script>
