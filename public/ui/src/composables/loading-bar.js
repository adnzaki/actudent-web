import { LoadingBar } from 'quasar'

export function runLoadingBar(options) {
  if(options === undefined) {
    options = {
      color: 'blue',
      size: '5px',
      position: 'top'
    }
  }

  LoadingBar.setDefaults({
    color: options.color ?? 'blue',
    size: options.size ?? '5px',
    position: options.position ?? 'top'
  })

  LoadingBar.start()
  LoadingBar.stop()
  LoadingBar.increment(0.22)
}
