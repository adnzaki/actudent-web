<template>
  <div class="col-12 col-md-6 q-pr-xs q-mt-sm">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
      @update:model-value="filterGuest"
    />
  </div>
  <dropdown-search 
    :disable="disableClassSelector"
    class="justify-data-options" 
    custom-class="q-pr-xs"
    flex-grid="col-md-6"
    vuex-module="student"
    :selected="filterGuest"
    loader="getClassGroup"
    :label="$t('siswa_semua_kelas')"
    :list="$store.state.student.classGroupList"
    :options-value="{ label: 'grade_name', value: 'grade_id' }"
  />
</template>

<script>
import { useI18n } from 'vue-i18n'
import { ref, inject, computed } from 'vue'
import { useStore } from 'vuex'
import { useQuasar } from 'quasar'

export default {
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})
    const store = useStore()
    const $q = useQuasar()
    const { selectAllToggle } = inject('GuestSelector')
    const disableClassSelector = ref(true)
    
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
      disableClassSelector,
      filterGuest(model) {
        console.log('The model type is ' + typeof model.value)
        if(model.value !== 'orang_tua') {
          store.dispatch('agenda/getUsers', model.value)

          // disable only if model.value is a pure string
          if(isNaN(model.value)) {
            disableClassSelector.value = true
            store.commit('student/getClassGroup')
          }       
        } else {
          disableClassSelector.value = false
          const classList = computed(() => store.state.student.classGroupList)

          if(classList.value.length > 0) {
            store.dispatch('agenda/getUsers', classList.value[0].grade_id)
          }
        }

        selectAllToggle.value = false
      },
      options,
      model,
    }
  } 
}
</script>