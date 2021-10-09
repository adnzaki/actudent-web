<template>
  <q-card class="my-card q-mb-md">
    <q-card-section>
      <div class="text-h6 text-capitalize">Riwayat Pembaruan</div>
      <div class="row q-mt-md">
        <p>Pembaruan yang terdapat dalam build saat ini 
          <q-badge color="blue" class="text-subtitle2"><strong>{{ buildVersion }}</strong></q-badge>:
          <ul>
            <li v-for="(item, index) in updates" :key="index">
              <strong>{{ item.key }} - </strong>{{ item.desc }}                 
            </li>
          </ul>
          <strong class="text-primary cursor-pointer" @click="showOlder = !showOlder">
            <u>Pembaruan sebelumnya</u>
          </strong>
        </p>
      </div>
      <div v-if="showOlder">
        <div class="row" v-for="(item, index) in olderUpdates" :key="index">
          <p>Build <q-badge color="blue"><strong>{{ index }}</strong></q-badge>:
            <ul>
              <li v-for="(v, k) in olderUpdates[index]" :key="k">
                <strong>{{ v.key }} - </strong>{{ v.desc }}
              </li>
            </ul>
          </p>          
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { appConfig as conf } from '../../../actudent.config'
import * as latestUpdates from './latest-updates'
import indonesia from './id-updates'
import english from './en-updates'

export default {
  name: 'Updates',
  setup () {
    const $q = useQuasar()
    const olderUpdates = {
      indonesia, english
    }

    return {
      updates: latestUpdates[$q.cookies.get(conf.userLang)],
      olderUpdates: olderUpdates[$q.cookies.get(conf.userLang)],
      showOlder: ref(false)
    }
  }
}
</script>
