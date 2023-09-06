<template>
  <q-card class="my-card q-pb-sm q-mt-md">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('semester_summary_sign') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('semester_summary_sign') }}
      </div>
      <div :class="['row', titleSpacing()]">
        <p>{{ $t('sign_setting_desc') }}</p>
      </div>
      <q-option-group
        :options="[
          {
            label: `${$t('headmaster')}, ${$t('co_headmaster')}, ${$t(
              'homeroom'
            )}`,
            value: 'kepsek,waka,walas',
          },
          {
            label: `${$t('headmaster')}, ${$t('homeroom')}`,
            value: 'kepsek,walas',
          },
          { label: $t('homeroom'), value: 'walas' },
        ]"
        type="radio"
        v-model="store.semester_summary_sign"
      />
      <q-card-actions align="left">
        <q-btn
          :label="$t('simpan')"
          :disable="store.disableButton"
          @click="
            store.save(store.semester_summary_sign, 'semester_summary_sign')
          "
          class="save-btn"
        />
      </q-card-actions>
    </q-card-section>
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import { titleSpacing } from 'src/composables/screen'
import { useReportStore } from 'src/stores/report-store'

export default {
  setup() {
    const store = useReportStore()

    onMounted(() => store.getSignSetting('semester_summary_sign'))

    return {
      store,
      titleSpacing,
    }
  },
}
</script>
