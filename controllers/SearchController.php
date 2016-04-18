<?php

/**
 *  _   __ __ _____ _____ ___  ____  _____
 * | | / // // ___//_  _//   ||  __||_   _|
 * | |/ // /(__  )  / / / /| || |     | |
 * |___//_//____/  /_/ /_/ |_||_|     |_|
 * @link https://vistart.name/
 * @copyright Copyright (c) 2016 vistart
 * @license https://vistart.name/license/
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
 * @author vistart <i@vistart.name>
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
    public function actionIndex($keywords = null)
    {
        Yii::info("is POST: " . (string) Yii::$app->request->getIsPost(), __METHOD__);
        Yii::info("is AJAX: " . (string) Yii::$app->request->getIsAjax(), __METHOD__);
        Yii::info("is PJAX: " . (string) Yii::$app->request->getIsPjax(), __METHOD__);
        if (Yii::$app->request->getIsPost()) {
            $model = new SearchForm();
            if (!$model->load(Yii::$app->request->post())) {
                $model->keywords = "";
            }
            Yii::info("keywords: `" . $model->keywords . "`", __METHOD__);
            if (Yii::$app->request->getIsAjax() && Yii::$app->request->getIsPjax()) {
                return $this->actionResult($model->keywords, ExtHelper::search($keywords));
            }
        }
        if (!is_string($keywords)) {
            $keywords = "";
        }
        if (strlen($keywords) > 255) {
            $keywords = substr(trim($keywords), 0, 255);
        }
        Yii::info("keywords: `" . $keywords . "`", __METHOD__);
        return $this->render('index', ['keywords' => $keywords, 'results' => ExtHelper::search($keywords)]);
    }

    public function actionResult($keywords = null, $results = null)
    {
        return SearchWidget::widget(['keywords' => $keywords, 'results' => $results]);
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
