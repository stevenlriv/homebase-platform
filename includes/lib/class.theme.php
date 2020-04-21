<?php

 function show_message($success = '', $error = '') {

    $type = '';

    if(!empty($success)) {
        $type = 'success ';
        $message = $success;
    }
    else {
        $type = 'error ';
        $message = $error;
    }

    if($message != '') {
	    echo '<div class="notification '.$type.' closeable">';
	        echo '<p>'.$message.'</p>';
        echo '</div>';
    }

 }
?>