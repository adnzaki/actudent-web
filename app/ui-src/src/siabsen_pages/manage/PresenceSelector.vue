<template>
  <div class="col-12 col-md-3 q-mt-sm">
    <q-select
      :style="{ width: width() }"
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="modelChanged"
    />
  </div>
</template>

<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useQuasar } from 'quasar'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const $q = useQuasar()
    const store = useSiabsenStore()

    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: 'all' },
        { label: t('staff_guru'), value: 'teacher' },
        { label: 'Staff', value: 'staff' },
      ]

      model.value = {
        label: t('staff_semua_bagian'),
        value: 'all',
      }

      store.getRequiredPresent(model.value.value)
    }, 1500)

    return {
      width: () => ($q.screen.lt.md ? '100%' : '95%'),
      modelChanged(model) {
        store.getRequiredPresent(model.value)
      },
      options,
      model,
    }
  },
}
</script>
