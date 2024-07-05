<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section class="q-mb-md">
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('libur_title') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('libur_title') }}
        </div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown class="q-mt-sm" />
          <search-box :label="$t('libur_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <delete-confirm :store="store" @action="store.deleteHoliday()" />
      <data-table />
      <holiday-form />
    </q-card>
  </div>
</template>

<script setup>
import MainButton from './MainButton.vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import { useHolidaysStore } from 'src/stores/holidays'
import DataTable from './DataTable.vue'
import HolidayForm from './HolidayForm.vue'

const store = useHolidaysStore()
</script>
