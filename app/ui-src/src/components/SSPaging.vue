<template>
  <div class="q-pa-sm">
    <div class="row">
      <div :class="[rangeWidth, 'q-mt-sm']">
        <p :class="customRangeClass">{{ rowRange }}</p>
      </div>
      <div
        :class="[navWidth, navOffset, customNavClass]"
        v-if="totalPages() > 0"
      >
        <q-pagination
          :model-value="modelValue"
          :max="paging.state.last + 1"
          :max-pages="paging.state.linkNum === false ? 0 : paging.state.linkNum"
          :input="useInput"
          direction-links
          boundary-links
          @update:model-value="onPaginationUpdate"
          :boundary-numbers="false"
          :ellipses="false"
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
    modelValue: [Number, String],
    rangeWidth: {
      type: String,
      default: 'col-12 col-md-6',
    },
    navWidth: {
      type: String,
      default: 'col-12 col-md-2',
    },
    navOffset: {
      type: String,
      default: 'offset-md-4',
    },
    useInput: {
      type: Boolean,
      default: true,
    },
    customRangeClass: {
      type: [String, Array],
      default: '',
    },
    customNavClass: {
      type: [String, Array],
      default: '',
    },
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const $q = useQuasar()
    const paging = usePagingStore()

    const totalPages = () => {
      const pageLinks = computed(() => paging.state.pageLinks)

      return pageLinks.value.length
    }

    const onPaginationUpdate = (value) => {
      if ($q.cookies.has(conf.cookieName)) {
        emit('update:modelValue', value)
        paging.nav(value - 1)
      } else {
        errorNotif()
      }
    }

    return {
      paging,
      totalPages,
      onPaginationUpdate,
      rowRange: computed(() => paging.rowRange()),
    }
  },
}
</script>
