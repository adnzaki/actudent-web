<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showPost"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('timeline_view_post') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll" style="max-height: 70vh">
        <post-content />
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
          class="close-btn"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { usePostStore } from 'src/stores/post'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { conf } from 'src/composables/common'
import PostContent from './PostContent.vue'

export default {
  name: 'ViewPost',
  components: { PostContent },
  setup() {
    const store = usePostStore()

    const formOpen = () => {}

    return {
      store,
      formOpen,
      cardDialog,
      maximizedDialog,
      src: computed(() => `${conf.adminAPI}post/content/${store.postId}`),
    }
  },
}
</script>
