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
import { useI18n } from 'vue-i18n'
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { useStore } from 'vuex'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const $q = useQuasar()
    const store = useStore()
    
    setTimeout(() => {
      options.value = [
        { label: t('staff_semua_bagian'), value: 'all' },
        { label: t('siabsen_must_present'), value: 'wajib' },
      ]

      model.value = { 
        label: t('siabsen_must_present'), value: 'wajib'
      }
      
    }, 1500);


    return {
      width: () => $q.screen.lt.md ? '100%' : '95%',
      modelChanged(model) {
        store.dispatch('siabsen/getRequiredPresent', model.value)
      },
      options,
      model,
    }
  } 
}
</script>