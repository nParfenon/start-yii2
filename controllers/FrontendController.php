<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\page\models\Page;

class FrontendController extends Controller
{

    protected function checkPage()
    {
        $page = Page::getPage();

        if (!$page) throw new NotFoundHttpException('Страница не найдена.');

        if ($page->redirect) return $this->redirect([$page->redirect]);

        $this->view->params['page'] = $page;

        return true;
    }

}