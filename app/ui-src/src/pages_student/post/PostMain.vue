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
          <div class="offset-md-7"></div>
          <row-dropdown class="q-mt-sm" root-class="col-12 col-md-2" />
          <search-box
            :label="$t('timeline_search')"
            class="q-mt-sm"
            root-class="col-12 col-md-3"
          />
        </div>
      </q-card-section>
      <PostList />
      <ViewPost />
    </q-card>
  </div>
</template>

<script setup>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import ViewPost from 'src/pages/post/ViewPost.vue'
import PostList from './PostList.vue'
</script>
