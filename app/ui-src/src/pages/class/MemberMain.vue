<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn color="teal" flat rounded
          class="back-button"
          icon="arrow_back" 
          @click="$router.push('/class')" />
        <div class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5" v-if="$q.screen.lt.sm">{{ pageTitle }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ pageTitle }}</div>
      </div>
      <div :class="['row', titleSpacing()]">
        <member-button />
        <!-- <search-box :label="lang.kelas_cari" vuex-module="grade" class="q-mt-sm" /> -->
      </div>
    </q-card-section>
    <member-add-form />
    <member-table />
  </q-card>
</template>

<script>
import { useI18n } from 'vue-i18n'
import { computed } from 'vue'
import { useRoute, onBeforeRouteLeave } from 'vue-router'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MemberButton from './MemberButton.vue'
import MemberTable from './MemberTable.vue'
import MemberAddForm from './MemberAddForm.vue'

export default {
  name: 'MemberMain',
  components: {
    MemberButton,
    MemberTable,
    MemberAddForm
  },
  setup () {
    const { t } = useI18n()
    const store = useStore()
    const route = useRoute()

    if(store.state.grade.classMember.name === '') {
      store.commit('grade/getDetail', route.params.id)
    }

    onBeforeRouteLeave((to, from) => {
      store.state.grade.showEditForm = false
      store.state.grade.detail = {}
    })

    const pageTitle = computed(() => {      
      return t('kelas_group_member_title') === undefined ? '' :
        `${t('kelas_group_member_title')} - 
        ${store.state.grade.classMember.name}`
    })

    return { titleSpacing, pageTitle }
  }
}
</script>
