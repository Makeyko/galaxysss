<?php

namespace cs\Widget\FileUploadMany;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\Request;
use yii\web\Response;
use cs\base\BaseController;
use cs\services\Security;

/*
'upload/upload'                         => 'upload/upload',
'upload/download/<id:\\d+>'             => 'upload/download',
*/

class UploadController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@',
                            '?'
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Скачивает файл
     *
     * @param $id
     *
     * @return string|static
     */
    public function actionDownload($id)
    {
        $file = ModelFiles::find($id);
        if (is_null($file)) return self::jsonError('Не найден файл с таким идентификатором');
        $data = file_get_contents($file->getPathFull());

        return Yii::$app->response->sendContentAsFile($data, $file->getFileName());
    }

    /**
     * Закачивает файл `$_FILES['file']`
     *
     * @return string JSON Response
     *                [[
     *                    $tempUploadedFileName,
     *                    $fileName
     *                ]]
     */
    public function actionUpload()
    {
        $this->actionUpload_clearTempFolder();

        $output_dir = FileUploadMany::$uploadDirectory;
        $info = parse_url($_SERVER['HTTP_REFERER']);
        if ($info['host'] != $_SERVER['SERVER_NAME']) return self::jsonError('Не тот сайт');

        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $ret = [];

            $error = $file['error'];
            //You need to handle  both cases
            //If Any browser does not support serializing of multiple files using FormData()
            if (!is_array($file['name'])) //single file
            {
                $fileName = \cs\services\UploadFolderDispatcher::generateFileName($file['name']);
                $destPathFull = Yii::getAlias($output_dir);

                FileHelper::createDirectory($destPathFull);
                $destPathFull = $destPathFull . '/' . $fileName;
                move_uploaded_file($file['tmp_name'], $destPathFull);
                $ret[] = [
                    $fileName,
                    $file['name']
                ];
            }
            else  //Multiple files, file[]
            {
                $fileCount = count($file['name']);
                $dir = Yii::getAlias($output_dir);
                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $file['name'][ $i ];
                    move_uploaded_file($file['tmp_name'][ $i ], $dir . '/' . $fileName);
                    $ret[] = [
                        $fileName,
                        $file['name'][ $i ]
                    ];
                }
            }

            return self::jsonSuccess($ret);
        }
    }

    private function actionUpload_clearTempFolder()
    {
        $memcacheVariable = 'cs\Widget\FileUploadMany\UploadController\actionUpload';
        if (Yii::$app->cache->get($memcacheVariable) < time() - 86400) {
            Yii::$app->cache->set($memcacheVariable, time());
            \cs\Widget\FileUploadMany\Dispatcher::cron(false);
        }
    }
}
