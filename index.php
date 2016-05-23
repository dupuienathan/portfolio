<?php

require_once 'framework/registry.php';

$registry->init();

?>
<html>
	<head>
		<title></title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="js/modernizr-custom-2.0.min.js"></script>
		<script src="js/alchemy-client.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					&nbsp;
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-3">
					Item Name:
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					Unit Price:
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					Total Price:
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					Item Quantity:
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="main-line"></div>
				</div>
			</div>
			<?php
				$res = $registry->db->select("*")->from("inventory")->join("item", "inventory.item_id = item.item_id")->get();
				foreach($res->result() as $row) {
			?>
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-3">
						<?=$row->item_name?>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<?=$row->item_price?>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<?=($row->item_price * $row->quanity)?>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<?=$row->quanity?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="line"></div>
					</div>
				</div>
			<?php
				}
			?>
		</div>
	</body>
	<script>
		
	</script>
</html>