<?php if (isset($this->allowFile) && $this->allowFile): ?>


  <!-- Main content -->
  <div class="main-content main-cls" main="usermanagement-since">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-lg-12">
            <div class="card shadow hover-translate-y-n10">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Since Management</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto"  data-toggle="modal" data-target="#modal-add-since">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Add since">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Add since</span>
                </button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-3" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>since</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <th>Code</th>
                        <th>since</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($data['since'] as $since) : ?>
                        <tr>
                          <td class="text-wrap align-middle text-center" id="since-<?= $this->e(strtolower($since['code'])) ?>">
                            <?= $this->e($since['code']) ?>
                          </td>
                          <td class="text-wrap align-middle text-center" id="name-<?= $this->e(strtolower($since['code'])) ?>">
                            <?= $this->e($since['name']) ?>
                          </td>
                          <td class="text-wrap align-middle d-flex justify-content-center">
                            <div class="m-1">
                              <a href="#" id="edit-since" data-since="<?= $this->e(strtolower($since['code'])) ?>" data-toggle="modal" data-target="#modal-edit-since" class="badge badge-success">
                                <i class="fas fa-fw fa-edit mr-2"></i>Change
                              </a>
                            </div>
                            <div class="m-1">
                              <a href="#" id="delete-since" data-since="<?= $this->e(strtolower($since['code'])) ?>" data-toggle="modal" data-target="#modal-delete-since" class="badge badge-danger">
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

  <!-- Modal Delete since -->
  <div class="modal modal-secondary fade" id="modal-delete-since" tabindex="-1" since="dialog" aria-labelledby="modal-delete-since" aria-hidden="true">
    <div class="modal-dialog" since="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to delete it now!</h5> 
            <p class="text-sm text-sm">since data <span class="since-delete"></span> will be deleted.</p>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="input-delete-since" data-since class="btn btn-danger">Delete Now</button>
            </div>
            <div class="m-2">
              <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit since -->
  <div class="modal fade" id="modal-edit-since" tabindex="-1" since="dialog" aria-labelledby="modal-edit-since" aria-hidden="true">
    <div class="modal-dialog" since="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-award"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Change since</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input class="form-control" type="text" placeholder="since" id="input-change-since" data-since="">
            <div class="invalid-feedback" id="msg-input-change-since"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" id="change-since">Change since</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add New since -->
  <div class="modal fade" id="modal-add-since" tabindex="-1" since="dialog" aria-labelledby="modal-add-since" aria-hidden="true">
    <div class="modal-dialog" since="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title d-flex align-items-center" id="modal-title-change-username">
            <div>
              <div class="icon icon-sm icon-shape icon-info rounded-circle shadow mr-3">
                <i class="fas fa-award"></i>
              </div>
            </div>
            <div>
              <h6 class="mb-0">Add new since</h6>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input class="form-control" id="new-since" type="text" placeholder="New since">
            <div class="invalid-feedback" id="msg-new-since"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="add-since">Add new since</button>
        </div>
      </div>
    </div>
  </div>

  <?php if (isset($data['since_edit'])) : ?>

  <?php endif; ?>

  <?php if (isset($data['since_delete'])) : ?>

  <?php endif; ?>

<?php endif; ?>