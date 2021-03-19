<template>
  <q-page class="flex flex-center">
    <div class="q-pa-md row items-start q-gutter-md">
      <q-card class="my-card bg-secondary text-white">
        <q-card-section>
          <div class="text-h6">Our Changing Planet</div>
          <div class="text-subtitle2">by John Doe</div>
        </q-card-section>

        <q-card-section>
          {{ mytext.greet }}
        </q-card-section>

        <q-separator dark />

        <q-card-actions>
          <q-btn flat @click="func.testGetData">Test me!</q-btn>
          <q-btn flat @click="mytext.greet = 'I have changed!'">Change the text!</q-btn>
        </q-card-actions>
      </q-card>

    </div>
    <!-- <img
      alt="Quasar logo"
      src="~assets/quasar-logo-full.svg"
    > -->
  </q-page>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { data, funcs } from '../composables/index-comp'

export default defineComponent({
  name: 'PageIndex',
  setup () {
    return {
      mytext: ref(data),
      func: funcs
    }
  }
})
</script>
