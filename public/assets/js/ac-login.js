/**
 * Actudent login page scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const login = new Vue({
    el: '#login-content',
    data: {
        auth: `${admin}AuthController/`,
        username: '', password: '',
        msg: '', msgClass: 'error-text',
        showMsg: false, remember: false,
    },
    methods: {
        validasi() {
            this.msg = ''
            this.showMsg = true
            if (this.username === '' || this.password === '') {
            	this.msg = 'Silakan masukkan username dan password anda'
            } else {
                var data = $("#form-login").serialize()
                $.ajax({
                	url: `${this.auth}validasi`,
                	type: 'post',
                	data: data,
                	beforeSend: () => {
                		this.msg = 'Mengautentikasi...'
                		this.msgClass = 'loading-text'
                	},
                	success: msg => {
                		if (msg === 'valid') {
                			this.msg = 'Login berhasil, mengalihkan...'
                			this.msgClass = 'success-text'
                			window.location.href = `${admin}home`
                		} else {
                			this.msgClass = 'error-text'
                			this.msg = 'Username atau password yang anda masukkan salah'
                			setTimeout(() => {
                				this.showMsg = false
                			}, 4000)
                		}
                	},
                	error: () => {
                		alert('Tidak dapat terhubung ke server')
                		this.showMsg = ''
                		this.showMsg = false
                	}
                })
            }
        }
    },
})