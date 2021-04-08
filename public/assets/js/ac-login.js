/**
 * Actudent login page scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { appConfig as conf } from '../../ui/actudent.config.js'

const login = {
	el: '#login-content',
	mixins: [plugin],
    data: {
        username: '', password: '',
        msg: '', msgClass: 'error-text',
		showMsg: false, remember: false,
		wolesLogo: 'woles-logo',
		remember: [],
	},
	mounted() {
		this.getLanguageResources('AdminAuth')
		this.loginText = this.lang.silakan_login
	},
    methods: {
        validasi() {
			this.wolesLogo = 'woles-logo-down'
            this.msg = ''
            this.showMsg = true
            if (this.username === '' || this.password === '') {
            	this.msg = this.lang.userpassword_wajib
            } else {
                var data = $("#form-login").serialize()
                $.ajax({
                	url: `${this.auth}login/validasi`,
					type: 'post',
					dataType: 'json',
                	data: data,
                	beforeSend: () => {
                		this.msg = this.lang.mengautentikasi
                		this.msgClass = 'loading-text'
                	},
                	success: res => {
						if(res.msg === 'expired') {
							this.msgClass = 'error-text'
							this.msg = res.note
							setTimeout(() => {
								this.showMsg = false
								this.wolesLogo = 'woles-logo'
							}, 6000)
						} else {
							if (res.msg === 'valid') {
								this.msg = this.lang.login_sukses
								this.msgClass = 'success-text'
								window.location.href = conf.homeUrl()
							} else {
								this.msgClass = 'error-text'
								this.msg = this.lang.invalid_login
								setTimeout(() => {
									this.showMsg = false
									this.wolesLogo = 'woles-logo'
								}, 4000)
							}
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
}

new Vue(login)