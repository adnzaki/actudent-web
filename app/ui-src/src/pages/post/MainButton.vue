<template>
  <div class="col-12 col-md-5">
    <div class="q-gutter-xs" v-if="$q.cookies.get(conf.userType) !== '3'">
      <q-btn
        icon="add"
        :class="['q-pl-sm mobile-hide', addButton]"
        unelevated
        :label="$t('tambah')"
        @click="store.showForm = true"
      />
      <q-btn
        icon="delete"
        class="q-pl-sm delete-btn mobile-hide"
        unelevated
        :label="$t('hapus')"
        @click="multipleDeleteConfirm"
      />
      <q-btn
        :icon="filterIcon"
        :class="['q-pl-sm', addButton]"
        unelevated
        :label="filterText"
        @click="getMyPost"
      />
    </div>

    <q-page-sticky
      position="bottom-right"
      :offset="fabPos"
      class="mobile-only force-elevated"
      v-if="!store.showForm && $q.cookies.get(conf.userType) !== '3'"
    >
      <q-btn
        fab
        icon="add"
        :class="addButton"
        @click="store.showForm = true"
        v-if="selected.length === 0"
      />
      <q-btn
        fab
        icon="delete"
        class="delete-btn"
        @click="multipleDeleteConfirm"
        v-if="selected.length > 0"
      />
    </q-page-sticky>
  </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue'
import { fabPos } from 'src/composables/fab'
import { usePostStore } from 'src/stores/post'
import { conf, addButton, t } from 'src/composables/common'
import { usePagingStore } from 'ss-paging-vue'

export default {
  setup() {
    const store = usePostStore()
    const paging = usePagingStore()
    const filterIcon = computed(() => {
      return store.mypost === 1 ? 'rotate_90_degrees_ccw' : 'filter_list'
    })

    const filterText = computed(() => {
      return store.mypost === 1 ? t('timeline_all') : t('timeline_mypost')
    })

    const getMyPost = () => {
      if (store.mypost === 0) store.mypost = 1
      else store.mypost = 0

      store.getPosts()
    }

    return {
      conf,
      store,
      fabPos,
      addButton,
      getMyPost,
      filterIcon,
      filterText,
      selected: computed(() => store.selectedPosts),
      multipleDeleteConfirm: () => store.multipleDeleteConfirm(),
    }
  },
}
</script>
