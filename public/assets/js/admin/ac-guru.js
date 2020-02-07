/**
 * Actudent Data Guru scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const guru = new Vue({
    el: '#guru-content',
    mixins: [SSPaging, plugin],
    data: {
        guru : `${admin}guru/`,
        error: { 
            teacher_id: '', teacher_Name: '', 
            teacher_phone: '',
        },
        alert: {
            class: 'alert bg-danger', show: true,
            header: 'Sukses', text: 'heheheh',
        },
        flashAlert: {
            class: 'bg-success', show: false,
            title: 'Sukses', text: 'Data Guru berhasil disimpan', 
            icon: 'la-thumbs-o-up'
        },
        helper: {
            saveAndClose: false,
        },
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getGuru()            
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminGuru')
    },
    methods: {
        getGuru() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'teacher_name',
                searchBy: 'teacher_name',
                sort: 'DESC',
                search: '',
                url: `${this.guru}get-guru/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})