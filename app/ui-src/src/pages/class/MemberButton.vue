<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        icon="add"
        :class="['q-pl-sm', addButton]"
        unelevated
        :label="$t('tambah')"
        @click="store.classMember.showForm = true"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
    >
      <q-btn
        fab
        icon="add"
        :class="addButton"
        @click="store.classMember.showForm = true"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useClassStore } from 'src/stores/class'
import { addButton } from 'src/composables/mode'

export default {
  name: 'MemberButton',
  setup() {
    return {
      addButton,
      store: useClassStore(),
      fabPos,
    }
  },
}
</script>
