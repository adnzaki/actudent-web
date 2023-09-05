<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section class="q-mb-md">
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('menu_post') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('menu_post') }}
        </div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <post-type class="justify-data-options" />
          <row-dropdown class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box
            :label="$t('timeline_search')"
            class="q-mt-sm"
            root-class="col-12 col-md-3"
          />
        </div>
      </q-card-section>
      <!-- <add-employee-form />
      <edit-employee-form />
      
      <employee-table /> -->
      <post-form />
      <delete-confirm :store="store" @action="store.deletePost" />
      <post-table />
      <view-post />
    </q-card>
  </div>
</template>

<script>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import { usePostStore } from 'src/stores/post'
import MainButton from './MainButton.vue'
import PostType from './PostType.vue'
import PostTable from './PostTable.vue'
import ViewPost from './ViewPost.vue'
import PostForm from './PostForm.vue'

export default {
  name: 'NewsMain',
  components: {
    MainButton,
    PostType,
    PostTable,
    ViewPost,
    PostForm,
  },
  setup() {
    const store = usePostStore()

    return {
      store,
      titleSpacing,
      wrapperPadding,
    }
  },
}
</script>
