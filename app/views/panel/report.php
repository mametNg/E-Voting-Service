<?php if (isset($this->allowFile) && $this->allowFile): ?>



  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body bg-gradient-primary">
                <div class="text-center">

                  <div class="icon text-white rounded-circle icon-shape icon-xl">
                    <i class="fas fa-users"></i>
                  </div>

                  <h5 class="mt-2 mb-0 text-white">Users Report</h5>
                  <span class="d-block text-white text-sm">All Users, Roles, Class, Sinces</span>
                  <a href="<?= $this->base_url("/".$this->get_url()[0]."/".$this->get_url()[1]."/users"); ?>" class="btn btn-white rounded-pill mt-4">
                    Open Report
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body bg-gradient-success">
                <div class="text-center">

                  <div class="icon text-white rounded-circle icon-shape icon-xl">
                    <i class="fas fa-box-ballot"></i>
                  </div>

                  <h5 class="mt-2 mb-0 text-white">Voting Report</h5>
                  <span class="d-block text-white text-sm">All Users, Roles, Class, Sinces</span>
                  <a href="<?= $this->base_url("/".$this->get_url()[0]."/".$this->get_url()[1]."/voting"); ?>" class="btn btn-white rounded-pill mt-4">
                    Open Report
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php endif; ?>