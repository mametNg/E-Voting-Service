<?php if (isset($this->allowFile) && $this->allowFile): ?>

  <div class="air-badge position-fixed zindex-102"></div>
  
  <!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
  <script src="<?= $this->base_url(); ?>/assets/js/purpose.core.js"></script>
  <!-- Page JS -->
  <script src="<?= $this->base_url(); ?>/assets/libs/swiper/dist/js/swiper.min.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/libs/typed.js/lib/typed.min.js"></script>
  <script src="<?= $this->base_url() ?>/assets/libs/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= $this->base_url() ?>/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="<?= $this->base_url() ?>/assets/js/plugins/datatables.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/libs/highlightjs/highlight.pack.min.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/libs/clipboard/dist/clipboard.min.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/libs/jsencrypt/dist/jsencrypt.min.js"></script>
  <!-- Purpose JS -->
  <script src="<?= $this->base_url(); ?>/assets/js/purpose.js"></script>
  <!-- Basic JS - remove it when starting your project -->
  <script src="<?= $this->base_url() ?>/assets/js/basic.js"></script>
  <!-- Features All Pages -->
  <script src="<?= $this->base_url(); ?>/assets/js/features/function.js"></script>
  <script src="<?= $this->base_url(); ?>/assets/js/features/login.js"></script>
</body>

</html>
<?php endif; ?>