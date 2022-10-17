<?php if (isset($this->allowFile) && $this->allowFile): ?>


  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement-major">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Major Management</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto"  data-toggle="modal" data-target="#modal-add-major">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Major">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add Major</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Major</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Major</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['major'] as $major) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center" id="code-<?= $this->e(strtolower($major['code'])) ?>">
                            <?= $this->e($major['code']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="name-<?= $this->e(strtolower($major['code'])) ?>">
                            <?= $this->e($major['name']) ?>
                          </td>
                          <td class="text-wrap align-middle d-flex justify-content-center">
                            <div class="m-1">
                              <a href="#" id="edit-major" data-major="<?= $this->e(strtolower($major['code'])) ?>" data-toggle="modal" data-target="#modal-change-major" class="badge badge-success">
                                <i class="fas fa-fw fa-edit mr-2"></i>Change
                              </a>
                            </div>
                            <div class="m-1">
                              <a href="#" id="delete-major" data-major="<?= $this->e(strtolower($major['code'])) ?>" data-toggle="modal" data-target="#modal-delete-major" class="badge badge-danger">
                                <i class="fas fa-fw fa-trash mr-2"></i>Delete
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add New major -->
  <div class="modal fade" id="modal-add-major" tabindex="-1" role="dialog" aria-labelledby="modal-add-major" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user-tag"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add new major</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-0">
            <input type="text" class="form-control" id="new-major-name" placeholder="New major">
            <div class="text-danger small" id="msg-new-major-name"></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="add-new-major">Add new major</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Change major -->
  <div class="modal fade" id="modal-change-major" tabindex="-1" role="dialog" aria-labelledby="modal-change-major" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user-tag"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Change major</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-0">
            <input type="text" class="form-control" id="change-major-name" placeholder="Major name">
            <div class="text-danger small" id="msg-change-major-name"></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" data-major="" class="btn btn-sm btn-secondary" id="save-change-major">Save change major</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Major -->
  <div class="modal modal-secondary fade" id="modal-delete-major" tabindex="-1" role="dialog" aria-labelledby="modal-delete-major" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5>
            <p class="text-sm text-sm">data major <span class="major-name-delete font-weight-bolder"></span> will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-delete-major" data-major="" class="btn btn-danger">Delete Now</button>
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