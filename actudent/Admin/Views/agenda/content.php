<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">{+ lang AdminAgenda.agenda_title +}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>            
            {+ include Actudent\Admin\Views\agenda\calendar +} 
            {+ include Actudent\Admin\Views\agenda\FormTambahAgenda +} 
            {+ include Actudent\Admin\Views\agenda\FormEditAgenda +}
        </div>
    </div>
</div>
