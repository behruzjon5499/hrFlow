<?php

namespace api\modules\auth\resources;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserProfileResource extends \common\models\UserProfile
{
    public function fields()
    {
        return [
            'full_name',
            'phone',
            'user_id',
            'locale',
            'passport',
            'birthday',
            'gender',
            'pnfl',
            'address',
            'position',
            'mfo',
            'bank',
            'avatar_base_url' => function ($model) {
                return $model->avatar_base_url
                    ? 'https://api.evalue.uz' . $model->avatar_base_url
                    : null;
            }
        ];
    }


}
