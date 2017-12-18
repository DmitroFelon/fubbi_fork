<?php
/**
 * Created by PhpStorm.
 * User: imad
 * Date: 12/18/17
 * Time: 7:59 AM
 */

namespace App\Services\Google;


use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Google_Service_Exception;
use Illuminate\Support\Facades\Storage;

/**
 * Class Drive
 * @package App\Services\Google
 */
class Drive
{

    /**
     * @var
     */
    protected $client_secret_path;
    /**
     * @var string
     */
    protected $app_name;
    /**
     * @var
     */
    protected $credentials_path;
    /**
     * @var
     */
    protected $scopes;
    /**
     * @var Google_Client
     */
    protected $client;
    /**
     * @var Google_Service_Drive
     */
    protected $service;

    /**
     * Drive constructor.
     */
    public function __construct()
    {

        $this->client_secret_path = storage_path('app/google/client_secret.json');
        $this->app_name = 'Drive API PHP Quickstart';
        $this->credentials_path = storage_path('app/google/.credentials/drive-php-quickstart.json');
        $this->scopes = implode(' ',
            [
                Google_Service_Drive::DRIVE
            ]
        );
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/google/service_account.json'));

        $this->client = $this->getClient();
        $this->service = $this->getService();
    }

    /**
     * @return Google_Client
     */
    private function getClient()
    {
        $client = new Google_Client();
        $client->setScopes($this->scopes);
        $client->useApplicationDefaultCredentials();

        $this->client = $client;
        return $client;
    }

    /**
     * @return Google_Service_Drive
     */
    private function getService()
    {
        return new Google_Service_Drive($this->client);
    }

    /**
     * @return \Google_Service_Drive_FileList
     */
    public function getFiles()
    {
        $optParams = array(
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name)'
        );
        return $this->service->files->listFiles($optParams);

    }

    public function watchFile($id)
    {
        $response = $this->service->files->watch($id);
        return $response->getBody()->getContents();
    }

    /**
     * @param $path
     * @return mixed
     */
    public function uploadFile($path)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile(
            [
                'name' => 'Testing file',
                'mimeType' => 'application/vnd.google-apps.document']
        );

        $content = file_get_contents($path);

        $file = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'uploadType' => 'multipart',
            'fields' => 'id']);

        return $file->id;
    }

    /**
     * @param $id
     * @param string $mime
     * @return mixed
     */
    public function getFile($id, $mime = 'application/pdf')
    {

        $response = $this->service->files->export($id, $mime, ['alt' => 'media']);
        return $response->getBody()->getContents();
    }

    /**
     * @param $id
     * @return Google_Http_Request
     */
    public function deleteFile($id)
    {
        return $this->service->files->delete($id);
    }

    public function addPermission($file_id, $email, $type, $role)
    {
        $this->service->getClient()->setUseBatch(true);
        $batch = $this->service->createBatch();
        $userPermission = new Google_Service_Drive_Permission(array(
            'type' => $type,
            'role' => $role,
            'emailAddress' => $email
        ));
        $request = $this->service->permissions->create(
            $file_id, $userPermission, ['fields' => 'id']);
        $batch->add($request, 'user');

        $results = $batch->execute();
        foreach ($results as $result) {
            if ($result instanceof Google_Service_Exception) {
                // Handle error
                return false;
            } else {
                return $result;
            }
        }

    }

    public function addFolder($name)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => 'Invoices',
            'mimeType' => 'application/vnd.google-apps.folder']);

        $file = $this->service->files->create($fileMetadata, ['fields' => 'id']);
        

        return $file->id;
    }
}