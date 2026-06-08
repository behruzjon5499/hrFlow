<?php
/**
 * Created by PhpStorm.
 * User: Vladislav
 * Date: 21.05.2017
 * Time: 13:21
 */

namespace common\helpers;


use yii\authclient\OAuth2;
use Yii;
use yii\helpers\ArrayHelper;
use yii\log\Logger;

class oAuthHelper
{
    private $info = [
        'name' => '',
        'last_name' => '',
        'email' => '',
        'gender' => '',
        'birthday' => '',
        'social_id' => '',
        'social_name' => ''
    ];

    public static function getInfo($client)
    {
        $method = 'service' . (new \ReflectionClass($client))->getShortName();

        return (new oAuthHelper())->$method($client);
    }

    /**
     * @param OAuth2 $client
     *
     * @return array
     */
    public function serviceFacebook($client)
    {
        $user_attributes = $client->getUserAttributes();

        yii::getLogger()->log($user_attributes, Logger::LEVEL_ERROR, 'oAuthHelper.serviceFacebook');

        $this->info['name'] = $user_attributes['first_name'];
        $this->info['last_name'] = $user_attributes['last_name'];
        $this->info['email'] = ArrayHelper::getValue($user_attributes, 'email');
        $this->info['social_id'] = $user_attributes['id'];
        $this->info['social_name'] = 'facebook';

        if (isset($user_attributes['birthday']))
            $this->info['birthday'] = $user_attributes['birthday'];


        if (isset($user_attributes['gender'])) {
            if (strtolower($user_attributes['gender']) == 'male')
                $this->info['gender'] = 1;

            if (strtolower($user_attributes['gender']) == 'female')
                $this->info['gender'] = 2;
        }

        return $this->info;
    }

    /**
     * @param OAuth2 $client
     *
     * @return array
     */
    public function serviceGoogle($client)
    {
        $user_attributes = $client->getUserAttributes();

        $this->info['name'] = $user_attributes['name'];
        $this->info['email'] = $user_attributes['email'];
        $this->info['image'] = $user_attributes['picture'];
        $this->info['id'] = $user_attributes['id'];

        return $this->info;
    }
    public function serviceGitHub($client)
    {
        $user_attributes = $client->getUserAttributes();

        $this->info['name'] = $user_attributes['login'];
        $this->info['email'] = $user_attributes['email'];
        $this->info['image'] = $user_attributes['avatar_url'];
        $this->info['id'] = $user_attributes['id'];
        $this->info['network_url'] = $user_attributes['html_url'];

        return $this->info;
    }

}