import { usePagingStore } from "./ss-paging"
import { useParentStore } from "./parent"

export default { 
  paging: usePagingStore(),
  parent: useParentStore(),
}
