<div id="crypto-stats-3" class="row">
          <div class="col-xl-4 col-12">
            <div class="card normal-card crypto-card-3 pull-up {cardColor}">
              <div class="card-content">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-2">
                      <h1><i class="la la-calendar-check-o warning font-large-2" title="Siswa Hadir"></i></h1>
                    </div>
                    <div class="col-5 pl-2">
                      <h5 class="{cardTitleColor}">{+ lang AdminHome.dashboard_hadir +}</h5>
                      <h6 class="text-muted">{+ lang AdminHome.dashboard_persentase +}</h6>
                    </div>
                    <div class="col-5 text-right">
                      <h5 class="{cardTitleColor}">{presence} {+ lang AdminHome.dashboard_students +}</h5>
                      <h6 class="success darken-4">{presentPercent}%</h6>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <canvas id="btc-chartjs" class="height-75"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-12">
            <div class="card normal-card crypto-card-3 pull-up {cardColor}">
              <div class="card-content">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-2">
                      <h1><i class="la la-medkit blue-grey lighten-1 font-large-2" title="Sakit/Izin"></i></h1>
                    </div>
                    <div class="col-5 pl-2">
                      <h5 class="{cardTitleColor}">{+ lang AdminHome.dashboard_izin +}</h5>
                      <h6 class="text-muted">{+ lang AdminHome.dashboard_persentase +}</h6>
                    </div>
                    <div class="col-5 text-right">
                      <h5 class="{cardTitleColor}">{permit} {+ lang AdminHome.dashboard_students +}</h5>
                      <h6 class="success darken-4">{notePercent}%</h6>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <canvas id="eth-chartjs" class="height-75"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-12">
            <div class="card normal-card crypto-card-3 pull-up {cardColor}">
              <div class="card-content">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-2">
                      <h1><i class="la la-times-circle-o info font-large-2" title="Tanpa Keterangan"></i></h1>
                    </div>
                    <div class="col-5 pl-2">
                      <h5 class="{cardTitleColor}">{+ lang AdminHome.dashboard_absen +}</h5>
                      <h6 class="text-muted">{+ lang AdminHome.dashboard_persentase +}</h6>
                    </div>
                    <div class="col-5 text-right">
                      <h5 class="{cardTitleColor}">{absence} {+ lang AdminHome.dashboard_students +}</h5>
                      <h6 class="success darken-4">{absentPercent}%</i></h6>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <canvas id="xrp-chartjs" class="height-75"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>