<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.me/
 * @copyright Copyright (c) 2016 - 2017  vistart
 * @license https://vistart.me/license/
 */

namespace rhoone\controllers;

use rhoone\helpers\DictionaryHelper as DicHelper;
use rhoone\helpers\ExtensionHelper as ExtHelper;
use rhoone\models\SearchForm;
use rhoone\widgets\SearchWidget;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of SearchController
 *
 * @author vistart <i@vistart.me>
 */
class SearchController extends Controller
{

    /**
     * 
     * @param string $keywords
     * @todo Extract keywords from $keywords
     * @todo Retrieve synonyms and headwords.
     * @todo Retrieve search results cache.
     * @todo Return result.
     */
    public function actionIndex($q = null)
    {
        $keywords = $q;
        Yii::info("is POST: " . (string) Yii::$app->request->getIsPost(), __METHOD__);
        Yii::info("is AJAX: " . (string) Yii::$app->request->getIsAjax(), __METHOD__);
        Yii::info("is PJAX: " . (string) Yii::$app->request->getIsPjax(), __METHOD__);
        $model = new SearchForm();
        if (Yii::$app->request->getIsPost()) {
            if (!$model->load(Yii::$app->request->post())) {
                $model->keywords = "";
            }
            Yii::info("keywords: `" . $model->keywords . "`", __METHOD__);
            if (Yii::$app->request->getIsAjax() && Yii::$app->request->getIsPjax()) {
                return $this->actionResult($model->keywords, Yii::$app->rhoone->search($keywords));
            }
        }
        if (!is_string($keywords)) {
            $keywords = "";
        }
        if (strlen($keywords) > 255) {
            $keywords = substr(trim($keywords), 0, 255);
        }
        Yii::info("keywords: `" . $keywords . "`", __METHOD__);
        $model->keywords = $keywords;
        return $this->render('index', ['model' => $model, 'results' => Yii::$app->rhoone->search($keywords)]);
    }

    public function actionResult($keywords = null, $results = null)
    {
        return SearchWidget::widget(['model' => new SearchForm(['keywords' => $keywords]), 'resultConfig' => ['containerConfig' => ['results' => $results]]]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'search' => ['post', 'get'],
                ],
            ],
        ];
    }
}
