<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
    <div class="row">
        <div class="col-md-2 col-lg-2"></div>
        <div class="col-md-8 col-lg-8">
            <div class="mt-5 mx-auto">
	            <div>
                    <?php echo $output ?>
                </div>
                <div class="">
                    <div class="float-lg-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo admin_url() . 'admin.php?page=okra_integration&&add=true' ?>">Add new</a>
						<button data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary ml-2">Code integration</button>
                    </div><br /><br />
                    <table class="table table-striped text-center">
                        <thead>
							<tr>
								<th>Company</th>
								<th>Dev Key</th>
								<th>Live Key</th>
								<th>Env</th>
								<th>Action</th>
							</tr>
                        </thead>
							<?php

								foreach($integrations as $item ){
									?>
									<tr>
									<td><?php echo $item->company ?></td>
									<td><?php echo $item->dev_api_key ?></td>
									<td><?php echo $item->live_api_key ?></td>
									<td><?php echo $item->env ?></td>
									<td>
										<?php

											if($item->status){
												?>
												
												<a href="<?php echo admin_url() . 'admin.php?page=okra_integration&&status='.$item->id ?>" class="btn btn-sm btn-success">Disable</a>
												
												<?php
											}else{
												
												?>

												<a href="<?php echo admin_url() . 'admin.php?page=okra_integration&&status='.$item->id ?>" class="btn btn-sm btn-secondary">Enable</a>
												
												<?php

											}

										?>

										<a href="<?php echo admin_url() . 'admin.php?page=okra_integration&&delete='.$item->id ?>" class="btn btn-sm btn-danger">Delete</a>
									</td>
									</tr>
									<?php
								}

							?>
						<tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2"></div>
    </div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Integrations</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
			<code><?php echo $code; ?></code>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>