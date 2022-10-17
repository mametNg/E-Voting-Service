<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <div class="main-content main-cls" main="quic-count">
    <section class="min-vh-100 d-flex align-items-center">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="mb-5 text-center">
              <h6 class="h3 font-weight-bolder">QUIC COUNT</h6>
              <p class="text-muted mb-0">Use Your Voting Rights. Choose Candidates Who Can Inspire Students.</p>
            </div>

            <div class="row justify-content-center row-cols-1 row-cols-md-3 g-4 mt-5">

              <?php foreach ($data['voting'] as $votingKey => $voting) : ?>
                <div class="col-lg">
                  <div class="card card-overlay text-white border-0 hover-shadow-lg hover-translate-y-n10">

                    <div class="d-flex border">
                      <?php foreach ($voting['user'] as $detailsCandidate) : ?>
                        <?php if (count($voting['user']) == 2) : ?>
                          <div>
                            <img src="<?= $this->base_url(); ?>/assets/img/candidate/original/<?= $this->e($detailsCandidate['image']); ?>" class="boder-0 rounded img-content" alt="...">
                          </div>
                        <?php else : ?>
                          <img src="<?= $this->base_url(); ?>/assets/img/candidate/thumbnail/<?= $this->e($detailsCandidate['image']); ?>" class="boder-0 rounded img-content" alt="...">
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                    <span class="mask bg-dark opacity-2"></span>
                    <div class="card-img-overlay-2">

                      <div class="m-2 ">
                        <button type="button" class="btn btn-dark btn-sm float-right p-2 border-0">
                          <span>Candidate number</span>

                          <span class="badge badge-primary">
                            <?= $this->e($voting['number']); ?>
                          </span>
                        </button>
                      </div>
                    </div>

                    <div class="card-img-overlay d-flex flex-column align-items-center p-0">
                      <div class="overlay-text w-75 mt-auto">
                        <div class="row mt-10 pt-5">
                          <?php foreach ($voting['user'] as $detailsCandidate) : ?>
                            <?php if (count($voting['user']) == 2) : ?>
                              <div class="col-6">
                                <span class="link link-underline-white font-weight-bold"><?= $this->e($detailsCandidate['name']) ?></span>
                                <p class="lead text-sm mt-2"><?= $this->e($detailsCandidate['role']) ?></p>
                              </div>
                            <?php else : ?>
                              <div class="col-lg-12">
                                <span class="link link-underline-white font-weight-bold"><?= $this->e($detailsCandidate['name']) ?></span>
                                <p class="lead text-sm mt-2"><?= $this->e($detailsCandidate['role']) ?></p>
                              </div>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </div>
                      </div>
                      <div class="overlay-actions w-100 card-footer mt-auto d-flex justify-content-between align-items-center p-0 bg-dark">
                        <button type="button" class="btn btn-dark btn-icon-label btn-block">
                          <span class="btn-inner--text">Total votes</span>
                          <span class="btn-inner--icon" id="<?= $this->e($votingKey) ?>"><?= $this->e($voting['votes']) ?></span>
                        </button>
                      </div>
                      
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

<?php endif; ?>