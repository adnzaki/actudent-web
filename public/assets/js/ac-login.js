/**
 * Actudent login page scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const login = new Vue({
	el: '#login-content',
	mixins: [plugin],
    data: {
        auth: `${admin}AuthController/`,
        username: '', password: '',
        msg: '', msgClass: 'error-text',
        showMsg: false, remember: false,
	},
	mounted() {
		this.getLanguageResources()
	},
    methods: {
        validasi() {
            this.msg = ''
            this.showMsg = true
            if (this.username === '' || this.password === '') {
            	this.msg = this.lang.userpassword_wajib
            } else {
                var data = $("#form-login").serialize()
                $.ajax({
                	url: `${this.auth}validasi`,
                	type: 'post',
                	data: data,
                	beforeSend: () => {
                		this.msg = this.lang.mengautentikasi
                		this.msgClass = 'loading-text'
                	},
                	success: msg => {
                		if (msg === 'valid') {
                			this.msg = this.lang.login_sukses
                			this.msgClass = 'success-text'
                			window.location.href = `${admin}home`
                		} else {
                			this.msgClass = 'error-text'
                			this.msg = this.lang.invalid_login
                			setTimeout(() => {
                				this.showMsg = false
                			}, 4000)
                		}
                	},
                	error: () => {
                		alert(this.lang.login_error)
                		this.showMsg = ''
                		this.showMsg = false
                	}
                })
            }
        }
    },
})