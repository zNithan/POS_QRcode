<?php PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด 404 Error ได้', 'redirect', 'SET'); ?>
<div id="page-head">
	<div class="text-center cls-content" style="margin-top: 100px;">
		<h1 class="error-code text-info">404</h1>
	</div>
</div>

<div id="page-content">
	<div class="text-center cls-content">
		<p class="h4 text-uppercase text-bold">Page Not Found!</p>
		<div class="pad-btm">
			Sorry, but the page you are looking for has not been found on our server.
		</div>
		<div class="row mar-ver">
			<form class="col-xs-12 col-sm-10 col-sm-offset-1" method="post" action="pages-search-results.html">
				<input type="text" placeholder="Search.." class="form-control error-search">
			</form>
		</div>
		<hr class="new-section-sm bord-no">
		<div class="pad-top"><a class="btn btn-primary" href="index.php">Return Home</a></div>
	</div>
</div>