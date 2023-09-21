<template>
  <q-list class="q-px-md q-py-sm">
    <q-expansion-item
      :class="[shadow, 'overflow-hidden q-mb-md']"
      style="border-radius: 15px"
      expand-separator
      expand-icon-toggle
      icon="event"
      :label="item.date"
      :header-class="[headerMobileList, 'text-white']"
      expand-icon-class="text-white"
      default-opened
      v-for="(item, index) in userEvents"
      :key="index"
    >
      <q-card :class="cardColor">
        <q-card-section
          class="q-px-none q-pt-md q-pb-xs cursor-pointer"
          @click="agendaStore.getDetail(item.id)"
        >
          <q-chip
            square
            style="font-size: 12px; top: 0; right: -7px"
            class="absolute"
            size="sm"
            :color="badgeColor(item.priority)"
            text-color="white"
          >
            {{ badgeLabel(item.priority) }}
          </q-chip>
          <div class="row q-mb-sm q-mt-sm">
            <div class="col-12 q-pl-sm">
              <p class="text-center text-bold q-mt-md">{{ item.name }}</p>
            </div>
            <div class="col-12 q-mt-sm text-center">
              <q-chip
                style="margin-top: -10px"
                size="md"
                color="blue"
                text-color="white"
              >
                <strong>{{ item.time }}</strong>
              </q-chip>
            </div>
          </div>
        </q-card-section>
        <q-card-actions align="center">
          <q-btn
            :class="['stafflist-btn', addButton]"
            :label="$t('siabsen_do_absen')"
            @click="openPresenceDialog(item.id, item.canPresent)"
          />
        </q-card-actions>
      </q-card>
    </q-expansion-item>
  </q-list>
</template>

<script setup>
import { computed, inject } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { t, addButton } from 'src/composables/common'
import { useAgendaStore } from 'src/stores/agenda'
import { headerMobileList, cardColor, shadow } from '../siabsen-common'

const store = useSiabsenStore()
const agendaStore = useAgendaStore()

const openPresenceDialog = inject('openPresenceDialog')

const badgeLabel = (priority) => {
  const label = {
    high: t('agenda_input_highprior'),
    normal: t('agenda_input_normalprior'),
    low: t('agenda_input_lowprior'),
  }

  return label[priority]
}
const badgeColor = (priority) => {
  const colors = {
    high: 'negative',
    normal: 'positive',
    low: 'blue',
  }

  return colors[priority]
}
const userEvents = computed(() => store.userEvents)
</script>
