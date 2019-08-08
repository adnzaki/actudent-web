const plugin = {
	data: {
		lang: '', switchery: null, swObject: null,
	},
	mounted() {
		this.swObject = document.getElementsByClassName('switchery-small')
	},
	methods: {
		select2ShowPerPage(element) {
			var obj = this
			$(element).on('select2:select', function (e) {
				var data = e.params.data
				obj.rows = data.id
				obj.showPerPage()
			})
		},
		getLanguageResources(files) {
			$.ajax({
				url: `${baseURL}index.php/core/get-admin-lang/${files}`,
				dataType: 'json',
				success: data => {
					this.lang = data
				}
			})
		},
		runSelect2() {
			(function (window, document, $) {
				'use strict';

				// Basic Select2 select
				$(".select2").select2();

				// Single Select Placeholder
				$(".select2-placeholder").select2({
					placeholder: "Select a state",
					allowClear: true
				});

				// Select With Icon
				$(".select2-icons").select2({
					minimumResultsForSearch: Infinity,
					templateResult: iconFormat,
					templateSelection: iconFormat,
					escapeMarkup: function (es) {
						return es;
					}
				});

				// Format icon
				function iconFormat(icon) {
					var originalOption = icon.element;
					if (!icon.id) {
						return icon.text;
					}
					var $icon = "<i class='la la-" + $(icon.element).data('icon') + "'></i>" + icon.text;

					return $icon;
				}

				// Multiple Select Placeholder
				$(".select2-placeholder-multiple").select2({
					placeholder: "Select State",
				});

				// Hiding the search box
				$(".hide-search").select2({
					minimumResultsForSearch: Infinity
				});

				// Limiting the number of selections
				$(".max-length").select2({
					maximumSelectionLength: 2,
					placeholder: "Select maximum 2 items"
				});


			})(window, document, jQuery);
		},
		runDatePicker(el) {
			// Month & Year selectors
			return $(el).pickadate({
				selectMonths: true,
				selectYears: true,
				min: true, // set minimal tanggal hari ini
				hiddenName: true,
				formatSubmit: 'yyyy-mm-dd',
			});
		},
		runTimePicker(el) {
			return $(el).pickatime({
				format: 'HH:i',
				formatSubmit: 'HH:i',
			});
		},
		runICheck() {
			$('.skin-square input').iCheck({
				checkboxClass: 'icheckbox_square-red',
				radioClass: 'iradio_square-red',
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
		resetSwitchery(elem) {
			// remove existing Switchery 
			let sw = this.swObject
			if(sw.length === 1) {
				sw[0].parentNode.removeChild(sw[0])
			}
        },
	},
}