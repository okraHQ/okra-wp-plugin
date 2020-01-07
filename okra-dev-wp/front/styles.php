<div class="wrap">
	<?php include (plugin_dir_path(dirname(__FILE__)). "includes/header.php"); ?>
    <div class="mt-5">

        <div class="row">
            <div class="col-md-2 col-lg-2"></div>

            <div class="col-md-8 col-lg-8">

                <?php echo $output; ?>

                <form action="admin-post.php" method="post" class="mx-auto">
                    <div class="">
                        <input type="hidden" name="action" value="okra_styles_save" />
						<?php wp_nonce_field("okra_styles_save") ?>
                        <div class="form-group">
                            <label for="styles">Custom styles</label>
                            <textarea tabindex="-1" notab="notab" id="styles" class="form-control cm-s-eclipse" rows="20" name="styles" placeholder="Paste your styles here"><?php if(isset($styles->styles)) { echo $styles->styles; } ?></textarea>
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

<script>

    var textarea = document.getElementById("styles");

    var editor = CodeMirror.fromTextArea(textarea, {
        lineNumbers: true,
        theme: "cm-s-eclipse"
    });
    
</script>