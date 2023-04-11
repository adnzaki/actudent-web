<template>
  <div class="q-pa-sm">
    <div class="row">
      <div :class="[rangeWidth, 'q-mt-sm']">
        <p> {{ paging.rowRange }} </p>
      </div>
      <div :class="[navWidth, navOffset]" v-if="totalPages() > 0">
        <q-pagination
          v-model="store.current"
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
import { useQuasar } from 'quasar'
import { conf, errorNotif } from 'src/composables/common'
import { usePagingStore } from 'ss-paging-vue'

export default {
  props: {
    store: {
      type: Object,
      required: true,
    },
    rangeWidth: {
      type: String,
      default: 'col-12 col-md-6'
    },
    navWidth: {
      type: String,
      default: 'col-12 col-md-2'
    },
    navOffset: {
      type: String,
      default: 'offset-md-4'
    }
  },
  setup (props) {
    const $q = useQuasar()
    const paging = usePagingStore()
    const totalPages = () => {
      const pageLinks = computed(() => paging.state.pageLinks)

      return pageLinks.value.length
    }

    const onPaginationUpdate = () => {
      if($q.cookies.has(conf.cookieName)) {
        const current = computed(() => props.store.current).value
        paging.nav(current - 1)
      } else {
        errorNotif()
      }
    }

    return {
      paging,
      totalPages,
      onPaginationUpdate
    }
  }
}
</script>
