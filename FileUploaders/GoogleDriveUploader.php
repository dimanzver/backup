<?php


namespace app\FileUploaders;

//use Google_Auth_Exception;
use app\models\Settings;
use Google_Exception;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;


class GoogleDriveUploader extends FileUploader
{
    protected static $drive;
    protected static $client;

    public function upload($file)
    {
        $baseRemoteDir = Settings::getValue('baseRemote');
        $remoteDir = $baseRemoteDir . '/' . $this->backup->dir;
        self::uploadFile($file, $remoteDir);
    }

    /**
     * @return \Google_Client
     * @throws Google_Exception
     */
    protected static function getClient(){
        if(!self::$client){
            self::$client = new \Google_Client();
            self::$client->setApplicationName('Google Drive API PHP');
            self::$client->setScopes(Google_Service_Drive::DRIVE_FILE);
            self::$client->setAuthConfig(base_path('.google-credentials'));
            self::$client->setAccessType('offline');
            self::$client->setPrompt('select_account consent');

            // Load previously authorized token from a file, if it exists.
            // The file token.json stores the user's access and refresh tokens, and is
            // created automatically when the authorization flow completes for the first
            // time.
            $tokenPath = base_path('.google-token');
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                self::$client->setAccessToken($accessToken);
            }


            // If there is no previous token or it's expired.
            if (self::$client->isAccessTokenExpired()) {
                // Refresh the token if possible, else fetch a new one.
                if (self::$client->getRefreshToken()) {
                    self::$client->fetchAccessTokenWithRefreshToken(self::$client->getRefreshToken());
                } else {
                    throw new Google_Exception('Need authorization from the user');
                }
                self::saveAccessToken();
            }


        }

        return self::$client;
    }

    // Save the token to a file.
    protected static function saveAccessToken(){
        $tokenPath = base_path('.google-token');
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode(self::$client->getAccessToken()));
    }

    /**
     * Auth with code
     *
     * @param string $authCode
     * @throws \Exception
     */
    public static function auth(string $authCode){
        $authStatus = self::checkAuthOrGetUrl();
        if($authStatus['status'])
            return;

        $accessToken = self::$client->fetchAccessTokenWithAuthCode($authCode);
        self::$client->setAccessToken($accessToken);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }
        self::saveAccessToken();
    }

    /**
     * Get auth url if need auth
     *
     * @return array
     */
    public static function checkAuthOrGetUrl(){
        try{
            self::getClient();
            return [
                'status' => true
            ];
        }catch (Google_Exception $e){
            /** @var \Google_Client $client */
            $client = self::$client;
            $authUrl = $client->createAuthUrl();
            return [
                'status' => false,
                'authUrl' => $authUrl
            ];
        }
    }

    /**
     * Init drive instance if need and return it
     *
     * @return Google_Service_Drive
     */
    public static function getDrive(){
        if(!self::$drive){
            self::$drive = new Google_Service_Drive(self::getClient());
        }
        return self::$drive;
    }

    /**
     * @param string $name
     * @param $parentId
     * @return Google_Service_Drive_DriveFile
     */
    public static function getSubDirectoryOrCreate(string $name, $parentId = null){
        //Send query
        $find = self::getDrive()->files->listFiles([
            'fields' => 'files(id, name, parents)',
            'q' => 'trashed = false and \'' . ($parentId ?? 'root') . '\' in parents and mimeType = \'application/vnd.google-apps.folder\' and name = \'' . $name . '\'',
        ]);

        if($find->count())
            return $find[0];

        return self::createDirectory($name, $parentId);
    }

    /**
     * Create directory without checking for existing
     *
     * @param string $name
     * @param $parentId
     * @return Google_Service_Drive_DriveFile
     */
    public static function createDirectory(string $name, $parentId){
        $file = new Google_Service_Drive_DriveFile();
        $file->setMimeType('application/vnd.google-apps.folder');
        $file->setName($name);
        if($parentId)
            $file->setParents([$parentId]);
        $dir = self::getDrive()->files->create($file);

        return $dir;
    }

    /**
     * Recursive getting or creating directory
     *
     * @param string $path
     * @param null $parentId
     * @return Google_Service_Drive_DriveFile
     */
    public static function getDirectoryInPath(string $path, $parentId = null){
        $pathParts = array_filter(explode('/', $path));
        $dirname = array_shift($pathParts);
        $dir = self::getSubDirectoryOrCreate($dirname, $parentId);

        //if its is last directory
        if(empty($pathParts))
            return $dir;

        return self::getDirectoryInPath(implode('/', $pathParts), $dir->id);
    }

    /**
     * Load file in need dir from local file
     *
     * @param string $localPath
     * @param string $dir
     * @param string|null $filename
     * @return Google_Service_Drive_DriveFile
     */
    public static function uploadFile(string $localPath, string $dir, string $filename = null){
        if(!$filename){
            $filename = pathinfo($localPath, PATHINFO_BASENAME);
        }

        $remoteDir = self::getDirectoryInPath($dir);

        $file = new Google_Service_Drive_DriveFile();
        $file->setMimeType(mime_content_type($localPath));
        $file->setName($filename);
        $file->setParents([$remoteDir->id]);
        return self::getDrive()->files->create($file, [
            'data' => file_get_contents($localPath),
            'uploadType' => 'multipart',
        ]);
    }
}