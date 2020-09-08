<?php


namespace app\models;


/**
 * Class AuthToken
 * @package app\models
 *
 * @property string $id
 * @property string $token
 * @property string $expires
 *
 * @property User $user
 */

class AuthToken extends BaseModel
{

    public static function tableName()
    {
        return 'auth_tokens';
    }

    /**
     * @param $token
     * @return array|AuthToken|null
     */
    public static function findToken($token){
        return self::find()
            ->andWhere('expires > NOW()')
            ->andWhere(['token' => $token])
            ->one();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}