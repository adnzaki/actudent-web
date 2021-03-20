<template>
  <q-page class="flex flex-center">
    <div class="q-pa-md row items-start q-gutter-md">
      <q-card class="my-card bg-secondary text-white">
        <q-card-section>
          <div class="text-h6">Our Changing Planet</div>
          <div class="text-subtitle2">by John Doe</div>
        </q-card-section>

        <q-card-section>
          {{ d.greet }}
        </q-card-section>

        <q-separator dark />

        <q-card-actions>
          <q-btn flat @click="m.testGetData">Test me!</q-btn>
          <q-btn flat @click="d.greet = 'I have changed!'">Change the text!</q-btn>
        </q-card-actions>
      </q-card>

    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { data, methods } from '../../composables/index-comp'

export default defineComponent({
  name: 'PageIndex',
  setup () {
    return {
      d: ref(data),
      m: methods
    }
  }
})
</script>
