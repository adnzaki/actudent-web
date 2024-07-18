<template>
  <div class="row" v-if="data.length > 0">
    <div
      :class="['col-12 col-md-4', cardPadding]"
      v-for="(item, index) in data"
      :key="index"
    >
      <q-card
        class="q-mb-md cursor-pointer"
        @click="viewPost(item.timeline_id)"
      >
        <q-img
          :src="item.featured_image_path"
          style="max-height: 200px"
          fit="cover"
        ></q-img>
        <q-card-section>
          <div class="text-h6">{{ item.timeline_title }}</div>
          <div class="text-subtitle2 text-grey-8">
            <q-icon
              name="person_outline"
              style="margin-top: -5px; margin-right: 5px"
            />
            {{ item.author }}
          </div>
          <div class="text-textbody2 text-grey-8">
            <q-icon
              name="event"
              style="margin-top: -5px; margin-right: 6px"
            />{{ item.post_date }}
          </div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <p v-html="item.excerpt"></p>
        </q-card-section>
      </q-card>
    </div>
  </div>

  <div class="q-pa-md">
    <ss-paging v-model="postStore.current" :use-input="false" />
  </div>
</template>

<script setup>
import { useMonitoringStore } from 'src/stores/monitoring.js'
import { usePostStore } from 'src/stores/post'
import { usePagingStore } from 'ss-paging-vue'
import { computed } from 'vue'
import { addButton } from 'src/composables/common'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

const store = useMonitoringStore()
const postStore = usePostStore()
const paging = usePagingStore()
const $q = useQuasar()
const router = useRouter()

store.getPost(10)

const cardPadding = computed(() => ($q.screen.lt.md ? '' : 'q-pa-md'))

const data = computed(() => paging.state.data)

const viewPost = (id) => {
  if ($q.screen.lt.md) {
    router.push(`/post/view/${id}`)
  } else {
    postStore.getDetail(id, true)
  }
}
</script>
