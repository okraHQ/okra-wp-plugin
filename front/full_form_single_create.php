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
					<span></span>
					<div class="form-group">
						<label for="short_code">Short URL</label>
						<input class="form-control" type="text" name="short_code" id="short_code" placeholder="Short URL" />
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