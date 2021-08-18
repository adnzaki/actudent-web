<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ pageTitle }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ pageTitle }}</div>
      <div :class="['row', titleSpacing()]">
        <!-- <search-box :label="lang.kelas_cari" vuex-module="grade" class="q-mt-sm" /> -->
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { useStore } from 'vuex'
import { onBeforeRouteLeave } from 'vue-router'
import { titleSpacing } from 'src/composables/screen'

export default {
  name: 'MemberMain',
  components: {
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminKelas')   
    }, 1000)
  },
  computed: {
    pageTitle() {      
      return this.lang.kelas_group_member_title === undefined ? '' :
        `${this.lang.kelas_group_member_title} - 
        ${this.$store.state.grade.classMember.name}`
    }
  },
  setup () {
    const store = useStore()

    return { titleSpacing }
  }
}
</script>
