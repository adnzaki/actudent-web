/**
 * Actudent "Langganan" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const langganan = new Vue({
    el: '#langganan-content',
    mixins: [plugin],
    data: {
        langganan: `${admin}langganan/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false, 
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
        },
        package: {},
        packagePrice: {
            free: 0,
            starter: 1713750,
            standard: 2378750,
            enhanced: 3376250,
            enterprise: ''
        },
        packageDetails: [],
        selectedPackage: {
            type: 'standard',
            duration: 2,
        }
    },
    mounted() {        
        this.getLanguageResources('AdminLangganan')
        this.getLanguageResources('AdminFeedback')
        this.runSelect2()        
        this.getPackage()
        setTimeout(() => {
            this.createPackageDetails('standard')
            this.packagePrice.enterprise = this.lang.subs_negotiations
        }, 500);
        this.selectPackage()
    },
    methods: {
        getPackage() {
            $.ajax({
                url: `${this.langganan}paket-layanan`,
                dataType: 'json',
                success: response => {
                    this.package = response
                }
            })
        },
        send() {
            let form = $('#formLangganan'),
                data = form.serialize()

            $.ajax({
                url: `${this.langganan}validasi`,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {                    
                    this.alert.header = ''
                    this.alert.text = this.lang.subs_send_progress
                    this.alert.show = true
                    this.helper.disableSaveButton = true
                },
                success: res => {
                    this.helper.disableSaveButton = false
                    if(res.code === '500') {
                        this.error = res.msg

                        // set error alert
                        this.alert.class = 'bg-danger'
                        this.alert.header = 'Error!'
                        this.alert.text = this.lang.subs_error_text

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            this.alert.show = false
                            this.alert.class = 'bg-primary'
                            this.alert.header = ''
                            this.alert.text = ''
                        }, 3000);
                    } else {                       
                        $.ajax({
                            url: `${this.langganan}kirim-permintaan`,
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: res => {
                                console.log(res)
                                this.resetForm(form)
                            }
                        })
                    }
                },
                error: () => console.error('Network error')
            })
        },
        resetForm(form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }
            
            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true
            this.alert.text = this.lang.subs_send_success

            setTimeout(() => {
                this.alert.show = false
                this.alert.header = ''
                this.alert.class = 'bg-primary'
                this.alert.text = ''
                $('#ajuanLanggananModal').modal('hide')
            }, 3500);
        }, 
        choosePackage(index) {
            this.packageDetails.forEach(item => {
                item.bgColor = 'bg-info'
            })

            this.packageDetails[index].bgColor = 'bg-success'
            this.selectedPackage.duration = index + 1
        },
        selectPackage() {
			var obj = this
			$('#selectPackage').on('select2:select', function (e) {
				var data = e.params.data
                obj.createPackageDetails(data.id)				
                obj.selectedPackage.type = data.id
                obj.selectedPackage.duration = 2
			})
		},
        createPackageDetails(type) {
            let durationText = year => {
                if(type === 'enterprise' || type === 'free') {
                    return `${year} ${this.lang.subs_year}`
                } else {
                    if(year === 1) {
                        return `${year} ${this.lang.subs_year}`
                    } else if(year === 2) {
                        return `${year} ${this.lang.subs_year} (Disc. 5%)`
                    } else if(year === 3) {
                        return `${year} ${this.lang.subs_year} (Disc. 10%)`
                    }
                }
            }

            setTimeout(() => {
                this.packageDetails = [
                    {
                        bgColor: 'bg-info',
                        price: this.countPrice(this.packagePrice[type], 1),
                        duration: `${durationText(1)}`,
                    },
                    {
                        bgColor: 'bg-success',
                        price: this.countPrice(this.packagePrice[type], 2),
                        duration: `${durationText(2)}`,
                    },
                    {
                        bgColor: 'bg-info',
                        price: this.countPrice(this.packagePrice[type], 3),
                        duration: `${durationText(3)}`,
                    },
                ]                          

            }, 200);
        },
        countPrice(price, duration) {
            if(typeof(price) === 'string') {
                return this.lang.subs_negotiations
            } else {
                if(price === 0) {
                    return 0
                } else {
                    let multiplePrice = price * duration
                    if(duration === 1) {
                        return multiplePrice
                    } else if(duration === 2) {
                        return multiplePrice - (multiplePrice * (5/100))
                    } else if(duration === 3) {
                        return multiplePrice - (multiplePrice * (10/100))
                    }
                }
            }
        }
    },
    computed: {
    }
})