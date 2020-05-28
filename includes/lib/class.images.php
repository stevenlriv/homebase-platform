<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    use Aws\S3\S3Client;
    use League\Flysystem\AwsS3v3\AwsS3Adapter;
    use League\Flysystem\Filesystem;

    function profile_image($id_user, $file) {
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
        $filesystem = new Filesystem($adapter);

        //Replace spaces from name
        $file_name = str_replace(' ', '', $file['name']);
        $imageName = generateNotSecureRandomString().'_'.$file_name;
        $baseUrl = $file['tmp_name'];
        $stream = fopen($baseUrl, 'r+');

        //Custom upload url
        //Don't include a first '/' dash on img_dir
        $img_dir = 'uploads/profile/'.date('Y').'/'.date('F').'/'.date('d').'/'.generateNotSecureRandomString().'/'.$imageName;

        if($filesystem->writeStream($img_dir, $stream, ['visibility' => 'public'])) {
            $profile_url = $filesystem->getAdapter()->getClient()->getObjectUrl(get_setting(20), $img_dir);

            if(update_profile_image($id_user, $profile_url)) {
                return true;
            }
        }

        return false;
    }

    function listing_image($file) {
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
        $filesystem = new Filesystem($adapter);

        //Replace spaces from name
        $file_name = str_replace(' ', '', $file['name']);
        $imageName = generateNotSecureRandomString().'_'.$file_name;
        $baseUrl = $file['tmp_name'];
        $stream = fopen($baseUrl, 'r+');

        //Custom upload url
        //Don't include a first '/' dash on img_dir
        $img_dir = 'uploads/listings/'.date('Y').'/'.date('F').'/'.date('d').'/'.generateNotSecureRandomString().'/'.$imageName;

        if($filesystem->writeStream($img_dir, $stream, ['visibility' => 'public'])) {
            $profile_url = $filesystem->getAdapter()->getClient()->getObjectUrl(get_setting(20), $img_dir);

            return $profile_url;
        }

        return false;
    }

    function delete_image($file_url) {
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
        $filesystem = new Filesystem($adapter);

        //Get correct url
        //@example: https://renthomebase.nyc3.digitaloceanspaces.com/uploads/listings/2020/May/26/ROVeJ2gsjL/mLIeH6hfDc_1%209.52.57%20AM.jpg
        //We will explode on "https://renthomebase.nyc3.digitaloceanspaces.com/" and get the file path
        $path = explode(".com/", $file_url);
        $path = $path[1];

        //echo $filesystem->getAdapter()->getClient()->getObjectUrl(get_setting(20), $path);

        if($filesystem->delete($path)) {
            return true;
        }
        
        return false;
    }
?>