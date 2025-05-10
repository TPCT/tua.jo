<?php

use yii\db\Migration;

/**
 * Class m241105_094446_add_promote_to_homepage_to_news_speech_YoutubeLinks_DiscussionPapers_Opeds_DropdownList
 */
class m241105_094446_add_promote_to_homepage_to_news_speech_YoutubeLinks_DiscussionPapers_Opeds_DropdownList extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("news_lang","promote_to_front",$this->tinyInteger(1)->after("status")->defaultValue(0));
        $this->addColumn("speeches_lang","promote_to_front",$this->tinyInteger(1)->after("status")->defaultValue(0));
        $this->addColumn("youtube_links_lang","promote_to_front",$this->tinyInteger(1)->after("brief")->defaultValue(0));
        $this->addColumn("discussion_papers_lang","promote_to_front",$this->tinyInteger(1)->after("status")->defaultValue(0));
        $this->addColumn("op_eds_lang","promote_to_front",$this->tinyInteger(1)->after("status")->defaultValue(0));
        $this->addColumn("dropdown_list_lang","promote_to_front",$this->tinyInteger(1)->after("brief")->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241105_094446_add_promote_to_homepage_to_news_speech_YoutubeLinks_DiscussionPapers_Opeds_DropdownList cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241105_094446_add_promote_to_homepage_to_news_speech_YoutubeLinks_DiscussionPapers_Opeds_DropdownList cannot be reverted.\n";

        return false;
    }
    */
}
