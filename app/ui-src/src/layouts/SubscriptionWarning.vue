<template>
  <div class="q-px-md q-pt-md q-gutter-sm" v-if="subs.left <= 7">
    <q-banner rounded dense inline-actions class="bg-negative text-white">      
      <p class="q-mt-md" style="line-height: 5px !important">
        <strong>{{ getLang.peringatan }}</strong>
        {{ subs.text }} {{ subs.date }}.
      </p>
    </q-banner>
  </div>
</template>

<script>
import { inject, computed, ref, onMounted } from 'vue'
import { core } from 'boot/axios'
import { bearerToken } from 'src/composables/validate-token'

export default {
  name: 'SubscriptionWarning',
  setup() {
    const getLang = computed(() => inject('textLang')).value  

    const subs = ref({})

    onMounted(() => {
      core.get('get-subscription-warning', {
        headers: { Authorization: bearerToken }
      })
        .then(response => {
          subs.value = response.data
        })
        .catch(err => console.log(err))
    })

    return { 
      getLang,
      subs
    }
  }
}
</script>