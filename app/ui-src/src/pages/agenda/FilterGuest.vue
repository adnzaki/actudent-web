<template>
  <div class="col-12 col-md-4 q-pr-xs q-mt-sm">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="filterGuest"
    />
  </div>
</template>

<script>
import { useI18n } from 'vue-i18n'
import { ref, inject } from 'vue'
import { useStore } from 'vuex'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const store = useStore()
    const { selectAllToggle } = inject('GuestSelector')
    
    setTimeout(() => {
      options.value = [
        { label: t('staff_guru'), value: 'guru' },
        { label: 'Staff', value: 'staff' },
        { label: t('kelas_wali'), value: 'wali_kelas' },
        { label: t('agenda_check_ortu'), value: 'orang_tua' },
      ]

      model.value = { 
        label: t('staff_guru'), value: 'guru'
      }

      store.dispatch('agenda/getUsers', model.value.value)
      
    }, 1500)

    return {
      filterGuest(model) {
        store.dispatch('agenda/getUsers', model.value)
        selectAllToggle.value = false
      },
      options,
      model,
    }
  } 
}
</script>