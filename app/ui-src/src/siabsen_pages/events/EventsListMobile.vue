<template>
  <q-list class="q-px-md q-py-sm">
    <q-expansion-item
      class="shadow-3 overflow-hidden q-mb-md"
      style="border-radius: 15px"
      expand-separator
      expand-icon-toggle
      icon="event"
      :label="item.date"
      header-class="bg-primary text-white"
      expand-icon-class="text-white"
      default-opened
      v-for="(item, index) in userEvents"
      :key="index"
    >
      <q-card>
        <q-card-section
          class="q-px-none q-pt-md q-pb-xs cursor-pointer"
          @click="store.getDetail(item.id)"
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
            class="stafflist-btn"
            :label="$t('siabsen_do_absen')"
            @click="openPresenceDialog(item.id, item.canPresent)"
            color="accent"
          />
        </q-card-actions>
      </q-card>
    </q-expansion-item>
  </q-list>
</template>

<script>
import { computed, inject } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { t } from 'src/composables/common'

export default {
  setup() {
    const store = useSiabsenStore()

    const openPresenceDialog = inject('openPresenceDialog')

    return {
      openPresenceDialog,
      badgeLabel: (priority) => {
        const label = {
          high: t('agenda_input_highprior'),
          normal: t('agenda_input_normalprior'),
          low: t('agenda_input_lowprior'),
        }

        return label[priority]
      },
      badgeColor: (priority) => {
        const colors = {
          high: 'negative',
          normal: 'positive',
          low: 'blue',
        }

        return colors[priority]
      },
      userEvents: computed(() => store.userEvents),
    }
  },
}
</script>
