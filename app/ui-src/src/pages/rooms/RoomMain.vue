<template>
  <div :class="wrapperPadding()">  
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_ruang') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_ruang') }}</div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown class="q-mt-sm" />
          <search-box :label="$t('ruang_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-room-form />
      <edit-room-form />
      <delete-confirm :store="store" :action="store.deleteRoom()" />
      <room-table />
    </q-card>
  </div>
</template>

<script>
import RoomTable from './RoomTable.vue'
import MainButton from './MainButton.vue'
import AddRoomForm from './AddRoomForm.vue'
import EditRoomForm from './EditRoomForm.vue'
import { useRoomStore } from 'src/stores/room'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'

export default {
  name: 'RoomMain',
  components: { 
    MainButton,
    RoomTable,
    AddRoomForm,
    EditRoomForm
  },
  setup() {
    const store = useRoomStore()

    return {
      store,
      wrapperPadding, titleSpacing
    }
  }
}
</script>
