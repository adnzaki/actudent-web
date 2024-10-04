import { t } from 'src/composables/common'

export function permitType(val) {
  const types = {
    sick: t('siabsen_permit_sick'),
    outstation: t('siabsen_permit_outstation'),
    others: t('siabsen_permit_others'),
  }

  return types[val]
}

export function permitPresence(val) {
  const types = {
    none: t('siabsen_izin_full'),
    masuk: t('siabsen_izin_masuk'),
    pulang: t('siabsen_izin_pulang'),
  }

  return types[val]
}
