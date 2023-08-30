<template>
  <div class="col-12 col-md-2 q-mt-sm">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="getPostByType"
    />
  </div>
</template>

<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePostStore } from 'src/stores/post'
import { usePagingStore } from 'ss-paging-vue'

export default {
  setup() {
    const model = ref({})
    const { t } = useI18n()
    const options = ref([])
    const store = usePostStore()
    const paging = usePagingStore()

    setTimeout(() => {
      options.value = [
        { label: t('timeline_all'), value: 'all' },
        { label: t('timeline_public'), value: 'public' },
        { label: 'Draft', value: 'draft' },
      ]

      model.value = {
        label: t('timeline_all'),
        value: 'all',
      }
    }, 1500)

    return {
      model,
      options,
      getPostByType: (model) => {
        store.postType = model.value
        store.getPosts()
      },
    }
  },
}
</script>
