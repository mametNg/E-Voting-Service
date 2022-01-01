<?php if (isset($this->allowFile) && $this->allowFile): ?>


  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement-role">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Roles Management</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto"  data-toggle="modal" data-target="#modal-add-role">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Role">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add Role</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Role</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>Role</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['role'] as $role) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center" id="role-<?= $this->e(strtolower($role['code'])) ?>">
                            <?= $this->e($role['code']) ?>
                          </td>
                          <td class="text-wrap align-middle" id="name-<?= $this->e(strtolower($role['code'])) ?>">
                            <?= $this->e($role['name']) ?>
                          </td>
                          <td class="text-wrap align-middle d-flex justify-content-center">
                            <div class="m-1">
                              <a href="#" id="edit-role" data-role="<?= $this->e(strtolower($role['code'])) ?>" data-toggle="modal" data-target="#modal-edit-role" class="badge badge-success">
                                <i class="fas fa-fw fa-edit mr-2"></i>Change
                              </a>
                            </div>
                            <div class="m-1">
                              <a href="#" id="delete-role" data-role="<?= $this->e(strtolower($role['code'])) ?>" data-toggle="modal" data-target="#modal-delete-role" class="badge badge-danger">
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

  <!-- Modal Delete Role -->
  <div class="modal modal-secondary fade" id="modal-delete-role" tabindex="-1" role="dialog" aria-labelledby="modal-delete-role" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5>
            <p class="text-sm text-sm"><span class="role-delete"></span> role data will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="input-delete-role" data-role class="btn btn-danger">Delete Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Role -->
  <div class="modal fade" id="modal-edit-role" tabindex="-1" role="dialog" aria-labelledby="modal-edit-role" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-award"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Change role</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input class="form-control" type="text" placeholder="Role" id="input-change-role" data-role="">
            <div class="invalid-feedback" id="msg-input-change-role"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="change-role">Change role</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add New Role -->
  <div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-labelledby="modal-add-role" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-award"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add new role</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input class="form-control" id="new-role" type="text" placeholder="New role">
            <div class="invalid-feedback" id="msg-new-role"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="add-role">Add new role</button>
        </div>
      </div>
    </div>
  </div>

  <?php if (isset($data['role_edit'])) : ?>

  <?php endif; ?>

  <?php if (isset($data['role_delete'])) : ?>

  <?php endif; ?>

<?php endif; ?>