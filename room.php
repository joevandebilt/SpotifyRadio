<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="room" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
		<h1>Queue A Song</h1>
		<h6 id="subHeader"></h6>
		
		<div class="my-4 row" id="tabsPane">
			<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active text-primary" id="search-tab" data-bs-toggle="tab" data-bs-target="#tabSearch" type="button" role="tab" aria-controls="Search" aria-selected="true">Search Song</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link text-primary" id="link-tab" data-bs-toggle="tab" data-bs-target="#tabLinks" type="button" role="tab" aria-controls="link" aria-selected="false">Exact Link</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link text-primary" id="link-tab" data-bs-toggle="tab" data-bs-target="#tabShare" type="button" role="tab" aria-controls="link" aria-selected="false">Share</button>
				</li>
			</ul>

			<div class="tab-content p-0 m-0" id="tabContent">

				<div class="tab-pane fade show active my-3 py-4" role="tabpanel" aria-labelledby="search-tab" id="tabSearch">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Search-Pane.html'); ?>					
				</div>
			
				<div class="tab-pane fade my-4 py4" role="tabpanel" aria-labelledby="link-tab" id="tabLinks">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Queue-Link.html'); ?>
				</div>

				<div class="tab-pane fade my-4 py4" role="tabpanel" aria-labelledby="link-tab" id="tabShare">
					<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Admin/Share-Panel.html'); ?>
				</div>

			</div>

		</div>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Now-Playing.html') ?>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Song-Toast.html') ?>

	</div>

</main>
