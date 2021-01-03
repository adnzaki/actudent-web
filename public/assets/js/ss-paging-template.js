/**
 * Smartscore Pagination
 * Sebuah paket library untuk mengolah data pagination
 *
 * @package     Pagination
 * @author      Adnan Zaki
 * @type        Libraries
 * @version     2.0.4
 * @package     Components
 */

export const Pager = {
    template: `
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="text-left pl-2 mb-3">
                <br><p>{{ rowRange }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12" v-if="showPaging">
            <div class="text-center mb-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center pagination-round">
                        <li v-bind:class="[linkClass]" @click="nav(first)">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(prev)">
                            <a class="page-link" href="#">Prev</a>
                        </li>
                        <li v-for="link in pageLinks" v-bind:class="[linkClass, activeLink(link)]" 
                            v-if="numLinks" @click="nav((link - 1))">
                            <a class="page-link" href="#">{{ link }}</a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(next)">
                            <a class="page-link" href="#">Next</a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(last)">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    `,
    props: [
        'showPaging', 'linkClass', 'pageLinks', 'numLinks', 'activeLink',
        'nav', 'first', 'prev', 'next', 'last', 'rowRange',
    ],
}