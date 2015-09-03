<?php

namespace cs\Widget\FileUploadMany;

use Yii;
use DateTime;
use yii\db\Query;
use cs\services\dispatcher\DispatcherInterface;

/**
 * Класс \cs\Widget\FileUploadMany\Dispatcher
 * удаляет временные файлы
 * рекомендуемая частота вызова раз в 24 часа
 * Удаляет все файлы которые старше чем вчера
 *
 * @author Dmitrii Mukhortov <dram1008@yandex.ru>
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * Функция для крона.
     * Удаляет временные файлы старше чем сутки.
     * Рекомендация к исполнению: каждые 24 часа
     *
     * @param bool $isEcho true - выводит ссобения о количестве удаленных файлов
     *                     false - не выводит
     *
     * @return int количество удаленных файлов
     */
    public static function cron($isEcho = true)
    {
        $u = FileUploadMany::$uploadDirectory;
        $timeMax = time() - (60 * 60 * 24);
        $path = Yii::getAlias($u);
        Yii::info('Зачистака временной папки: ' . $path, 'cs\Widget\FileUploadMany\Dispatcher::cron');
        if (file_exists($path)) {
            $files = array_slice(scandir($path), 2);
            $counter = 0;
            foreach ($files as $file) {
                $array = explode('_', $file);
                $fileTime = $array[0];
                if ($fileTime < $timeMax) {
                    if (is_file($file)) {
                        unlink($file);
                        $counter++;
                    }
                }
            }
            if ($isEcho) {
                echo 'Удалено файлов: ' . $counter;
            }

            return $counter;
        }

        return 0;
    }
}
