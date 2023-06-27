<template>
  <q-card class="q-pa-sm" :style="cardDialog()" v-if="!store.mainForm">
    <q-card-section class="row items-center q-pb-none">
      <div class="text-h6 text-capitalize">
        {{ $t('agenda_manage_guests') }}
      </div>
      <q-space />
    </q-card-section>
    <q-card-section class="scroll card-section">
      <div class="row">
        <filter-guest />
      </div>
      <div class="row q-mb-md q-pr-xs">
        <search-box
          :label="$t('agenda_search_name')"
          root-class="col-12"
          class="q-mt-sm"
        />
      </div>
      <q-checkbox
        v-model="selectAllToggle"
        @update:model-value="selectAll"
        style="margin-left: -10px; margin-top: -15px"
        :label="$t('pilih_semua')"
      />
      <q-list bordered separator>
        <q-item v-for="(item, index) in data" :key="index">
          <q-item-section avatar v-if="$q.screen.gt.sm">
            <q-avatar color="primary" text-color="white">
              {{ item.name.substr(0, 1) }}
            </q-avatar>
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ item.name }}</q-item-label>
            <q-item-label caption lines="1">{{ item.email }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-btn
              icon="delete"
              v-if="isSelectedUser(item.id)"
              rounded
              color="negative"
              @click="toggleUserSelection(item.id, 'delete')"
            />
            <q-btn
              icon="add"
              v-else
              @click="toggleUserSelection(item.id)"
              rounded
              color="teal"
            />
          </q-item-section>
        </q-item>
      </q-list>
      <ss-paging
        v-model="store.current"
        nav-width="col-12 col-md-3"
        nav-offset="offset-md-3"
      />
    </q-card-section>
    <q-separator />
    <q-card-actions align="right">
      <q-btn
        v-if="$q.cookies.get(conf.userType) === '1'"
        class="mobile-form-btn"
        :label="$t('selesai')"
        @click="done"
        :disable="disableSaveButton"
        color="primary"
        padding="8px 20px"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import FilterGuest from './FilterGuest.vue'
import { conf } from 'src/composables/common'
import { usePagingStore } from 'ss-paging-vue'
import { useAgendaStore } from 'src/stores/agenda'
import { ref, provide, inject, computed, watch } from 'vue'
import { maximizedDialog, cardDialog } from 'src/composables/screen'

export default {
  components: { FilterGuest },
  setup() {
    const formOpen = () => {}
    const formHide = () => {}
    const store = useAgendaStore()
    const paging = usePagingStore()
    const selectAllToggle = ref(false)
    const { disableSaveButton } = inject('shared')
    const data = computed(() => paging.state.data)

    const guestType = store.isEditForm ? 'guestsEdit' : 'guests'
    const guests = computed(() => store[guestType])

    watch(data, () => {
      selectAllToggle.value = false
    })

    provide('GuestSelector', {
      selectAllToggle,
    })

    return {
      data,
      conf,
      store,
      formOpen,
      formHide,
      selectAllToggle,
      disableSaveButton,
      maximizedDialog,
      cardDialog,
      done() {
        store.mainForm = true
      },
      isSelectedUser(id) {
        return store[guestType].includes(id)
      },
      toggleUserSelection(id, type = 'add' /* add or delete */) {
        if (type === 'add') {
          store[guestType].push(id)
        } else {
          let index = guests.value.findIndex((el) => el === id)
          store[guestType].splice(index, 1)
        }
      },
      selectAll() {
        if (selectAllToggle.value) {
          for (let item of data.value) {
            // Skip duplicate IDs
            if (!store[guestType].includes(item.id)) {
              store[guestType].push(item.id)
            }
          }
        } else {
          store[guestType] = []
        }
      },
    }
  },
}
</script>
