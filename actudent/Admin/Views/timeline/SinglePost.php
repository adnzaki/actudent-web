<div class="row" v-if="helper.postReader">
    {+ include Actudent\Admin\Views\timeline\PostReader +}
    {+ include Actudent\Admin\Views\timeline\OtherPosts +}
</div>
<button type="button" class="btn btn-warning box-shadow-4
    floating round btn-min-width mr-1 mb-1" v-if="helper.postReader"
    @click="closePostReader">
    <strong>
        <span class="la la-arrow-left extend-la"></span>
    </strong>
</button>