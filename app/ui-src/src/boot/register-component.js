/**
 * Global component registration for Actudent app,
 * so we do not need to register them on each main component
 * 
 * @author    Adnan Zaki 
 * @copyright Wolestech (c) 2021
 */

import SearchBox from 'components/SearchBox.vue'
import RowDropdown from 'components/RowDropdown.vue'
import DeleteConfirm from 'components/DeleteConfirm.vue'
import SortIcon from 'components/SortIcon.vue'
import Error from 'components/Error.vue'
import SSPaging from 'components/SSPaging.vue'
import EmployeePhoto from 'src/pages/employee/EmployeePhoto.vue'
import DropdownSearch from 'components/DropdownSearch.vue'

export default ({ app }) => {
  app.component('search-box', SearchBox)
  app.component('row-dropdown', RowDropdown)
  app.component('delete-confirm', DeleteConfirm)
  app.component('sort-icon', SortIcon)
  app.component('error', Error)
  app.component('ss-paging', SSPaging)
  app.component('employee-photo', EmployeePhoto)
  app.component('dropdown-search', DropdownSearch)
}