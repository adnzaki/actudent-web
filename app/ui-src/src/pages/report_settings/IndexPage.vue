<template>
  <div :class="wrapperPadding()">
    <LetterheadImage />
    <DailyJournal />
    <DailyPresence />
    <MonthlyPresence />
    <MonthlySummary />
    <SemesterSummary />
  </div>
</template>

<script>
import { wrapperPadding } from 'src/composables/screen'
import LetterheadImage from './LetterheadImage.vue'
import DailyJournal from './DailyJournal.vue'
import DailyPresence from './DailyPresence.vue'
import MonthlyPresence from './MonthlyPresence.vue'
import MonthlySummary from './MonthlySummary.vue'
import SemesterSummary from './SemesterSummary.vue'

export default {
  components: {
    LetterheadImage,
    DailyJournal,
    DailyPresence,
    MonthlyPresence,
    MonthlySummary,
    SemesterSummary,
  },
  setup() {
    return {
      wrapperPadding,
    }
  },
}
</script>
