<?php

namespace app\commands;

use app\models\SubscribeMailItem;
use yii\console\Controller;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;

/**
 * Обслуживание сайта
 */
class SiteController extends Controller
{
    /**
     * Очищает папку '@web/assets'
     */
    public function actionClear_assets()
    {
        $path = \Yii::getAlias('@web/assets');
        $files = scandir($path);
        $c = 0;
        foreach($files as $folder) {
            if (!in_array($folder, ['.', '..'])) {
                $objectPathFull = $path . DIRECTORY_SEPARATOR . $folder;
                if (is_dir($objectPathFull)) {
                    FileHelper::removeDirectory($objectPathFull);
                    $c++;
                }
            }
        }
        echo('Готово.' . "\n" );
        echo('Удалено: ' . $c . "\n" );
        \Yii::info('Очищена папка @web/assets', 'gs\\site\\clear_assets');
        \Yii::$app->end();
    }
}
