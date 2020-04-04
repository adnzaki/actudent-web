<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">{+ lang AdminMapel.mapel_title +}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload" @click="reloadData" ><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            {+ include Actudent\Admin\Views\mapel\DataMapel +}
            {+ include Actudent\Admin\Views\mapel\FormTambahMapel +}
            {+ include Actudent\Admin\Views\mapel\FormEditMapel +}
            {+ include Actudent\Admin\Views\mapel\DeleteConfirm +}
            {+ include Actudent\Admin\Views\mapel\alert +}
        </div>
    </div>
</div>
