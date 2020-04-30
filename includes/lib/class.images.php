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
        $imageName = generateNotSecureRandomString().'_'.$file['name'];
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
?>