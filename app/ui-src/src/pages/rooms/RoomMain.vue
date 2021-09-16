<template>
  <div :class="wrapperPadding()">  
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_ruang') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_ruang') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown vuex-module="rooms" class="q-mt-sm" />
          <search-box :label="$t('ruang_cari')" vuex-module="rooms" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-room-form />
      <!-- <edit-class-form /> -->
      <!-- <delete-confirm vuex-module="rooms" action="deleteRoom" /> -->
      <room-table />
    </q-card>
  </div>
</template>

<script>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import RoomTable from './RoomTable.vue'
import AddRoomForm from './AddRoomForm.vue'

export default {
  name: 'RoomMain',
  components: { 
    MainButton,
    RoomTable,
    AddRoomForm
  },
  setup() {
    return {
      wrapperPadding, titleSpacing
    }
  }
}
</script>
