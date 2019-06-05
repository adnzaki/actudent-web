const plugin = {
	data: {
		lang: '',
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
		runDatePicker() {
			// Month & Year selectors
			$('.pickadate-selectors').pickadate({
				labelMonthNext: 'Next month',
				labelMonthPrev: 'Previous month',
				labelMonthSelect: 'Pick a Month',
				labelYearSelect: 'Pick a Year',
				selectMonths: true,
				selectYears: true,
				min: true, // set minimal tanggal hari ini
				hiddenName: true,
				formatSubmit: 'yyyy-mm-dd',
			});
		},
		runTimePicker() {
			$('.pickatime').pickatime({
				format: 'HH:i',
				formatSubmit: 'HH:i',
				hiddenName: true,
			});
		},
		runICheck() {
			$('.skin-square input').iCheck({
				checkboxClass: 'icheckbox_square-red',
				radioClass: 'iradio_square-red',
			});
		},
		runSwitchery() {
			var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
			elems.forEach(function(html) {
				var switchery = new Switchery(html, {
					secondaryColor: '#6b6b6b',
					size: 'small'
				});
			});
		}
	},
}