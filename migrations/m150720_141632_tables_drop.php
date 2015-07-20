<?php

use yii\db\Schema;
use yii\db\Migration;

class m150720_141632_tables_drop extends Migration
{
    public function up()
    {
        $tableList = [
            'articles_all',
            'geo_country',
            'geo_country_lang',
            'geo_town',
            'geo_town_lang',
            'life',
            'life_articles',
            'nedv_ekoposeleniya',
            'nedv_ekoposeleniya_type',
            'news',
            'news_comment',
            'news_see_also',
            'otziv',
            'otziv_anonim',
            'otziv_comment',
            'otziv_comment_img',
            'otziv_comment_video',
            'otziv_multimedia',
            'otziv_video',
            'pages',
            'pages_also',
            'radhaKrishna',
            'radhaKrishna_articles',
            'tu_columns',
            'tu_columns_type',
            'tu_columns_type_file',
            'tu_columns_type_html',
            'tu_columns_type_image',
            'tu_columns_type_list',
            'tu_columns_type_tags',
            'tu_groups',
            'tu_tables',
            'unions',
            'unions_articles',
            'unions_calendar',
            'unions_links',
            'unions_movement',
            'unions_movement_articles',
            'unions_project',
            'unions_project_articles',
            'unions_tree',
            'unions_tree_articles',
            'users',
            'users_remind',
            'users_temp',
            'widget_uploader_many',
            'widget_uploader_many_fields',
        ];
        foreach($tableList as $t) {
            $this->execute("DROP TABLE IF EXISTS galaxysss_1.{$t};");
        }
    }

    public function down()
    {
        echo "m150720_141632_tables_drop cannot be reverted.\n";

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
