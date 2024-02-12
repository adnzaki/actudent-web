<template>
  <div :class="[rootClass, 'justify-data-options']">
    <q-select
      outlined
      v-model="paging.state.rows"
      :options="options"
      dense
      @update:model-value="showPerPage"
      :display-value="`${paging.state.rows} ${$t('baris')}`"
    />
  </div>
</template>

<script>
import { useQuasar } from 'quasar'
import { conf, errorNotif } from '../composables/common'
import { usePagingStore } from 'ss-paging-vue'

export default {
  props: {
    rootClass: {
      type: String,
      default: 'col-12 col-md-2 offset-md-2',
    },
    options: {
      type: Array,
      default() {
        return [10, 25, 50, 100, 250]
      },
    },
  },
  setup() {
    const paging = usePagingStore()
    const $q = useQuasar()

    return {
      paging,
      showPerPage: () => {
        if ($q.cookies.has(conf.cookieName)) {
          paging.showPerPage()
        } else {
          errorNotif()
        }
      },
    }
  },
}
</script>
