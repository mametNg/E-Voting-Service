<?php if (isset($this->allowFile) && $this->allowFile): ?>
	
	<!-- Begin Page Content -->
	<div class="container-fluid">

		<!-- Blocked Error Text -->
		<div class="py-5 my-5 d-flex justify-content-center">
			<div class="text-center">
				<img class="img-fluid px-3 px-sm-4 mb-4" style="width: 25rem;" src="<?= $this->base_url() ?>/assets/img/svg/illustrations/maintenance-service.svg" alt="">
				<p class="lead text-gray-800 mb-2">Under Maintenance</p>
				<p class="text-gray-500 mb-0">Website is under maintenance. Try again later.</p>
			</div>
		</div>

	</div>
	<!-- /.container-fluid --> 

<?php endif; ?>