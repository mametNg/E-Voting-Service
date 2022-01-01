<?php if (isset($this->allowFile) && $this->allowFile): ?>



  <!-- Main content -->
  <div class="main-content main-cls" main="stats">
    <div class="docs-content">
      <!-- Page content -->
      <div class="container-fluid">
        <div class="row justify-content-between">
          <div class="col-lg-12">
            <h1>STATS</h1>

            <!-- Bar Chart -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex">
                <h5 class="pt-2">Quic Count</h5>
                <button type="button" class="btn btn-sm btn-primary btn-icon-label ml-auto" data-toggle="modal" data-target="#modal-reset-votes">
                  <span class="btn-inner--icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Vote">
                    <i class="fas fa-sync-alt"></i>
                  </span>
                  <span class="btn-inner--text d-none d-lg-block">Reset Vote</span>
                </button>
              </div>
              <div class="card-body">
                <div class="chart-bar">
                  <canvas id="myBarChart"></canvas>
                </div>
                <?php foreach ($data['voting'] as $voting => $votingDetails) : ?>
                  <div class="d-none" id="chart-name">Candidate Number <?= $this->e($votingDetails['number']) ?></div>
                  <div class="d-none" data-candidate="<?= $this->e($voting) ?>" id="chart-votes"><?= $this->e($votingDetails['votes']) ?></div>
                <?php endforeach ; ?>
                <div class="d-none" id="chart-total"><?= $this->e($data['total_user']['total']) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Reset Vote -->
  <div class="modal modal-secondary fade" id="modal-reset-votes" tabindex="-1" role="dialog" aria-labelledby="modal-reset-votes" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <div class="icon text-danger">
              <i class="fas fa-exclamation-circle fa-3x opacity-8"></i>
            </div>
            <h5 class="mt-4">Are you sure you want to reset votes!</h5>
          </div>
          <div class="d-flex justify-content-center">
            <div class="m-2">
              <button type="button" id="reset-votes" data-class="" class="btn btn-danger">Reset Now</button>
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