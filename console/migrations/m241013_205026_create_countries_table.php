<?php

use yii\db\Migration;

/**
 * Class m241013_205026_create_countries_table
 */
class m241013_205026_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('countries_tbl', [
            'id' => $this->primaryKey(),
            'image' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'slug' => $this->string(255),
            'created_by' => $this->string(45),
            'updated_by' => $this->string(45),
            'published_at' => $this->integer(),
        ], 'ENGINE=InnoDB CHARSET=latin1');
    
        $this->createTable('countries_tbl_lang', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6)->notNull(),
            'title' => $this->string(255),
        ], 'ENGINE=InnoDB CHARSET=utf8mb3');
    
        $this->addForeignKey(
            'fk-countries_tbl_lang-parent_id',
            'countries_tbl_lang',
            'parent_id',
            'countries_tbl',
            'id',
            'CASCADE',
            'CASCADE'
        );
    
        $this->createIndex(
            'idx-countries_tbl_lang-parent_id',
            'countries_tbl_lang',
            'parent_id'
        );
    
        $this->createIndex(
            'idx-countries_tbl_lang-language',
            'countries_tbl_lang',
            'language'
        );

        $this->addColumn('city', 'country_id', $this->integer()->after('slug'));

        
        $this->addForeignKey(
            'fk-city-country_id',
            'city',
            'country_id',
            'countries_tbl',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241013_205026_create_countries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241013_205026_create_countries_table cannot be reverted.\n";

        return false;
    }
    */
}
