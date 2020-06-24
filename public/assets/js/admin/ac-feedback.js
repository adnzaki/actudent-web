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
        // feedback: `${admin}umpan-balik/`,
        feedback: {
            app: `${this.auth}umpan-balik/`,
            user: `${admin}`
        },
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
    },
    mounted() {        
        this.getLanguageResources('AdminFeedback')
        this.runSelect2()        
        this.runICheck('blue')
        this.feedback.app = `${this.auth}umpan-balik/`
    },
    methods: {
        send() {
            let url, form
            let obj = this
            url = `${this.feedback.app}send`
            form = $('#sendFeedback')

            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {                    
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.feedback_send_progress
                    obj.alert.show = true
                    obj.helper.disableSaveButton = true
                },
                success: res => {
                    obj.helper.disableSaveButton = false
                    if(res.code === '500') {
                        obj.error = res.msg

                        // set error alert
                        obj.alert.class = 'bg-danger'
                        obj.alert.header = 'Error!'
                        obj.alert.text = obj.lang.feedback_error_text

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            obj.alert.show = false
                            obj.alert.class = 'bg-primary'
                            obj.alert.header = ''
                            obj.alert.text = ''
                        }, 3000);
                    } else {                        
                        obj.resetForm(form)
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
            
            this.alert.text = this.lang.feedback_send_success
            
            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true

            setTimeout(() => {
                this.alert.show = false
                this.alert.header = ''
                this.alert.class = 'bg-primary'
                this.alert.text = ''
            }, 3500);
        },
        
    },
    computed: {
        
    }
})