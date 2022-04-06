Vue.component('form-error', {
	props: ['msg'],
	template: '<p class="error-text">{{ msg }}</p>'
})

Vue.component('alert-msg', {
	props: ['alertClass', 'header', 'text'],
	template: `<div :class="['alert alert-dismissible mb-2 fly-alert', alertClass]" role="alert">
		<strong>{{ header }}</strong> {{ text }}
		</div>`
})