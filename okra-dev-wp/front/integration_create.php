<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
	<div class="row mt-5">
		<div class="col-md-2 col-lg-2"></div>
		<div class="col-md-8 col-lg-8">
			<form action="admin-post.php" method="post">
				<div class="">
                    <input type="hidden" name="action" value="okra_integration_create" />
                    
					<?php wp_nonce_field("okra_integration_create") ?>
                    <div class="form-group">
                        <label for="company">Integration</label>
                        <select id="company" name="company" class="form-control">
                            <option value="paystack">paystack</option>
                            <option value="quickteller">quickteller</option>
                            <option value="flutterware">flutterware</option>
                            <option value="voguepay">voguepay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dev_key">Dev key</label>
                        <input class="form-control" type="text" name="dev_key" id="dev_key" />
                    </div>
                    <div class="form-group">
                        <label for="live_key">Live key</label>
                        <input class="form-control" type="text" name="live_key" id="live_key" />
                    </div>
                    <div class="form-group">
                        <label for="env">Env</label>
                        <input class="form-control" type="text" name="env" id="env" />
                    </div>

                    
                    <div class="mt-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>

                </div>
			</form>
		</div>
		<div class="col-md-2 col-lg-2"></div>
	</div>
</div>