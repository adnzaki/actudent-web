export default function () {
  return {
    postApi: 'post/',
    error: {},
    helper: {
      disableSaveButton: false,
      showSaveButton: true,
      showDeleteButton: false,
      deleteProgress: false,
    },
    postType: 'all',
    mypost: 0,
    showPost: false,
    detail: {},
    checkAll: false, selectedPosts: [],
    current: 1,
    postId: null,
    showForm: false, isEditForm: false,
    saveStatus: 500, deleteConfirm: false,
    searchTimeout: false,
    forms: {
      timeline_title: '',
      timeline_content: '',
      timeline_status: 'public',
      featured_image: '',
      gallery: [],
      imageGallery: ''
    },
    postInfo: {
      author: '',
      date: '',
      content: '',
    },
    galleryList: [],
    disableGalleryUploader: false
  }
}
