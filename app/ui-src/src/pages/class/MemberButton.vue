<template>
  <div class="col-12">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="deep-purple" icon="add" class="q-pl-sm" :label="$t('tambah')"
        @click="$store.state.grade.showAddForm = true" />
      <q-btn color="teal" icon="arrow_back" class="q-pl-sm" :label="$t('kelas_kembali')"
        @click="$router.push('/class')" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-fab color="primary" icon="keyboard_arrow_up" direction="up">
        <q-fab-action color="deep-purple" icon="add" />
        <q-fab-action color="teal" @click="$router.push('/class')" icon="arrow_back" />
      </q-fab>
    </q-page-sticky>
  </div>
</template>

<script>
import { fabPos } from 'src/composables/fab'

export default {
  name: 'MemberButton',
  setup() {
    
    return {
      fabPos,
    }
  }
}
</script>