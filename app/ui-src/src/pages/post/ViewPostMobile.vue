<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.back()"
        />
        <div
          class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5"
          v-if="$q.screen.lt.sm"
        >
          {{ $t('timeline_view_post') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('timeline_view_post') }}
        </div>
      </div>
      <div :class="['row', titleSpacing()]">
        <post-content />
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { titleSpacing } from 'src/composables/screen'
import PostContent from './PostContent.vue'
import { usePostStore } from 'src/stores/post'
import { useRoute } from 'vue-router'
import { onMounted } from 'vue'

const store = usePostStore()
const route = useRoute()

onMounted(() => {
  store.getDetail(route.params.id, true, true)
})
</script>
