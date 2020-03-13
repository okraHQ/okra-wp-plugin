<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
	<div class="row mt-5">
		<div class="col-md-2 col-lg-2"></div>
		<div class="col-md-8 col-lg-8">
			<form action="admin-post.php" method="post">
				<div class="bg-white card-body">
					<input type="hidden" name="action" value="okra_form_single_create" />
					<?php wp_nonce_field("okra_form_single_create") ?>
					<div class="form-group">
						<label for="name">Name</label>
						<input class="form-control" type="text" name="name" id="name" placeholder="Name" />
					</div>
					<div class="form-group">
						<label for="page">Page</label>
						<select class="form-control"  name="page" id="page">
							<?php
							foreach ($pages as $page){
								?>
								<option value="<?php echo $page->post_title ?>"><?php echo $page->post_title; ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="mb-2">Products</div>
					<div class="mb-2 form-check-inline">
						<?php echo $product_checked ?>
					</div>
					<div class="mt-3">
                      <label for="corporate">Corporate</label>
					  <input type="checkbox" name="corporate" value="corporate" checked>
                    </div>
				</div>

				<div class="bg-white card-body mt-4">
					<div class="form-group mt-3">
						<label for="onClose">On Close</label>
						<textarea row="5"  name="onClose" id="onClose" class="form-control okra-editor"></textarea>
					</div>
					<div class="form-group mt-3">
						<label for="onOpen">On Open</label>
						<textarea row="5" name="onOpen" id="onOpen" class="form-control okra-editor"></textarea>
					</div>
					<div class="form-group mt-3">
						<label for="beforeOpen">Before Open</label>
						<textarea row="5" name="beforeOpen"   id="beforeOpen" class="form-control okra-editor"></textarea>
					</div>
					<div class="form-group mt-3">
						<label for="beforeClose">Before Close</label>
						<textarea row="5" name="beforeClose" id="beforeClose" class="form-control okra-editor"></textarea>
					</div>
					<div class="form-group mt-3">
						<label for="onSuccess">on Success</label>
						<textarea row="5" name="onSuccess" id="onSuccess" class="form-control okra-editor"></textarea>
					</div>
					<div class="form-group mt-3">
						<label for="onFailure">on Failure</label>
						<textarea row="5" name="onFailure" id="onFailure" class="form-control okra-editor"></textarea>
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

<script>

    var textareas = document.querySelectorAll(".okra-editor");

	for (var i = 0; i < textareas.length; i++) {
    	CodeMirror.fromTextArea(textareas[i], {
        	lineNumbers: true,
        	theme: "cm-s-eclipse"
     	});
	}    
</script>