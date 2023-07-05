<template>
  <!-- <div class="col-6 col-md-2 q-mt-md q-pr-xs">
    <q-select
      outlined
      v-model="period.month"
      :options="monthOptions"
      dense
      @update:model-value="monthSelected"
    />
  </div>
  <div class="col-6 col-md-2 q-mt-md q-pl-xs">
    <q-select
      outlined
      v-model="period.year"
      :options="yearOptions"
      dense
      @update:model-value="yearSelected"
    />
  </div> -->
  <div class="col-6 col-md-2 q-mt-md q-pr-xs">
    <q-input v-model="dateStart" outlined dense readonly>
      <template v-slot:append>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy
            ref="qDateProxy"
            cover
            transition-show="scale"
            transition-hide="scale"
          >
            <q-date
              v-model="dateStartValue"
              @update:model-value="dateStartChanged"
              today-btn
            >
              <div class="row items-center justify-end">
                <q-btn
                  v-close-popup
                  :label="$t('tutup')"
                  color="primary"
                  flat
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>
  </div>
  <div class="col-6 col-md-2 q-mt-md q-pl-xs">
    <q-input v-model="dateEnd" outlined dense readonly>
      <template v-slot:append>
        <q-icon name="event" class="cursor-pointer">
          <q-popup-proxy
            ref="qDateProxy"
            cover
            transition-show="scale"
            transition-hide="scale"
          >
            <q-date
              v-model="dateEndValue"
              @update:model-value="dateEndChanged"
              today-btn
            >
              <div class="row items-center justify-end">
                <q-btn
                  v-close-popup
                  :label="$t('tutup')"
                  color="primary"
                  flat
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </q-icon>
      </template>
    </q-input>
  </div>
  <div class="col-12 col-md-2 q-mt-md q-px-xs mobile-hide">
    <q-btn
      color="secondary"
      style="width: 100%; padding-top: 7.5px; padding-bottom: 7.5px"
      icon="print"
      :label="$t('absensi_print_pdf')"
      :href="exportPdf()"
      target="_blank"
    />
  </div>
  <q-page-sticky
    position="bottom-right"
    :offset="fabPos"
    class="mobile-only force-elevated"
  >
    <q-btn
      fab
      icon="print"
      color="secondary"
      :href="exportPdf()"
      target="_blank"
    />
  </q-page-sticky>
</template>
<script>
import { ref } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { useQuasar, date } from 'quasar'
import { fabPos, draggingFab, moveFab } from 'src/composables/fab'
import { conf, monthList, t } from 'src/composables/common'

export default {
  setup() {
    const store = useSiabsenStore()
    const monthOptions = ref([])
    const period = ref({})
    const $q = useQuasar()

    const dateFormat = 'DD-MM-YYYY'
    const sendFormat = 'YYYY-MM-DD'
    const dateObj = new Date()
    const createDate = (type, format = 'YYYY/MM/DD') => {
      let year = dateObj.getFullYear(),
        month,
        startDate
      if (type === 'start') {
        if (dateObj.getMonth() === 0) {
          month = 12
          year -= 1
        } else {
          month = dateObj.getMonth()
        }

        startDate = '21'
      } else {
        month = dateObj.getMonth() + 1
        startDate = '20'
      }
      console.log(month)

      return date.formatDate(`${year}-${month}-${startDate}`, format)
    }

    const dateStart = ref(createDate('start', dateFormat))
    const dateEnd = ref(createDate('end', dateFormat))
    const dateStartValue = ref(createDate('start'))
    const dateEndValue = ref(createDate('end'))

    const dateStartChanged = (val) => {
      dateStart.value = date.formatDate(val, sendFormat)
      store.dateRangeStart = date.formatDate(val, sendFormat)
      getDetailPresence()
    }

    const dateEndChanged = (val) => {
      dateEnd.value = date.formatDate(val, sendFormat)
      store.dateRangeEnd = date.formatDate(val, sendFormat)
      getDetailPresence()
    }

    store.dateRangeStart = date.formatDate(dateStartValue.value, sendFormat)
    store.dateRangeEnd = date.formatDate(dateEndValue.value, sendFormat)

    const getDetailPresence = () => {
      store.getDetailPresence({
        staffId: 'null',
        userId: 'null',
        dateStart: store.dateRangeStart,
        dateEnd: store.dateRangeEnd,
      })
    }

    getDetailPresence()

    // const selectedPeriod = ref(date.formatDate(new Date, 'MM-YYYY'))
    // store.period = selectedPeriod.value

    // const getDetailPresence = () => {
    //   store.commit('siabsen/getDetailPresence', {
    //     staffId: 'null',
    //     userId: 'null',
    //     period: store.period
    //   })
    // }

    // getDetailPresence()

    // const monthSelected = model => {
    //   selectedPeriod.value = `${model.value}-${period.value.year}`
    //   store.period = selectedPeriod.value
    //   getDetailPresence()
    // }

    // const yearSelected = model => {
    //   selectedPeriod.value = `${period.value.month.value}-${model}`
    //   store.period = selectedPeriod.value
    //   getDetailPresence()
    // }

    // setTimeout(() => {
    //   let monthNum = parseInt(selectedPeriod.value.substring(0, 2))
    //   period.value = {
    //     month: { label: t('mon' + monthNum), value: monthNum },
    //     year: 2022
    //   }

    //   monthOptions.value = monthList()
    // }, 1500)

    const token = $q.cookies.get(conf.cookieName)

    const exportPdf = () => {
      return (
        `${conf.siabsenAPI}print-rekap-individu/null/null/` +
        `${store.dateRangeStart}/` +
        `${store.dateRangeEnd}/${token}`
      )
    }

    return {
      dateStartChanged,
      dateEndChanged,
      dateStart,
      dateEnd,
      dateStartValue,
      dateEndValue,
      monthOptions,
      yearOptions: [2020, 2021, 2022, 2023],
      fabPos,
      draggingFab,
      moveFab,
      period,
      // monthSelected, yearSelected,
      exportPdf,
    }
  },
}
</script>
