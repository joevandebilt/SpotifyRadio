<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="privacy" class="DynamicLoad">
	<div class="d-grid m-3 text-start">
		
		<div class="m-3" id="infoPane">
			<h1>Privacy of your data</h1>
			<p>This site is not intended to gather data for any of it's users. Only a small subset of data is stored within the database and even that is deleted when an account is disconnected</p>
			<p>The information which is stored is as follows</p>
			<ul>
				<li>A randomly generated ID</li>
				<li>Your spotify Auth Token</li>
				<li>Your spotify Refresh Token (used to keep your session alive)</li>
				<li>Your Room name and Room Code</li>
			</ul>
			<p>I did this project for a bit of fun - I will not be storing any of your personal data, song choices or device information.</p>
			<p>If you want to review my source code, you can find it here <a href="https://github.com/joevandebilt/SpotifyRadio">https://github.com/joevandebilt/SpotifyRadio</a></p>
		</div>

	</div>
</main>