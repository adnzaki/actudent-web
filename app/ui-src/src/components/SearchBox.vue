<template>
  <div :class="[rootClass, 'justify-data-options']">
    <q-input outlined bottom-slots v-model="paging.state.search" 
      :label="label"
      @keyup.enter="filter"
      dense>
      <template v-slot:append>
        <q-icon name="search" @click="filter" class="cursor-pointer" />
      </template>
    </q-input>
  </div>
</template>

<script>
import { useQuasar } from 'quasar'
import { computed, watch } from 'vue'
import { conf, errorNotif } from '../composables/common'
import { usePagingStore } from 'ss-paging-vue'

export default {
  props: {
    label: {
      type: String
    },
    rootClass: {
      type: String,
      default: 'col-12 col-md-4'
    },
  },
  setup() {
    const paging = usePagingStore()
    const $q = useQuasar()
    let search = computed(() => paging.state.search)
    watch(search, () => paging.onSearchChanged())

    return {
      paging,
      filter: () => {
        if($q.cookies.has(conf.cookieName)) {
          paging.filter()
        } else {
          errorNotif()
        }
      }
    }
  }
}
</script>