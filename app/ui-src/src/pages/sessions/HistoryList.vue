<template>
  <div class="q-pa-md">
    <q-list bordered separator v-for="(item, index) in data" :key="index">
      <q-item clickable>
        <q-item-section>
          <q-item-label>{{ item.platform }}</q-item-label>
          <q-item-label caption lines="3"
            >IP: {{ item.ip_address }} <br />({{ item.location }}). <br />
            ISP: {{ item.isp }}</q-item-label
          >
        </q-item-section>

        <q-item-section side>
          <q-item-label caption>{{ item.date }}</q-item-label>
          <q-item-label caption>{{ item.time }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
    <ss-paging v-model="store.current" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePagingStore } from 'ss-paging-vue'
import { useSessionStore } from 'src/stores/sessions'

const store = useSessionStore()
const paging = usePagingStore()
const data = computed(() => paging.state.data)
store.getHistory()
</script>
