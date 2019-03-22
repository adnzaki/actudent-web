Vue.component('form-error', {
	props: ['msg'],
	template: '<p class="error-text">{{ msg }}</p>'
})

Vue.component('alert-msg', {
	props: ['alertClass', 'header', 'text'],
	template: `<div :class="['alert', alertClass]" role="alert">
		<span class="text-bold-600">{{ header }}</span> {{ text }}
		</div>`
})