<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class User extends BaseModel implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = AuthToken::findToken($token);
        if(!$token)
            return null;
        return $token->user;
    }

    /**
     * @param $login
     * @return array|User|null
     */
    public static function findByLogin($login){
        return self::find()->where(['login' => $login])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @return AuthToken
     */
    public function generateToken(){
        $token = new AuthToken([
            'user_id' => $this->id,
            'token' => bin2hex(openssl_random_pseudo_bytes(64)),
            'expires' => date('Y-m-d H:i:s', strtotime('+1 week')),
        ]);
        $token->save();
        return $token;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException('"getAuthKey" is not implemented');
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException('"validateAuthKey" is not implemented');
    }
}
