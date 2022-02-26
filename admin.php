<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php'); ?>

<main id="authorize" class="DynamicLoad">
	<div class="d-grid my-3 text-center">	

		<div class="m-2 row" id="tabsPane">
			<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active text-primary" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#tabDashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link text-primary" id="share-tab" data-bs-toggle="tab" data-bs-target="#tabShare" type="button" role="tab" aria-controls="share" aria-selected="false">Share</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link text-primary" id="debug-tab" data-bs-toggle="tab" data-bs-target="#tabDebug" type="button" role="tab" aria-controls="debug" aria-selected="false">Debug</button>
				</li>
			</ul>

			<div class="tab-content p-0 m-0" id="tabContent">

				<div class="tab-pane fade show active mt-3" role="tabpanel" aria-labelledby="dashboard-tab" id="tabDashboard">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Admin/Connection-Panel.php'); ?>					
				</div>
			
				<div class="tab-pane fade mt-3" role="tabpanel" aria-labelledby="share-tab" id="tabShare">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Admin/Share-Panel.php'); ?>
				</div>

				<div class="tab-pane fade mt-3" role="tabpanel" aria-labelledby="debug-tab" id="tabDebug">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Admin/Debug-Panel.php'); ?>
				</div>

			</div>

		</div>
	</div>
</main>