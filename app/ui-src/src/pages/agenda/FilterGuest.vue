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
    @selected="filterGuest"
    loader="getClassGroup"
    :label="$t('siswa_semua_kelas')"
    :list="studentStore.classGroupList"
    :options-value="{ label: 'grade_name', value: 'grade_id' }"
  />
</template>

<script>
import { useI18n } from 'vue-i18n'
import { useQuasar } from 'quasar'
import { ref, inject, computed } from 'vue'
import { useAgendaStore } from 'src/stores/agenda'
import { useStudentStore } from 'src/stores/student'

export default {
  setup() {
    const model = ref({})
    const $q = useQuasar()
    const options = ref([])
    const { t } = useI18n()
    const store = useAgendaStore()
    const studentStore = useStudentStore()
    const disableClassSelector = ref(true)
    const { selectAllToggle } = inject('GuestSelector')

    setTimeout(() => {
      options.value = [
        { label: t('staff_guru'), value: 'guru' },
        { label: 'Staff', value: 'staff' },
        { label: t('kelas_wali'), value: 'wali_kelas' },
        { label: t('agenda_check_ortu'), value: 'orang_tua' },
      ]

      model.value = {
        label: t('staff_guru'),
        value: 'guru',
      }

      store.getUsers(model.value.value)
    }, 1500)

    return {
      store,
      model,
      options,
      studentStore,
      disableClassSelector,
      filterGuest(model) {
        if (model.value !== 'orang_tua') {
          store.getUsers(model.value)

          // disable only if model.value is a pure string
          if (isNaN(model.value)) {
            disableClassSelector.value = true
            studentStore.getClassGroup()
          }
        } else {
          disableClassSelector.value = false
          const classList = computed(() => studentStore.classGroupList)

          if (classList.value.length > 0) {
            store.getUsers(classList.value[0].grade_id)
          }
        }

        selectAllToggle.value = false
      },
    }
  },
}
</script>
