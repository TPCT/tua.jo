<?php
/**
 * Created by PhpStorm.
 * User: Ahmad
 * Date: 12/22/2016
 * Time: 1:35 PM
 */

namespace console\controllers;

use backend\modules\newsletter\models\NewsletterCampaign;
use backend\modules\newsletter\models\NewsletterClientList;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class NewsletterCampaignController extends Controller
{

    public function actionIndex()
    {

        ini_set('error_reporting', 22519);
        $fh = fopen(Yii::getAlias('@runtime') . '/logs/newsletter.log', 'a') or die("can't open file");


        $campaign = NewsletterCampaign::find()
            ->where(['<=', 'start_date', date('Y-m-d H:m:s')])
            ->andWhere(['status' => 'Pending'])->one();
        /* @var  $campaign NewsletterCampaign */
        if (!$campaign) return;

        fwrite($fh, Yii::$app->formatter->asDatetime(time()) . ' Start Sending Campaign Subject: ' . $campaign->subject . chr(10));

        foreach (NewsletterClientList::find()->where(['confirmed' => 1])->each(50) as $subscriber) {

            /* @var $subscriber NewsletterClientList */
            try {

                $message = Yii::$app->get('newsletterMailer')->compose(['html' => 'newsletter'],['content' => $campaign->body, 'email' => $subscriber->email])
                    ->setFrom([Yii::$app->params['newsletterEmail']])
                    ->setTo($subscriber->email)
                    //->setReplyTo($model->reply_to)
                    ->setSubject($campaign->subject);
                $message->send();
                fwrite($fh, Yii::$app->formatter->asDatetime(time()) . ' Subscriber Email: ' . $subscriber['email'] . chr(10));

            } catch (Exception $ex) {
                fwrite($fh, Yii::$app->formatter->asDatetime(time()) . ' Error Subscriber Email: ' . $subscriber['email'] . ' ' . $ex->getMessage() . chr(10));
                continue;
            }catch (\Swift_SwiftException $ex) {
                fwrite($fh, Yii::$app->formatter->asDatetime(time()) . ' Error Subscriber Email: ' . $subscriber['email'] . ' ' . $ex->getMessage() . chr(10));
                continue;
            }

        }

        $campaign->status = 'Completed';
        $campaign->save();


        fwrite($fh, Yii::$app->formatter->asDatetime(time()) . ' End Sending' . chr(10));
        fwrite($fh, '#####################################################################' . chr(10) . chr(10) . chr(10));

    }

}
