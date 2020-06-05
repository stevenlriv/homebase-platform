<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/***
	 * Cache Explanations
	 * 
     * The general formula of how it works, its just when you just input data into a form, the data is saved 
     * into a database using javascript and it can be retrieved if needed.
     * 
     * HOW TO USE IT
     * 
	 * 1) The javascript code is requied on the footer/header of website for it to work. Also a root cache.php is required too
     * 
     * 2) On the action/files at the top you need to add a session with the unique identifier
     *      //Cache settings
     *      $_SESSION['CACHE_UNIQUE_NAME'] = 'unique-id';
     *      $cache_id_[IF-MORE-THAN-2-ADD-ANOTHER-IDENTIFIER] = $_SESSION['CACHE_UNIQUE_NAME'];
     *      $cache = get_cache($form_cache_[IDENTIFIER]);
     * 
     * 4) To us it in a in a for and input you will need to do add the class="form-cache" to the form and an unique id
     *      <form method="post" class="form-cache" id="<?php echo $cache_id; ?>">
     *      <input name="input-name" value="<?php form_print_value($cache, $array-from-database, 'input-name'); ?>" type="text">
     * 
     *      You can show the user a message to indicate that there is cache and they should save the data:
     *          if($cache && $form_error=='' && $form_info='') {
	 *				$form_info = 'Press the "Save Changes" button below to save your information.';
	 *			}
     *
     *			show_message($form_success, $form_error, $form_info);
     *
     * 5) Once you are making the form update/creation on the actions/ files and the update/creation is successful you need to delete that cache
     *      $form_success = 'Great, your profile has been updated.';
     *      delete_cache('unique-id');
	 */
	function form_get_value($cache, $database, $field_name) {
		return form_value($cache, $database, $field_name);	
	}

	function form_print_value($cache, $database, $field_name) {
		echo form_value($cache, $database, $field_name);
	}

	function form_value($cache, $database, $field_name) {
		$content = '';
		
		if($cache) {
			$content = get_cache_value($cache['form_name'], $field_name);
		}
		else {
			if(!empty($database[$field_name])) {
				$content = $database[$field_name];
			}
		}

		return $content;
    }
    
    function delete_cache($form_name) {
        global $db;

        $id_user = is_login_user()['id_user'];

        $q = $db->prepare ( "DELETE FROM xvls_cache WHERE form_name = ? AND id_user = ?" );
        $q->bind_param ( 'si', $form_name, $id_user);

        if ( $q->execute() ) {
            return true;
        }

        return false;
    }

    function update_cache($form_name, $content) {
		global $db;
        
        $id_user = is_login_user()['id_user'];

		$q = $db->prepare ( "UPDATE xvls_cache SET content = ? WHERE form_name = ? AND id_user = ?" );
		$q->bind_param ( 'ssi', $content, $form_name, $id_user );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
    }
    
    function get_cache_value($form_name, $field_name) {
        $cache = get_cache($form_name);

        if($cache) {
            $array = json_decode( $cache['content'] );

            foreach($array as $value) {
                if($value->name == $field_name) {
                    return $value->value;
                }
            }
        }

        return false;
    }

	function get_cache($form_name) {
		global $db;

        $id_user = is_login_user()['id_user'];

		$q = $db->prepare ( "SELECT * FROM xvls_cache WHERE form_name = ? AND id_user = ? LIMIT 1" );
		$q->bind_param ( 'si', $form_name, $id_user );

		$q->execute();
		$result = $q->get_result();
		
		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			return $o;	
		}
		$q->close();
		
		return false;
    }
    
	function new_cache($form_name, $content) {
		global $db;

        $id_user = is_login_user()['id_user'];
	
		$q = $db->prepare ( "INSERT INTO xvls_cache (id_user, form_name, content) VALUES (?, ?, ?)" );
		$q->bind_param ( 'iss', $id_user, $form_name, $content );
	
		if ( $q->execute() ) {	
			return true;
		}
		$q->close();
	
		return false;
    }
    
    function print_cache_js() {
?>
        <script>
            $(function() {
                /*--------------------------------------------------*/
	            /*  Cache Actions
	            /*--------------------------------------------------*/
	            $(".form-cache").on('change', function() {
		            var datastring = $(this).serializeArray();
                    var formName = $(this).attr("id");

		            $.ajax({
                        type: "POST",
			            url: "/cache.php",
                        data: { form_name: formName, content: datastring },
                        success: function(data) {
				            //console.log(data.response);
			            },
                    });
                });
            });
        </script>
<?php
    }
?>