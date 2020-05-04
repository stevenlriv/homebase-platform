<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

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
    
?>