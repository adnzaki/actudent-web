import { LoadingBar } from 'quasar'

export function runLoadingBar(options) {
  const defaultOptions = {
    color: 'red',
    size: '4px',
    position: 'top'
  }

  if(options === undefined) {
    options = {
      color: defaultOptions.color,
      size: defaultOptions.size,
      position: defaultOptions.position
    }
  }

  LoadingBar.setDefaults({
    color: options.color ?? defaultOptions.color,
    size: options.size ?? defaultOptions.size,
    position: options.position ?? defaultOptions.position
  })

  LoadingBar.start()
  LoadingBar.stop()
  LoadingBar.increment(0.22)
}
