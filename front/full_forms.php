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
                        <a class="btn btn-sm btn-primary" href="<?php echo admin_url() . '?page=okra_wordpress_plugin&&add=true' ?>">Add new</a>
                    </div><br /><br />
                    <table class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>Shortcode</th>
                            <th>Shortcode call</th>
                            <th>Name</th>
                            <th>Page</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            $count = 1;
                            foreach( $forms as $form ){
                                ?>

                                <tr>
                                    <td><?php echo $form->short_code ?></td>
                                    <td>[okra_modal id=<?php echo $form->id ?> btn-text=<?php echo $form->btn_text ?>]</td>
                                    <td><?php echo $form->name ?></td>
                                    <td><?php echo $form->page ?></td>
                                    <td>
                                        <a href="<?php echo admin_url() . '?page=okra_wordpress_plugin&&id='.$form->id.'' ?>" class="btn btn-sm btn-secondary text-white">Edit</a>
                                        <a href="<?php echo admin_url() . '?page=okra_wordpress_plugin&&delId='.$form->id.'' ?>" class="btn btn-sm btn-danger text-white">Delete</a>
                                    </td>
                                </tr>

                                <?php
                                $count++;
                            }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-2"></div>
    </div>
</div>