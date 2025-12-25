<?php PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Table List ได้', 'redirect', 'SET'); ?>
<div id="page-head">
	<div id="page-title">
		<h1 class="page-header text-overflow">Template Table Design</h1>
	</div>
</div>

<div id="page-content">
	<div class="row">
		<?php displayRaiseMsg(); ?>
		<div class="col-sm-6">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Striped rows</h3>
				</div>

				<!-- Striped Table -->
				<!--===================================================-->
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Invoice</th>
									<th>User</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53451</a></td>
									<td>Scott S. Calabrese</td>
									<td>$24.98</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53452</a></td>
									<td>Teresa L. Doe</td>
									<td>$564.00</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53453</a></td>
									<td>Steve N. Horton</td>
									<td>$58.87</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53454</a></td>
									<td>Charles S Boyle</td>
									<td>$97.50</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53455</a></td>
									<td>Lucy Doe</td>
									<td>$12.79</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53456</a></td>
									<td>Michael Bunr</td>
									<td>$249.99</td>
								</tr>
								<tr>
									<td><a href="#fakelink" class="btn-link">Order #53456</a></td>
									<td>Michael Bunr</td>
									<td>$249.99</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--===================================================-->
				<!-- End Striped Table -->

			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Hover rows</h3>
				</div>

				<!--Hover Rows-->
				<!--===================================================-->
				<div class="panel-body">
					<table class="table table-hover table-vcenter">
						<thead>
							<tr>
								<th class="min-width">Device</th>
								<th>Name</th>
								<th class="text-center">Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center"><i class="demo-pli-monitor-2 icon-2x"></i></td>
								<td>
									<span class="text-main text-semibold">Desktop</span>
									<br>
									<small class="text-muted">Last 7 days : 4,234k</small>
								</td>
								<td class="text-center"><span class="text-danger text-semibold">- 28.76%</span></td>
							</tr>
							<tr>
								<td class="text-center"><i class="demo-pli-laptop icon-2x"></i></td>
								<td>
									<span class="text-main text-semibold">Laptop</span>
									<br>
									<small class="text-muted">Last 7 days : 3,876k</small>
								</td>
								<td class="text-center"><span class="text-warning text-semibold">- 8.55%</span></td>
							</tr>
							<tr>
								<td class="text-center"><i class="demo-pli-tablet-2 icon-2x"></i></td>
								<td>
									<span class="text-main text-semibold">Tablet</span>
									<br>
									<small class="text-muted">Last 7 days : 45,678k</small>
								</td>
								<td class="text-center"><span class="text-success text-semibold">+ 58.56%</span></td>
							</tr>
							<tr>
								<td class="text-center"><i class="demo-pli-smartphone-3 icon-2x"></i></td>
								<td>
									<span class="text-main text-semibold">Smartphone</span>
									<br>
									<small class="text-muted">Last 7 days : 34,553k</small>
								</td>
								<td class="text-center"><span class="text-success text-semibold">+ 35.76%</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!--===================================================-->
				<!--End Hover Rows-->

			</div>
		</div>

		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Sample Toolbar</h3>
				</div>

				<!--Data Table-->
				<!--===================================================-->
				<div class="panel-body">
					<div class="pad-btm form-inline">
						<div class="row">
							<div class="col-sm-6 table-toolbar-left">
								<button id="demo-btn-addrow" class="btn btn-purple"><i class="demo-pli-add"></i> Add</button>
								<button class="btn btn-default"><i class="demo-pli-printer"></i></button>
								<div class="btn-group">
									<button class="btn btn-default"><i class="demo-pli-exclamation"></i></button>
									<button class="btn btn-default"><i class="demo-pli-recycling"></i></button>
								</div>
							</div>
							<div class="col-sm-6 table-toolbar-right">
								<div class="form-group">
									<input id="demo-input-search2" type="text" placeholder="Search" class="form-control" autocomplete="off">
								</div>
								<div class="btn-group">
									<button class="btn btn-default"><i class="demo-pli-download-from-cloud"></i></button>
									<div class="btn-group dropdown">
										<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
											<i class="demo-pli-gear"></i>
											<span class="caret"></span>
										</button>
										<ul role="menu" class="dropdown-menu dropdown-menu-right">
											<li><a href="#">Action</a></li>
											<li><a href="#">Another action</a></li>
											<li><a href="#">Something else here</a></li>
											<li class="divider"></li>
											<li><a href="#">Separated link</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">Invoice</th>
									<th>User</th>
									<th>Order date</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Tracking Number</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a class="btn-link" href="#"> Order #53431</a></td>
									<td>Steve N. Horton</td>
									<td><span class="text-muted"><i class="demo-pli-clock"></i> Oct 22, 2014</span></td>
									<td>$45.00</td>
									<td>
										<div class="label label-table label-success">Paid</div>
									</td>
									<td>-</td>
								</tr>
								<tr>
									<td><a class="btn-link" href="#"> Order #53432</a></td>
									<td>Charles S Boyle</td>
									<td><span class="text-muted"><i class="demo-pli-clock"></i> Oct 24, 2014</span></td>
									<td>$245.30</td>
									<td>
										<div class="label label-table label-info">Shipped</div>
									</td>
									<td><i class="demo-pli-mine"></i> CGX0089734531</td>
								</tr>
								<tr>
									<td><a class="btn-link" href="#"> Order #53433</a></td>
									<td>Lucy Doe</td>
									<td><span class="text-muted"><i class="demo-pli-clock"></i> Oct 24, 2014</span></td>
									<td>$38.00</td>
									<td>
										<div class="label label-table label-info">Shipped</div>
									</td>
									<td><i class="demo-pli-mine"></i> CGX0089934571</td>
								</tr>
								<tr>
									<td><a class="btn-link" href="#"> Order #53434</a></td>
									<td>Teresa L. Doe</td>
									<td><span class="text-muted"><i class="demo-pli-clock"></i> Oct 15, 2014</span></td>
									<td>$77.99</td>
									<td>
										<div class="label label-table label-info">Shipped</div>
									</td>
									<td><i class="demo-pli-mine"></i> CGX0089734574</td>
								</tr>
								<tr>
									<td><a class="btn-link" href="#"> Order #53435</a></td>
									<td>Teresa L. Doe</td>
									<td><span class="text-muted"><i class="demo-pli-clock"></i> Oct 12, 2014</span></td>
									<td>$18.00</td>
									<td>
										<div class="label label-table label-success">Paid</div>
									</td>
									<td>-</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--===================================================-->
				<!--End Data Table-->

			</div>
		</div>
	</div>
</div>