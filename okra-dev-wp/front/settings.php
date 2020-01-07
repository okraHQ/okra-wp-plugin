<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
	<div class="mt-5">

        <div class="row">
            <div class="col-md-2 col-lg-2"></div>
            <div class="col-md-8 col-lg-8">

                <?php echo $output; ?>

                <form action="admin-post.php" method="post" class="mx-auto">
                    <div class="">
                        <input type="hidden" name="action" value="okra_settings_save" />
			            <?php wp_nonce_field("okra_settings_save") ?>
                        <div class="form-group">
                            <label for="client_id">Client name</label>
                            <input type="text" value="<?php echo $clientName ?>" class="form-control" id="client_id" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="env">Env</label>
                            <select id="env" class="form-control" name="env" >
	                            <?php
	                            foreach ( $env as $item ) {
		                            if($item["value"] === $env_){
			                            ?>
                                            <option selected value="<?php echo $item['value'] ?>"><?php echo $item["property"] ?></option>
			                            <?php
		                            }else{
			                            ?>
                                        <option value="<?php echo $item['value'] ?>"><?php echo $item["property"] ?></option>
			                            <?php
		                            }
	                            }
	                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="key">Key</label>
                            <input type="text" value="<?php echo $key ?>" id="key" name="key" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="token">Token</label>
                            <input type="text" id="token" value="<?php echo $token; ?>" name="token" class="form-control" />
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
</div>