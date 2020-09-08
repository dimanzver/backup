<?php


namespace app\controllers;


use app\models\AuthToken;
use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login'],
        ];
        return $behaviors;
    }

    public function actionLogin(){
        $login = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');
        $user = User::findByLogin($login);
        if(!$user || !$user->validatePassword($password)) {
            Yii::$app->response->setStatusCode(422);
            return ['Неправильный логин или пароль'];
        }

        return $user->generateToken();
    }

    public function actionLogout(){
        $tokenString = Yii::$app->request->getHeaders()->get('authorization');
        $tokenString = preg_replace('/^Bearer\s+/', '', $tokenString);
        $token = AuthToken::findToken($tokenString);
        $token->delete();
    }

}