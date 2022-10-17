<?php if (isset($this->allowFile) && $this->allowFile): ?>
	
	<!-- Begin Page Content -->
	<div class="container-fluid">

		<!-- 403 Error Text -->
		<div class="py-5 my-5">
			<div class="text-center">
				<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= $this->base_url() ?>/assets/img/svg/illustrations/404-error.svg" alt="">
				<p class="lead text-gray-800 mb-2">Page Not Found</p>
				<p class="text-gray-500 mb-0">This requested URL was not found on this server.</p>
				<a href="<?= $this->base_url() ?>">&larr; Back to Home</a>
			</div>
		</div>

	</div>
	<!-- /.container-fluid -->

<?php endif; ?>