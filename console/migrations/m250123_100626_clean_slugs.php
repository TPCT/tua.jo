<?php

use backend\modules\discussion_papers\models\DiscussionPapers;
use backend\modules\discussion_papers\models\DiscussionPapersLang;
use backend\modules\hashemites\models\Hashemites;
use backend\modules\hashemites\models\HashemitesLang;
use backend\modules\interviews\models\Interviews;
use backend\modules\interviews\models\InterviewsLang;
use backend\modules\letters\models\Letters;
use backend\modules\letters\models\LettersLang;
use backend\modules\media_gallery\models\MediaGallery;
use backend\modules\news\models\News;
use backend\modules\news\models\NewsLang;
use backend\modules\op_eds\models\Opeds;
use backend\modules\op_eds\models\OpedsLang;
use backend\modules\speeches\models\Speeches;
use backend\modules\speeches\models\SpeechesLang;
use yii\db\Migration;

class m250123_100626_clean_slugs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables=
        [
            DiscussionPapers::tableName(),
            DiscussionPapersLang::tableName(),

            Hashemites::tableName(),
            HashemitesLang::tableName(),

            Interviews::tableName(),
            InterviewsLang::tableName(),

            Letters::tableName(),
            LettersLang::tableName(),

            News::tableName(),
            NewsLang::tableName(),

            Opeds::tableName(),
            OpedsLang::tableName(),

            Speeches::tableName(),
            SpeechesLang::tableName(),


        ];


        foreach($tables as $table)
        {
            $rows = (new \yii\db\Query())
                ->select(['id', 'slug']) 
                ->from($table) 
                ->all();

            foreach ($rows as $row) 
            {
                if($row['slug'])
                {
                    $slug = $row['slug'];
                    $slug = $this->removeArabicDiacritics($slug);
                    $slug = preg_replace('/[^\p{Arabic}a-z0-9_\-\s]/u', '', $slug);
                    $slug = trim($slug); // Trim spaces (optional)
                    $parts = explode(" ", $slug);
                    $slug = implode("-",$parts);
                    $slug = trim($slug, '-');
                    
                    $slug = $this->ensureUniqueSlug($slug, $table, $row["id"]);
        
                    // Update the row with the cleaned slug
                    $this->update(
                        $table,
                        ['slug' => $slug], 
                        ['id' => $row['id']] 
                    );
                }

            }

        }
        
    }
    private static function removeArabicDiacritics($string) {
        $diacritics = [
            '/[\x{064B}\x{064C}\x{064D}\x{064E}\x{064F}\x{0650}\x{0651}\x{0652}\x{0653}\x{0654}\x{0655}]/u' => '',
        ];
    
        return preg_replace(array_keys($diacritics), array_values($diacritics), $string);
    }

    private function ensureUniqueSlug($slug, $table, $current_id)
    {
        $counter = (new \yii\db\Query())
        ->from($table)
        ->where(['slug' => $slug])
        ->andWhere(["!=", "id",$current_id])
        ->count();


        if($counter){
            $counter++;
        }


        return $counter > 0 ? "{$slug}-{$counter}" : $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250123_100626_clean_slugs cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250123_100626_clean_slugs cannot be reverted.\n";

        return false;
    }
    */
}
