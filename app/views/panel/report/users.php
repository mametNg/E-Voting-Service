<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Main content -->
  <div class="main-content main-cls" main="report-users">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-6">

            <a href="<?= $this->base_url("/".$this->get_url()[0]."/".$this->get_url()[1]."/".$this->get_url()[2]."/all-users"); ?>" target="_blank" class="card card-stats bg-gradient-info">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['users']) ?></span>
                    <span class="text-white">All Users</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-user"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>

          </div>

          <div class="col-lg-6">
            <div class="card card-stats bg-gradient-success" type="button" data-toggle="modal" data-target="#modal-role">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['role']) ?></span>
                    <span class="text-white">Roles</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-user-tag"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card card-stats bg-gradient-primary" type="button" data-toggle="modal" data-target="#modal-class">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['class']) ?></span>
                    <span class="text-white">Class</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-portrait"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card card-stats bg-gradient-dark" type="button" data-toggle="modal" data-target="#modal-sinces">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="d-block h5 text-white mr-2 mb-1"><?= count($data['since']) ?></span>
                    <span class="text-white">Sinces</span>
                  </div>
                  <div>
                    <div class="icon text-white icon-sm mt-3">
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal Since -->
  <div class="modal fade ml-4" id="modal-sinces" tabindex="-1" role="dialog" aria-labelledby="modal-sinces" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Since Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-since">
                <option selected disabled>Choose a since</option>
                <?php foreach ($data['since'] as $since) : ?>
                  <option value="<?= $this->e($since['code']) ?>"><?= $this->e($since['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-since"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal class -->
  <div class="modal fade ml-4" id="modal-class" tabindex="-1" role="dialog" aria-labelledby="modal-class" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Class Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-class">
                <option selected disabled>Choose a class</option>
                <?php foreach ($data['class'] as $class) : ?>
                  <option value="<?= $this->e($class['code']) ?>"><?= $this->e($class['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-class"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal roles -->
  <div class="modal fade ml-4" id="modal-role" tabindex="-1" role="dialog" aria-labelledby="modal-role" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Role Report</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
              </div>
              <select class="custom-select" id="report-user-role">
                <option selected disabled>Choose a role</option>
                <?php foreach ($data['role'] as $role) : ?>
                  <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-danger small" id="msg-report-user-role"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>