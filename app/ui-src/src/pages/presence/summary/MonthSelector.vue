<template>
  <div class="col-12 col-sm-4 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="model"
      :options="options"
      dense
    />
  </div>
  <div class="col-12 col-sm-4 col-md-3 q-mt-sm q-px-xs">
    <q-select
      outlined
      v-model="yearModel"
      :options="yearOptions"
      dense
    />
  </div>
  <div class="col-12 col-sm-4 col-md-2 q-mt-sm q-px-xs">
    <q-btn color="deep-purple" style="width: 100%;" icon="preview" :label="$t('tampilkan')" />
  </div>
  <q-page-sticky position="bottom-right" 
    :offset="fabPos" 
    class="force-elevated">
    <q-fab color="secondary" icon="print" direction="up">
      <q-fab-action color="indigo" icon="picture_as_pdf">
        <btn-tooltip :label="$t('absensi_print_pdf')" anchor="center left" self="center end" />
      </q-fab-action>
      <q-fab-action color="blue" icon="table_view">
        <btn-tooltip :label="$t('absensi_export_excel')" anchor="center left" self="center end" />
      </q-fab-action>
    </q-fab>
  </q-page-sticky>
</template>
<script>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { fabPos } from 'src/composables/fab'

export default {
  name: 'MonthSelector',
  setup() {
    const { t } = useI18n()
    const options = ref([])
    const model = ref({})

    setTimeout(() => {
      options.value = [
        { label: t('mon1'), value: '1' },
        { label: t('mon2'), value: '2' },
        { label: t('mon3'), value: '3' },
        { label: t('mon4'), value: '4' },
        { label: t('mon5'), value: '5' },
        { label: t('mon6'), value: '6' },
        { label: t('mon7'), value: '7' },
        { label: t('mon8'), value: '8' },
        { label: t('mon9'), value: '9' },
        { label: t('mon10'), value: '10' },
        { label: t('mon11'), value: '11' },
        { label: t('mon12'), value: '12' },
      ]

      model.value = { label: t('mon1'), value: '1' }
    }, 1500)  

    return {
      options,
      model,
      yearOptions: [2020, 2021],
      yearModel: 2021,
      fabPos
    }
  }
}
</script>