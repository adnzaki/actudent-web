import { Notify } from 'quasar'

export function flashAlert(message, color = 'positive', position = 'top') {
  Notify.create({
    message,
    position,
    color,
  })
}