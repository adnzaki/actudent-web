<template>
  <div class="col-12 col-md-4">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        unelevated
        :class="['q-pl-sm', addButton]"
        :label="$t('menu_pengaturan')"
        @click="store.showSettingsForm = true"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
      v-if="!store.showSettingsForm"
    >
      <q-btn
        fab
        icon="settings"
        :class="addButton"
        @click="store.showSettingsForm = true"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useScheduleStore } from 'src/stores/schedule'
import { addButton } from 'src/composables/mode'

export default {
  name: 'MainButton',
  setup() {
    const store = useScheduleStore()

    return {
      store,
      fabPos,
      addButton,
    }
  },
}
</script>
