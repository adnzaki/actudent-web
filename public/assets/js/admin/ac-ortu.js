/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const siswa = new Vue({
    el: '#ortu-content',
    mixins: [SSPaging, plugin],
    data: {
        ortu: `${admin}orang-tua/`,
        error: { 
            
        },
        alert: {
            class: 'alert-danger', show: false,
            header: 'Sukses', text: 'heheheh',
        },
        daftarKelas: '',
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getOrtu()            
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminOrtu')
    },
    methods: {
        getOrtu() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'parent_father_name',
                searchBy: 'parent_family_card-parent_father_name-parent_mother_name-parent_phone_number',
                sort: 'ASC',
                search: '',
                url: `${this.ortu}get-ortu/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})