<div class="modal fade text-left" id="changelog-modal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true" v-if="showChangelog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> Changelog v{ac_version}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p v-if="changelogList.length === 1">{{ changelogList[0] }}</p>
                <li v-else style="list-style: inside; padding-bottom: 5px;"
                    v-for="(item, index) in changelogList.slice(1)" :key="index">{{ item }}
                </li>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal" @click="hideChangelog"> {+ lang Admin.jangan_tampilkan +}</button>
                <button type="button" class="btn btn-outline-success" data-dismiss="modal"> {+ lang Admin.tutup +}</button>
            </div>
        </div>
    </div>

</div>
