<template>
  <div class="row q-col-gutter-sm" v-if="!showSpinner">
    <div class="col-12 col-md-6">
      <q-card class="q-mb-md">
        <q-card-section>
          <div class="text-h6 text-capitalize q-mb-md">
            {{ $t('dashboard_high_rank') }}
          </div>
          <q-list bordered separator v-if="highest.length > 0">
            <q-item
              clickable
              v-ripple
              v-for="(item, index) in highest"
              :key="index"
            >
              <q-item-section>
                <q-item-label>{{ item.grade_name }}</q-item-label>
                <q-item-label caption>
                  {{ $t('dashboard_presence_level') }}: {{ item.present }}%
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
          <p v-else>{{ $t('presence_not_available') }}</p>
        </q-card-section>
      </q-card>
    </div>
    <div class="col-12 col-md-6">
      <q-card class="q-mb-md">
        <q-card-section>
          <div class="text-h6 text-capitalize q-mb-md">
            {{ $t('dashboard_low_rank') }}
          </div>
          <q-list bordered separator v-if="lowest.length > 0">
            <q-item
              clickable
              v-ripple
              v-for="(item, index) in lowest"
              :key="index"
            >
              <q-item-section>
                <q-item-label>{{ item.grade_name }}</q-item-label>
                <q-item-label caption>
                  {{ $t('dashboard_presence_level') }}: {{ item.present }}%
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
          <p v-else>
            {{ $t('presence_not_available') }}
          </p>
        </q-card-section>
      </q-card>
    </div>
  </div>
  <div class="row" v-else>
    <div class="col-12">
      <q-card class="q-mb-md">
        <q-card-section
          ><spinner-orbit
            text="Calculating presence percentage of class groups..."
        /></q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { admin } from 'boot/axios'
import { bearerToken, t } from 'src/composables/common'
import { onBeforeRouteLeave } from 'vue-router'

export default {
  setup() {
    const highest = ref([])
    const lowest = ref([])
    const showSpinner = ref(true)

    const getPercentage = () => {
      admin
        .get('home/absen-harian-kelas', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          highest.value = data.highest
          lowest.value = data.lowest
          showSpinner.value = false
        })
    }

    getPercentage()
    const intervalId = setInterval(getPercentage, 22000)
    onBeforeRouteLeave(() => clearInterval(intervalId))

    return {
      lowest,
      highest,
      showSpinner,
    }
  },
}
</script>
