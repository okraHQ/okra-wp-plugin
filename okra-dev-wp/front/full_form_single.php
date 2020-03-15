<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
	<div class="row mt-5">
		<div class="col-md-2 col-lg-2"></div>
		<div class="col-md-8 col-lg-8">
			<form action="admin-post.php" method="post">
				<div class="bg-white card-body">
                    <input type="hidden" name="action" value="okra_form_single_save" />
                    <input type="text" class="d-none" value="<?php echo $form->id ?>" name="id" />
					<?php wp_nonce_field("okra_form_single_save") ?>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" value="<?php echo $form->name ?>" type="text" name="name" id="name" placeholder="Name" />
                    </div>
                    <div class="form-group">
                        <label for="page">Page</label>
                        <select class="form-control" name="page" id="page">
                            <?php echo $page_selected; ?>
                        </select>
                    </div>
                    <div class="mb-2">Products</div>
                    <div class="mb-2 form-check-inline">
						<?php echo $product_checked ?>
                    </div>
                </div>

                <div class="bg-white card-body mt-4">
                    <div class="form-group mt-3">
                        <label for="onClose">On Close</label>
                        <textarea row="10"  name="onClose" id="onClose" class="form-control okra-editor"><?php echo $form->onClose ?></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="onOpen">On Open</label>
                        <textarea row="10" name="onOpen" id="onOpen" class="form-control okra-editor"><?php echo $form->onOpen ?></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="beforeOpen">Before Open</label>
                        <textarea row="10" name="beforeOpen"   id="beforeOpen" class="form-control okra-editor"><?php echo $form->beforeOpen ?></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="beforeClose">Before Close</label>
                        <textarea row="10" name="beforeClose" id="beforeClose" class="form-control okra-editor"><?php echo $form->beforeClose ?></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="onSuccess">on Success</label>
                        <textarea row="10" name="onSuccess" value="<?php echo $form->onSuccess ?>" id="onSuccess" class="form-control okra-editor"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="onFailure">on Failure</label>
                        <textarea row="10" name="onFailure" id="onFailure" class="form-control okra-editor"><?php echo $form->onFailure ?></textarea>
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