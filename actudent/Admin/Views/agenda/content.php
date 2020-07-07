<div class="row">
    <div class="col-12">
        <div class="card {cardColor}">
            <div class="card-header {cardColor}">
                <h4 class="card-title {cardTitleColor}">{+ lang AdminAgenda.agenda_title +}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>            
            {+ include Actudent\Admin\Views\agenda\calendar +} 
            {+ include Actudent\Admin\Views\agenda\FormTambahAgenda +} 
            {if $_SESSION['userLevel'] === '1'}
                {+ include Actudent\Admin\Views\agenda\FormEditAgenda +}
            {elseif $_SESSION['userLevel'] === '2'}
                {+ include Actudent\Admin\Views\agenda\DetailAgenda +}
            {endif}
        </div>
    </div>
</div>
