<?php if (isset($this->allowFile) && $this->allowFile): ?>



  <!-- Main content -->
  <div class="main-content main-cls" main="web-setting">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">

          <div class="col-lg-8">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Activation Code</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto" data-toggle="modal" data-target="#modal-ceate-new-code">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="New code">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">New code</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">

                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>CODE</th>
                        <th>STATUS</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>CODE</th>
                        <th>STATUS</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['activation'] as $activation) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center">
                            <?= $this->e($activation['code']) ?>
                          </td>
                          <td class="text-wrap align-middle text-center">
                            <?= ($this->e($activation['status']) == 1 ? "Expired":"Ready") ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3">
                <h5 class="pt-2">Web Setting</h5>
              </div>
              <ul class="list-group list-group-flush">
                <?php foreach ($data['setting'] as $setting) : ?>
                  <li class="list-group-item">
                    <span id="setting-<?= $this->e(strtolower($setting['code'])) ?>"><?= $this->e($setting['name']) ?></span>
                    <a href="#" id="web-setting" data-status="<?= ($setting['status'] == 1 ? "1":"0") ?>" data-setting="<?= $this->e(strtolower($setting['code'])) ?>" data-toggle="modal" data-target="#modal-web-setting" class="badge <?= ($setting['status'] == 1 ? "badge-success":"badge-danger") ?> float-right">
                      <?= ($setting['status'] == 1 ? "Active":"Inactive") ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Web Setting -->
  <div class="modal modal-secondary fade" id="modal-web-setting" tabindex="-1" role="dialog" aria-labelledby="modal-web-setting" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-warning">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to <span class="change-web-setting-status"></span> <span class="change-web-setting-name"></span>!</h5>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-web-setting" data-status="" data-setting="" class="btn btn-warning">Delete Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <!-- Modal Web Setting -->
  <div class="modal modal-secondary fade" id="modal-ceate-new-code" tabindex="-1" role="dialog" aria-labelledby="modal-ceate-new-code" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-warning">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to create new activation code!</h5>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="create-new-code" class="btn btn-warning">Create New</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>