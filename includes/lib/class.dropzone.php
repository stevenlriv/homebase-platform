<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/***
	 * Dropzone Explanations
	 * 
     * The general formula is to upload images, and we use an integration with cache
     * 
     * HOW TO USE IT
     * 
	 * 1) The javascript code for every dropzone is requied on the footer/header of website for it to work. Also a root images-[dropzone].php is required too per dropzone
     * 
     * 2) On the action/files at the top you need to add a session with the unique identifier
	 * 		//Cache settings
     *      $_SESSION['CACHE_IMG_UNIQUE_NAME'] = 'unique-id';
	 * 
     * 3) On the views/ files at the top you need to add the cache with its unique identifier
     *      //Cache settings
     * 	    $form_cache_img_id = $_SESSION['CACHE_IMG_UNIQUE_NAME'];
     *      $cache_img = get_cache($form_cache_img_id);
     * 
     * 4) To use it outside of a <form> add a new dropzone_box(). Inside the form, were you want to put the box 
     *      you will need to a dropzone_form with a different id to the dropzone_box
     * 
     *      You can show the user a message to indicate that there is cache and they should save the data:
     *          if($cache_img && $form_error=='') {
	 *				$form_info = 'Press the "Save Changes" button below to save your information.';
	 *			}
     *
     *			show_message($form_success, $form_error, $form_info);
     *
     * 5) Once you are making the form update/creation on the actions/ files and the update/creation is successful you need to delete that cache
     *      $form_success = 'Great, your profile has been updated.';
     *      delete_cache('unique-id');
	 */
    function dropzone_js($dropzone_id, $jquery_id, $form_id, $get_url, $post_url = '/images.php') {
    ?>
        <script>
            $( "#<?php echo $jquery_id; ?>" ).appendTo( "#<?php echo $form_id; ?>" );

            $("#<?php echo $dropzone_id; ?>").dropzone({
		        acceptedFiles: "image/*",
		        dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
		        init: function () {		
			        var th = this; //to access this "global" inside functions
			
			        //function to add files  
        	        this.addCustomFile = function(file, thumbnail_url , responce){
            	        // Push file to collection
            	        this.files.push(file);
            	        // Emulate event to create interface
            	        this.emit("addedfile", file);
            	        // Add thumbnail url
            	        this.emit("thumbnail", file, thumbnail_url);
            	        // Add status processing to file
            	        this.emit("processing", file);
            	        // Add status success to file AND RUN EVENT success from responce
            	        this.emit("success", file, responce , false);
            	        // Add status complete to file
            	        this.emit("complete", file);
			        }

			        //function to load current files
			        this.loadAllFiles = function(){
				        $.get('<?php echo $get_url; ?>', function(data) {
 					        $.each(data.content, function(key,value){	  
					 	        //+ one on key so "image 0" is not shown
					 	        key = key + 1;
					 	        th.addCustomFile(
            				        // File options
            				        {
                				        // flag: processing is complete
                				        processing: true,
                				        // flag: file is accepted (for limiting maxFiles)
                				        accepted: true,
                				        // name of file on page
                				        name: "Image " + key,
                				        // image size
                				        size: 2123455,
                				        // image type
                				        //type: 'image/jpeg',
                				        // flag: status upload
								        status: Dropzone.SUCCESS,
								        imageURL: value,

								        //file comes from a server
								        isServer: true,
							        },
				
            				        // Thumbnail url
            				        value,
            				        // Custom responce for event success
            				        {
                				        status: "success"
            				        }
        				        );
 					        });
				        });
			        }

			        //we load all the files the first time
			        this.loadAllFiles();

			        //We establish the variable to know when we will need to reload files
			        var loadTheFiles = true;

			        //Once are the files are done, we let them load again
			        this.on("queuecomplete", function(file) {
				        loadTheFiles = true;
				        //$("#dropzone-text").text(''); //remove text
			        });

			        //dropzone refresh manager
			        this.on("complete", function(file) {
				        //console.log(file);
				        if(file.isServer) {
					        //alert('file comes from server');
				        }
				        else {
					        //alert('new file upload'); 				

					        //Remove the current files from the dropzone
					        //$("#dropzone-text").text('Processing images...'); //show message

					        this.files.forEach(function(entry) {
						        var _ref = entry.previewElement;

						        //console.log('File' + entry.name);
						        try {
							        _ref.parentNode.removeChild(entry.previewElement);
						        }
						        catch(err) {
  							        //console.log(err);
						        }
					        });

					        //We load the files again, but from the server
					        if(loadTheFiles) {
						        th.loadAllFiles();
						        loadTheFiles = false; //used to avoid multiple files load
					        }
				        }
			        });
    	        },
		        addRemoveLinks: true,
		        removedfile: function(file) {
			        var imageURL = file.imageURL; 
			   
   			        $.ajax({
     			        type: 'POST',
     			        url: '<?php echo $post_url; ?>',
     			        data: {action: 'remove-img', content: imageURL},
				        success: function(data) {
					        //console.log(data.response);
				        },
			        });
			   
   			        var _ref;
    		        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
		        },
            });
        </script>
    <?php
    }

    function dropzone_box($name, $dropzone_id, $jquery_id, $design = 'submit-section', $post_url = '/images.php') {
		$form_info = 'While uploading multiple images at the same time, they might disappear for a bit. Is better to upload them one by one or in pairs. To delete an image, click on it or hover and then press the Remove file link.';
    ?>
		<div id="<?php echo $jquery_id; ?>">

			<?php
				if($design == 'submit-section') {
			?>
				<h3><?php echo $name; ?> <i class="tip" data-tip-content="Removing an image is a permanent action"></i> </h3>
				<br />
				<?php show_message('', '', $form_info); ?>
				<div class="submit-section">
					<form action="<?php echo $post_url; ?>" class="dropzone" id="<?php echo $dropzone_id; ?>"></form>
				</div>

			<?php
				}
				else {
			?>
				<div class="col-md-12">
					<h5><?php echo $name; ?> <i class="tip" data-tip-content="Removing an image is a permanent action"></i> </h5>
					<br />
					<?php show_message('', '', $form_info); ?>
					<form action="<?php echo $post_url; ?>" class="dropzone" id="<?php echo $dropzone_id; ?>"></form>
				</div>
			<?php
				}
			?>
		</div>
    <?php
    }

    function dropzone_form($form_id) {
        echo '<div id="'.$form_id.'"></div>';
    }
?>