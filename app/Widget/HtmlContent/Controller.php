<?php


/**
 * Контроллер
 *
 * в конфиг web.php нужно прописать в controllerMap
 * 'controllerMap' => [
 *     'html_content' => 'cs\Widget\HtmlContent\Controller',
 *     // ...
 * ],
 *
 * в правила роутинга надо прописать:
 *
 * 'upload/HtmlContent'                   => 'html_content/upload',
 */

namespace cs\Widget\HtmlContent;

use Yii;
use cs\services\Security;
use cs\services\UploadFolderDispatcher;
use yii\helpers\Html;

class Controller extends \cs\base\BaseController
{
    /**
     * загружает картинки в CKEDITOR
     */
    public function actionUpload()
    {
        $this->actionUpload_clearTempFolder();

        $fileInfo = pathinfo($_FILES['upload']['name']);
        $path = UploadFolderDispatcher::createFolder(HtmlContent::$uploadFolder);
        $path->add(time() . '_' . Security::generateRandomString(10) . '.' . $fileInfo['extension']);

        if (($_FILES['upload'] == 'none') OR (empty($_FILES['upload']['name']))) {
            $message = 'No file uploaded';
        }
        else if ($_FILES['upload']['size'] == 0) {
            $message = 'The file is of zero length';
        }
        else if (($_FILES['upload']['type'] != 'image/jpeg') AND ($_FILES['upload']['type'] != 'image/png')) {
            $message = 'The image must be in either JPG or PNG format. Please upload a JPG or PNG instead';
        }
        else if (!is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon";
        }
        else {
            $message = '';
            $move = @move_uploaded_file($_FILES['upload']['tmp_name'], $path->getPathFull());
            if (!$move) {
                $message = 'Error moving uploaded file. Check the script is granted Read/Write/Modify permissions';
            }
        }
        $funcNum = (int)$_GET['CKEditorFuncNum'];

        return Html::script("window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$path->getPath()}', '{$message}');");
    }


    private function actionUpload_clearTempFolder()
    {
        $memcacheVariable = 'cs\Widget\HtmlContent\Controller\actionUpload';
        if (Yii::$app->cache->get($memcacheVariable) < time() - 86400) {
            Yii::$app->cache->set($memcacheVariable, time());
            \cs\Widget\HtmlContent\Dispatcher::cron(false);
        }
    }

}