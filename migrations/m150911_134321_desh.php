<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_134321_desh extends Migration
{
    public function up()
    {
        $this->execute('delete from gs_hd');
        $this->execute('delete from gs_hd_town');
        $c = new \app\services\HumanDesign2();
        foreach (\app\services\HumanDesign2::$countryList as $k => $v) {
            echo $k . ' => ';
            $options = [
                'country' => $k,
                'day'     => '1',
                'month'   => '1',
                'year'    => '2015',
                'hour'    => '0',
                'minute'  => '0',
            ];
            $curl = curl_init($c->url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
            curl_setopt($curl, CURLOPT_POST, 1);
            $query = http_build_query($options);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $body = curl_exec($curl);

            $result = new \StdClass();
            $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $result->body = $body;
            curl_close($curl);
            \app\models\HD::insert([
                'title'    => $k,
                'content' => $result->body
            ]);
            echo ' ok'."\n";
        }
    }

    public function down()
    {
        echo "m150911_134321_desh cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
