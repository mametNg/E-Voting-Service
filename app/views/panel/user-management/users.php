<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement-users">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-3">
            <div class="card card-stats bg-gradient-info">
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
            </div>
          </div>

          <div class="col-lg-3">
            <div class="card card-stats bg-gradient-success">
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

          <div class="col-lg-3">
            <div class="card card-stats bg-gradient-primary">
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

          <div class="col-lg-3">
            <div class="card card-stats bg-gradient-dark">
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

        <!-- <div class="row justify-content-between">
          <div class="col-lg-3">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3">
                <h5 class="pt-2">Class Count</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr class="text-center font-weight-bolder">
                        <th>Class</th>
                        <th>Count</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr class="text-center font-weight-bolder">
                        <th>Class</th>
                        <th>Count</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['class_count'] as $class) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center">
                            <?= $this->e($class['name']) ?>
                          </td>
                          <td class="text-wrap align-middle text-center">
                            <?= $this->e($class['total']) ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> -->

        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">User Management</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto"  data-toggle="modal" data-target="#modal-add-user">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add User">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add User</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr class="text-center font-weight-bolder">
                        <th>NIM</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Since</th>
                        <th>Class</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr class="text-center font-weight-bolder">
                        <th>NIM</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Since</th>
                        <th>Class</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['users'] as $role) : ?>
                        <tr>
                          <td id="nim-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle text-center">
                            <?= $this->e($role['nim']) ?>
                          </td>
                          <td id="name-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle">
                            <?= $this->e($role['name']) ?>
                          </td>
                          <td id="role-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle text-center">
                            <?= $this->e($role['role']) ?>
                          </td>
                          <td id="since-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle text-center">
                            <?= $this->e($role['since']) ?>
                          </td>
                          <td id="class-<?= $this->e($role['nim']) ?>" class="text-wrap align-middle text-center">
                            <?= $this->e($role['class']) ?>
                          </td>
                          <td class="text-wrap align-middle d-flex justify-content-center">
                            <div class="m-1">
                              <a href="#" id="open-change-user" data-user="<?= $this->e($role['nim']) ?>" data-toggle="modal" data-target="#modal-change-user" class="badge badge-success">
                                <i class="fas fa-fw fa-edit mr-2"></i>Change
                              </a>
                            </div>
                            <div class="m-1">
                              <a href="#" id="open-delete-user" data-user="<?= $this->e($role['nim']) ?>" data-toggle="modal" data-target="#modal-delete-user" class="badge badge-danger">
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

  <!-- Modal Add New User -->
  <div class="modal fade ml-4" id="modal-add-user" tabindex="-1" role="dialog" aria-labelledby="modal-add-user" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add new user</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="new-user-nim" class="form-control-label">NIM</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="new-user-nim" placeholder="NIM">
              </div>
              <div class="text-danger small" id="msg-new-user-nim"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="new-user-name" class="form-control-label">Full name</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="new-user-name" placeholder="Full name">
              </div>
              <div class="text-danger small" id="msg-new-user-name"></div>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="new-user-role" class="form-control-label">Role</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="new-user-role">
                  <option selected disabled>Choose a role</option>
                  <?php foreach ($data['role'] as $role) : ?>
                    <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-new-user-role"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="new-user-class" class="form-control-label">Class</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-users-class"></i></span>
                </div>
                <select class="custom-select" id="new-user-class">
                  <option selected disabled>Choose a class</option>
                  <?php foreach ($data['class'] as $class) : ?>
                    <option id="<?= $this->e($class['role_code']) ?>" value="<?= $this->e($class['class_code']) ?>"><?= $this->e($class['class']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-new-user-class"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="add-new-user">Add new role</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Change User -->
  <div class="modal fade ml-4" id="modal-change-user" tabindex="-1" role="dialog" aria-labelledby="modal-change-user" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-user"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Change user</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="change-data-nim" data-nim=""></div>

          <div class="form-group">
            <label for="change-user-name" class="form-control-label">Full name</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" id="change-user-name" placeholder="Full name">
            </div>
            <div class="text-danger small" id="msg-change-user-name"></div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="change-user-role" class="form-control-label">Role</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-fw fa-portrait"></i></span>
                </div>
                <select class="custom-select" id="change-user-role">
                  <option selected disabled>Choose a role</option>
                  <?php foreach ($data['role'] as $role) : ?>
                    <option value="<?= $this->e($role['code']) ?>"><?= $this->e($role['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-change-user-role"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="change-user-class" class="form-control-label">Class</label>
              <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-users-class"></i></span>
                </div>
                <select class="custom-select" id="change-user-class">
                  <option selected disabled>Choose a class</option>
                  <?php foreach ($data['class'] as $class) : ?>
                    <option id="<?= $this->e($class['role_code']) ?>" value="<?= $this->e($class['class_code']) ?>"><?= $this->e($class['class']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="text-danger small" id="msg-change-user-class"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="save-change-user">Save change user</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete User -->
  <div class="modal modal-secondary fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="modal-delete-user" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5>
            <p class="text-sm text-sm">user <span class="user-delete-name font-weight-bolder"></span> data will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="save-delete-user" data-nim="" data-role class="btn btn-danger">Delete Now</button>
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