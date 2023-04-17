<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn
        color="deep-purple"
        icon="add"
        class="q-pl-sm"
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
        color="deep-purple"
        @click="store.classMember.showForm = true"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'
import { useClassStore } from 'src/stores/class'

export default {
  name: 'MemberButton',
  setup() {
    return {
      store: useClassStore(),
      fabPos,
    }
  },
}
</script>
