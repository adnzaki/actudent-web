/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const siswa = new Vue({
    el: '#siswa-content',
    mixins: [SSPaging],
    data: {
        siswa: `${admin}SiswaController/`,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa()            
        }, 200);
    },
    methods: {
        getSiswa() {
            this.getData({
                limit: 10,
                offset: 0,
                orderBy: 'studentName',
                searchBy: 'studentNis-studentName-gradeName',
                sort: 'DESC',
                search: '',
                url: `${this.siswa}getDataSiswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})