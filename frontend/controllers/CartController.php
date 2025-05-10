<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\campaigns\models\Campaign;
use backend\modules\currency\models\Currency;
use backend\modules\donation_types\models\DonationTypes;
use Mpdf\Tag\U;
use Yii;
use backend\modules\blogs\models\Blogs;
use backend\modules\blogs\models\BlogsLang;
use backend\modules\blogs\models\search\BlogsSearch;
use common\helpers\Utility;
use yii\base\DynamicModel;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * BlogController
 */
class CartController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;

    public function actionIndex()
    {
        $cart = Yii::$app->session->get('cart', []);
        [$subtotal, $total] = Utility::calculateCartTotals($cart, Utility::selected_currency('slug'));
        Yii::$app->session->set('cart', $cart);

        $users = [];

        if (!Yii::$app->user->isGuest) {
            $primary_user = Yii::$app->user->identity;
            $users[] = [
                'name' => $primary_user->name,
                'type' => 'P',
                'guid' => $primary_user->guid
            ];
            foreach ($primary_user->secondaryUsers as $secondary_user){
                $users[] = [
                    'name' => $secondary_user->name,
                    'type' => 'S',
                    'guid' => $secondary_user->guid
                ];
            }
        }

        return $this->render('index', [
            'cart' => $cart,
            'users' => $users,
            'total_donation_scheme' => count($cart),
            'sub_total' => $subtotal,
            'total' => $total,
        ]);
    }

    public function actionIncrement($item){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $cart = Yii::$app->session->get('cart', []);
        $guid = $item;

        if (isset($cart[$item])) {
            $item = $cart[$guid];
            $item['quantity']++;
            $item = Utility::adjustItem($item);
            if ($item) {
                $cart[$guid] = $item;
                [$subtotal, $total] = Utility::calculateCartTotals($cart, Utility::selected_currency('slug'));
                Yii::$app->session->set('cart', $cart);

                return [
                    'status' => true,
                    'message' => Yii::t('site', 'Item incremented successfully'),
                    'item' => $item,
                    'sub_total' => $subtotal,
                    'total' => $total,
                    'cart_items_count' => count($cart),
                ];
            }
        }

        unset($cart[$guid]);
        Yii::$app->session->set('cart', $cart);

        return [
            'status' => false,
            'message' => Yii::t('site', 'Cannot increment item'),
            'item' => $item,
            'cart_items_count' => count($cart),
        ];
    }

    public function actionDecrement($item){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $cart = Yii::$app->session->get('cart', []);
        $guid = $item;

        if (isset($cart[$item])) {
            $item = $cart[$guid];
            $item['quantity']--;
            $item['quantity'] = max($item['quantity'], 1);
            $item = Utility::adjustItem($item);
            if ($item) {
                $cart[$guid] = $item;
                [$subtotal, $total] = Utility::calculateCartTotals($cart, Utility::selected_currency('slug'));
                Yii::$app->session->set('cart', $cart);

                return [
                    'status' => true,
                    'message' => Yii::t('site', 'Item decrement successfully'),
                    'item' => $item,
                    'sub_total' => $subtotal,
                    'total' => $total,
                    'cart_items_count' => count($cart),
                ];
            }
        }

        unset($cart[$guid]);
        Yii::$app->session->set('cart', $cart);

        return [
            'status' => false,
            'message' => Yii::t('site', 'Cannot decrement item'),
            'item' => $item,
            'cart_items_count' => count($cart),
        ];
    }

    public function actionAdd(){
        $cart = Yii::$app->session->get('cart', []);
        $items = Yii::$app->request->post('items');

        foreach ($items as $index => $item) {
            [$guid, $item] = Utility::generateItem($item);

            if (!$guid) {
                unset($items[$index]);
                continue;
            }

            if (isset($cart[$guid]) && in_array($item['type'], [1])) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'status' => false,
                        'message' => Yii::t('site', 'Cannot add item to your cart'),
                        'recurring' => false
                    ];
                }
                Yii::$app->session->setFlash('cart-error', Yii::t('site', 'Cannot add item to your cart'));
                $this->response->redirect(['/cart/'])->send();
                exit;
            }

            if (Yii::$app->user->isGuest && $item['recurrence'] != 'once'){
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'status' => false,
                        'message' => Yii::t('site', 'You Need To Login To Add Recurring Item'),
                        'recurring' => true
                    ];
                }
                Yii::$app->session->setFlash('cart-error', Yii::t('site', 'You Need To Login To Add Recurring Item'));
                $this->response->redirect(['/cart/'])->send();
                exit;
            }

            if ($item['amount_jod'] > 2147483647){
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'status' => false,
                        'message' => Yii::t('site', 'Amount Is Huge'),
                        'recurring' => true
                    ];
                }
                Yii::$app->session->setFlash('cart-error', Yii::t('site', 'Amount Is Huge'));
                $this->response->redirect(['/cart/'])->send();
                exit;
            }

            if (isset($cart[$guid])){
                $item['quantity'] += $cart[$guid]['quantity'];
            }

            $item = Utility::adjustItem($item);
            if ($item) {
                $items[$index] = $item;
                $cart[$guid] = $item;
            }
        }

        if (empty($items) || empty($cart)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'status' => false,
                    'message' => Yii::t('site', 'PLEASE_ADD_AN_ITEM'),
                    'recurring' => false
                ];
            }
            Yii::$app->session->setFlash('cart-error', Yii::t('site', 'PLEASE_ADD_AN_ITEM'));
            $this->response->redirect(['/cart/'])->send();
            exit;
        }

        Yii::$app->session->set('cart', $cart);

        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => true,
                'message' => Yii::t('site', 'Added to cart'),
                'cart_items_count' => count($cart)
            ];
        }

        $this->response->redirect(['/payment/'])->send();
        return [];
    }

    public function actionDelete($item){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $cart = Yii::$app->session->get('cart', []);
        unset($cart[$item]);
        Yii::$app->session->set('cart', $cart);
        [$subtotal, $total] = Utility::calculateCartTotals($cart, Utility::selected_currency('slug'));

        return [
            'status' => true,
            'message' => Yii::t('site', 'Removed from cart'),
            'items_count' => count($cart),
            'sub_total' => $subtotal,
            'total' => $total,
            'cart_items_count' => count($cart)
        ];
    }

    public function actionItemsCount(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $cart = Yii::$app->session->get('cart', []);
        return [
            'status' => true,
            'count' => count($cart),
        ];
    }
}