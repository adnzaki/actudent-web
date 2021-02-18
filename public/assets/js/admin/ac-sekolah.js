/**
 * "Sekolah" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2021
 * @link        https://actudent.com
 */

const sekolah = new Vue({
    el: '#sekolah-content',
    mixins: [plugin],
    data: {
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, 
        },
        school: {},
    },
    mounted() {
        this.getLanguageResources('Sekolah')
        this.getSchoolData()
    },
    methods: {
        getSchoolData() {
            fetch(`${this.sekolah}data`)
                .then(response => response.json())
                .then(data => { this.school = data })
        }
    },
    computed: {
        sekolah() {
            if(actudentSection === 'admin') {
                return `${admin}sekolah/`
            } else {
                return `${guru}sekolah/`
            }
        }
    }
})