<template>
  <div class="col-12 col-md-4">
    <div class="q-gutter-xs mobile-hide">
      <q-btn color="negative" icon="arrow_back" class="q-pl-sm" :label="$t('kelas_kembali')"
        @click="$router.push('/class')" />
    </div>

    <q-page-sticky position="bottom-right" 
      :offset="fabPos" 
      class="mobile-only force-elevated">
      <q-btn fab icon="arrow_back" color="negative" 
        @click="$router.push('/class')" 
      />
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