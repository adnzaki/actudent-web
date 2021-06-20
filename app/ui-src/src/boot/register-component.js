/**
 * Global component registration for Actudent app,
 * so we do not need to register them on each main component
 * 
 * @author Adnan Zaki
 */

import SearchBox from 'components/SearchBox'
import RowDropdown from 'components/RowDropdown'
import DeleteConfirm from 'components/DeleteConfirm'
import SortIcon from 'components/SortIcon'
import Error from 'components/Error'

export default ({ app }) => {
  app.component('search-box', SearchBox)
  app.component('row-dropdown', RowDropdown)
  app.component('delete-confirm', DeleteConfirm)
  app.component('sort-icon', SortIcon)
  app.component('error', Error)
}