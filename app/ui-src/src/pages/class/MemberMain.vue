<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ pageTitle }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ pageTitle }}</div>
      <div :class="['row', titleSpacing()]">
        <member-button />
        <!-- <search-box :label="lang.kelas_cari" vuex-module="grade" class="q-mt-sm" /> -->
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { computed } from 'vue'
import { useRoute, onBeforeRouteLeave } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MemberButton from './MemberButton.vue'

export default {
  name: 'MemberMain',
  components: {
    MemberButton
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
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
    const route = useRoute()

    if(store.state.grade.classMember.name === '') {
      store.commit('grade/getDetail', route.params.id)
    }

    onBeforeRouteLeave((to, from) => {
      store.state.grade.showEditForm = false
      store.state.grade.detail = {}
    })

    return { titleSpacing }
  }
}
</script>
