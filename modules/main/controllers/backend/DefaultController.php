<?php

namespace modules\main\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use modules\users\models\User;
use modules\rbac\models\Permission;
use modules\main\Module;

/**
 * Class DefaultController
 * @package modules\main\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_VIEW_ADMIN_PAGE]
                    ]
                ]
            ]
        ];
    }

    /**
     * Displays homepage.
     * @return mixed|Response
     */
    public function actionIndex()
    {
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        if (!$user->can(Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('error', Module::translate('module', 'You are not allowed access!'));
            return $this->goHome();
        }
        //Greeting in the admin panel :)
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        $key = 'msgHello';
        if ($session->get($key) !== 1) {
            /** @var User $identity */
            $identity = Yii::$app->user->identity;
            $session->setFlash('info', Module::translate('module', 'Welcome, {:username}!', [
                ':username' => $identity->username
            ]));
            $session->set($key, 1);
        }
        return $this->render('index');
    }
}
