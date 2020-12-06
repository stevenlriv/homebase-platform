<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    use Aws\S3\S3Client;
    use League\Flysystem\AwsS3v3\AwsS3Adapter;
    use League\Flysystem\Filesystem;

    //$v_user if false we will get the user data from $user var if true, we will get the user data from view_user
    //this is used mainly for admin-edit-profile.php
    function profile_image($file, $v_user = false) {
        global $user;

        if($v_user) {
            global $view_user;
            $user = $view_user;
        }

        $filesystem = get_filesystem();
        $img_dir = get_img_path($file, 'profile');

        if($filesystem->writeStream($img_dir, fopen($file['tmp_name'], 'r+'), ['visibility' => 'public'])) {

            //New profile url
            $img_url = $filesystem->getAdapter()->getClient()->getObjectUrl(get_setting(20), $img_dir);

            //Get old profile image url
            $old_profile_url = $user['profile_image'];

            //Update new url on database
            if(update_user_table('profile_image', $user['id_user'], $img_url)) {
                //Delete old profile image
                if(!empty($old_profile_url)) {
                    delete_image($old_profile_url);
                }
                return true;
            }
        }

        return false;
    }

    function listing_image($file) {
        $filesystem = get_filesystem();
        $img_dir = get_img_path($file, 'listings');

        if($filesystem->writeStream($img_dir, fopen($file['tmp_name'], 'r+'), ['visibility' => 'public'])) {
            $img_url = $filesystem->getAdapter()->getClient()->getObjectUrl(get_setting(20), $img_dir);
            return $img_url;
        }

        return false;
    }

    function delete_image($file_url) {
        $filesystem = get_filesystem();

        //We will explode on "https://renthomebase.nyc3.digitaloceanspaces.com/" and get the file path
        //@example url: https://renthomebase.nyc3.digitaloceanspaces.com/uploads/listings/2020/May/26/ROVeJ2gsjL/mLIeH6hfDc_1%209.52.57%20AM.jpg
        //explode [0] = https://renthomebase.nyc3.digitaloceanspaces.com/
        //explode [1] = uploads/listings/2020/May/26/ROVeJ2gsjL/mLIeH6hfDc_1%209.52.57%20AM.jpg
        $path = explode(".com/", $file_url);
        $path = $path[1];

        if($filesystem->delete($path)) {
            return true;
        }
        
        return false;
    }

    function get_filesystem() {
        $client = S3Client::factory([
            'credentials' => [
                'key' => get_setting(16),
                'secret' => get_setting(17)
            ],
            'region' => get_setting(18), // Region you selected on time of space creation
            'endpoint' => get_setting(19),
            'version' => 'latest'
        ]);

        // Upload image file to server
        $adapter = new AwsS3Adapter($client, get_setting(20));
        return new Filesystem($adapter);     
    }

    function get_img_path($file, $dirname) {
        //Replace spaces from name
        $file_name = str_replace(' ', '', $file['name']); 

        //Generate a random string
        $file_name = generateNotSecureRandomString().'_'.$file_name;

        //Don't include a first '/' dash on img_dir
        $img_dir = 'uploads/'.$dirname.'/'.date('Y').'/'.date('F').'/'.date('d').'/'.generateNotSecureRandomString().'/'.$file_name;
        
        return $img_dir;
    }
?>