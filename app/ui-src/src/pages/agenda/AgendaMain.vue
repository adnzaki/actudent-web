<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t("menu_agenda") }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t("menu_agenda") }}
        </div>
        <div :class="['row', titleSpacing()]"></div>
      </q-card-section>
      <agenda-form />
      <delete-confirm
        :store="store"
        :custom-text="$t('agenda_delete_confirm')"
        :action="store.delete()"
      />
      <full-calendar />
    </q-card>
  </div>
</template>

<script>
import FullCalendar from "./FullCalendar.vue";
import AgendaForm from "./AgendaForm.vue";
import { useAgendaStore } from "src/stores/agenda";
import { wrapperPadding, titleSpacing } from "src/composables/screen";

export default {
  components: { FullCalendar, AgendaForm },
  name: "AgendaMain",
  setup() {
    const store = useAgendaStore();

    return { store, wrapperPadding, titleSpacing };
  },
};
</script>
