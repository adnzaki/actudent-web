/**
 * Actudent "Umpan balik" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const feedback = new Vue({
    el: '#feedback-content',
    mixins: [SSPaging, plugin],
    data: {
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false, uploadProgress: false,
            validImage: false, filename: '',
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
        },
        attachment: '',
    },
    mounted() {        
        this.getLanguageResources('AdminFeedback')
        this.runSelect2()        
        this.runICheck('blue')
        this.validateFile('upload-file')            
    },
    methods: {
        send() {
            let form = $('#sendFeedback'),
                url = `${this.feedback}send`

            let data = form.serialize()
            $.ajax({
                url: `${this.feedback}validasi`,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {                    
                    this.alert.header = ''
                    this.alert.text = this.lang.feedback_send_progress
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
                        this.alert.text = this.lang.feedback_error_text

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            this.alert.show = false
                            this.alert.class = 'bg-primary'
                            this.alert.header = ''
                            this.alert.text = ''
                        }, 3000);
                    } else {
                        let obj = this
                        let uploadImage = new Promise((resolve, reject) => {
                            if(obj.helper.filename !== '') {
                                obj.uploadRequest(`${this.feedback}upload-gambar`, 'upload-file')
                            }
                            // wait 3 seconds
                            setTimeout(resolve, 3000)
                        })

                        uploadImage.then(sendEmail)

                        function sendEmail() {
                            (obj.attachment !== '') ? url = `${url}/${obj.attachment}` : url = url
                            url = url
                            $.ajax({
                                url: url,
                                type: 'POST',
                                dataType: 'json',
                                data: data,
                                success: res => {
                                    obj.resetForm(form)
                                }
                            })
                        }
                    }
                },
                error: () => console.error('Network error')
            })
        },
        validateFile(formName) {
            let obj = this
            $('input[name=feedback_image]').on('change', function() {
                if(obj.error !== undefined) {
                    obj.error.feedback_image = ''
                }
                obj.helper.filename = $(this).val()
                obj.uploadRequest(`${obj.feedback}validasi-gambar`, formName, true)
            })
        },
        uploadRequest(url, formName, validate = false) {
            let form = document.forms.namedItem(formName),
                data = new FormData(form),
                req = new XMLHttpRequest

            // disable save button while attachment is being validated
            req.upload.addEventListener("progress", () => {
                this.error = {}
                this.helper.disableSaveButton = true
                this.helper.uploadProgress = true
            })

            req.open('POST', url, true)
            req.responseType = 'json'

            req.onload = () => {
                this.helper.uploadProgress = false
                if(req.response.msg === 'OK') {
                    this.error = {}
                    this.helper.disableSaveButton = false
                    
                    //this.helper.validImage = true
                    if(validate === false) {
                        this.attachment = req.response.attachment
                        document.getElementById(formName).reset()
                    }
                } else {
                    this.error = req.response
                    this.helper.disableSaveButton = true
                }
            }
            req.send(data)
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
            this.alert.text = this.lang.feedback_send_success
            this.helper.filename = ''
            this.attachment = ''

            setTimeout(() => {
                this.alert.show = false
                this.alert.header = ''
                this.alert.class = 'bg-primary'
                this.alert.text = ''
            }, 3500);
        },        
    },
    computed: {
        feedback() {
            if(actudentSection === 'admin') {
                return `${admin}umpan-balik/`
            } else {
                return `${guru}umpan-balik/`
            }
        }
    }
})