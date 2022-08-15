import { t } from 'src/composables/common'

export default function(val) {
  const types = {
    none: t('siabsen_izin_full'),
    masuk: t('siabsen_izin_masuk'),
    pulang: t('siabsen_izin_pulang')
  }

  return types[ val ]
}