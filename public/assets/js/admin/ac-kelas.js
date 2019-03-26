/**
 * Actudent Data Kelas scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const kelas = new Vue({
    el: '#kelas-content',
    mixins: [SSPaging, plugin],
    data: {
        kelas : `${admin}kelas/`,
        error: { 
            studentNis: '', studentName: '', 
            gradeName: '',
        },
        alert: {
            class: 'alert bg-danger', show: true,
            header: 'Sukses', text: 'heheheh',
        },
        flashAlert: {
            class: 'bg-success', show: false,
            title: 'Sukses', text: 'Data peserta didik baru berhasil disimpan', 
            icon: 'la-thumbs-o-up'
        },
        helper: {
            saveAndClose: false,
        },
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa()            
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminKelas')
    },
    methods: {
        getSiswa() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'grade_name',
                searchBy: 'grade_name',
                sort: 'DESC',
                search: '',
                url: `${this.kelas}get-kelas/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})