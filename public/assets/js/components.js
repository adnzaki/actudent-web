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

Vue.component('flash-alert', {
	props: ['alertClass', 'title', 'text', 'icon'],
	template: ` <div :class="['alert fly-alert alert-icon-left alert-dismissible mb-2', alertClass]" role="alert">
					<span class="alert-icon"><i :class="['la', icon]"></i></span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>{{title}}</strong> {{text}}
				</div>`
})