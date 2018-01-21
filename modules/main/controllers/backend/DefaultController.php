<?php
namespace modules\main\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_VIEW_ADMIN_PAGE],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed|\yii\web\Response
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can(Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
            Yii::$app->session->setFlash('error', Module::t('module', 'You are not allowed access!'));
            return $this->goHome();
        }
        // Greeting in the admin panel, you can delete what would not be boring :)
        /** @var object $identity */
        $identity = Yii::$app->user->identity;
        Yii::$app->session->setFlash('success', Module::t('module', 'Welcome, {:username}!', [':username' => $identity->username]));

        return $this->render('index');
    }
}
