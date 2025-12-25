<?php PERMIT::_PERMIT(_MODULE_, 'module|mp', 'สามารถเปิด Invoice & Print ได้', 'redirect', 'SET'); ?>
<div id="page-head" class="noprint">
	<div id="page-title">
		<h1 class="page-header text-overflow">Template Table Design</h1>
	</div>
</div>

<div id="page-content">
	<div class="row">
		<?php displayRaiseMsg(); ?>
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="invoice-masthead">
						<div class="invoice-text">
							<h3 class="h1 text-uppercase text-thin mar-no text-primary">INVOICE</h3>
						</div>
						<div class="invoice-brand" style="white-space:nowrap">
							<div class="invoice-logo">
								<img src="template/version2018/img/logo.png">
							</div>
						</div>
					</div>

					<div class="invoice-bill row">
						<div class="col-sm-6 text-xs-center">
							<address>
								<strong class="text-main">Marc Dominic</strong><br>
								485 Red Wood Street<br>
								San Jose CA 95125<br>
								United States
							</address>
						</div>
						<div class="col-sm-6 text-xs-center">
							<table class="invoice-details">
								<tbody>
									<tr>
										<td class="text-main text-bold">Invoice #</td>
										<td class="text-right text-info text-bold">INV-54968-17</td>
									</tr>
									<tr>
										<td class="text-main text-bold">Order Status</td>
										<td class="text-right"><span class="badge badge-success">Complete</span></td>
									</tr>
									<tr>
										<td class="text-main text-bold">Billing Date</td>
										<td class="text-right">Jun 11, 2016</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<hr class="new-section-sm bord-no">

					<div class="row">
						<div class="col-lg-12 table-responsive">
							<table class="table table-bordered invoice-summary">
								<thead>
									<tr class="bg-trans-dark">
										<th class="text-uppercase">Description</th>
										<th class="min-col text-center text-uppercase">Qty</th>
										<th class="min-col text-center text-uppercase">Price</th>
										<th class="min-col text-right text-uppercase">Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<strong>Logo Design Package</strong>
											<small>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</small>
										</td>
										<td class="text-center">1</td>
										<td class="text-center">$80.55</td>
										<td class="text-right">$161.1</td>
									</tr>
									<tr>
										<td>
											<strong>One year domain registration</strong>
											<small>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit seacula quarta decima et quinta decima.</small>
										</td>
										<td class="text-center">4</td>
										<td class="text-center">$10.99</td>
										<td class="text-right">$43.96</td>
									</tr>
									<tr>
										<td>
											<strong>Shared hosting template</strong>
											<small>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut</small>
										</td>
										<td class="text-center">2</td>
										<td class="text-center">$17.00</td>
										<td class="text-right">$34.00</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="clearfix">
						<table class="table invoice-total">
							<tbody>
								<tr>
									<td><strong>Sub Total :</strong></td>
									<td>$538.06</td>
								</tr>
								<tr>
									<td><strong>TAX :</strong></td>
									<td>$73.98</td>
								</tr>
								<tr>
									<td><strong>TOTAL :</strong></td>
									<td class="text-bold h4">$612.04</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="text-right no-print">
						<a href="javascript:window.print()" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a>
						<a href="#" class="btn btn-primary">Confirm Payment</a>
					</div>
				</div>
			</div>
		</div>



	</div>
</div>