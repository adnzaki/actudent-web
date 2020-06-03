const plugin = {
	data: {
		lang: [], switchery: null, swObject: null,
	},
	mounted() {
		this.swObject = document.getElementsByClassName('switchery-small')
	},
	filters: {
		substr: (value, num) => {
			if(!value) return ''
			let displayText
			(value.length > num) 
				? displayText = `${value.substr(0, num)}...`
				: displayText = value
			return displayText
		}
	},
	methods: {
		select2ShowPerPage(element, iCheck = '') {
			var obj = this
			$(element).on('select2:select', function (e) {
				var data = e.params.data
				obj.rows = data.id
				obj.showPerPage()
				if(iCheck !== '') {
					setTimeout(() => {
						obj.runICheck(iCheck)					
					}, 500);
				}
			})

		},
		getLanguageResources(files) {
			$.ajax({
				url: `${baseURL}/core/get-admin-lang/${files}`,
				dataType: 'json',
				success: data => {
					if(this.lang.length === 0) {
						this.lang = data
					} else {
						for(item in data) {
							this.lang[item] = data[item]
						}
					}
				}
			})
		},
		makeSentenceCase(words) {
			if(words !== undefined) {
				let sentence = words.split(' '),
					lowerText = []
				for(let i = 1; i < sentence.length; i++) {
					lowerText.push(sentence[i].toLowerCase())
				}
	
				return `${sentence[0]} ${lowerText.join(' ')}`				
			}
		},
		select2Ajax(url, elem) {
			$(elem).select2({
                ajax: {
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        }
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        }
                    },
                    cache: true
                }
            })
		},
		runSelect2() {
			(function (window, document, $) {
				'use strict';

				// Basic Select2 select
				$(".select2").select2();
			})(window, document, jQuery);
		},
		runDatePicker(el) {
			// Month & Year selectors
			return $(el).pickadate({
				selectMonths: true,
				selectYears: true,
				hiddenName: true,
				formatSubmit: 'yyyy-mm-dd',
				format: 'dddd, d mmmm yyyy',
				firstDay: 0,
			});
		},
		runTimePicker(el, interval = 30, min = [0,0], max = [23,30]) {
			return $(el).pickatime({
				format: 'HH:i',
				formatSubmit: 'HH:i',
				interval: interval,
				min: min, max: max
			});
		},
		runICheck(color) {
			$('.skin-square input').iCheck({
				checkboxClass: 'icheckbox_square-' + color,
				radioClass: 'iradio_square-' + color,
			});
		},
		runSwitchery(el) {
			// make sure that there is no existing Switchery
			if(this.swObject.length === 0) {
				var elem = document.querySelector(el)
				this.switchery = new Switchery(elem, {
					secondaryColor: '#6b6b6b',
					size: 'small'
				})
			}
		},
		resetSwitchery(edit = false) {
			if(edit) {
				let sw = document.querySelector('#all-day-edit')
				if(sw.checked) {
					sw.click()
				}
			} 
			
			// remove existing Switchery 
			let sw = this.swObject
			if(sw.length === 1) {
				sw[0].parentNode.removeChild(sw[0])
			}
        },
	},
	computed: {
		isSmallScreen() {
			return (window.innerWidth <= 576) ? true : false
		},
		auth() {
			if(actudentSection === 'admin') {
				return admin
			} else {
				return guru
			}
		}
	},
}