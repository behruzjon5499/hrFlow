<?php

namespace common\models;

use api\modules\auth\resources\UserResource;
use common\behaviors\ByBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\Linkable;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * Class ActiveRecord
 * @package docflow\components
 */
class ActiveRecord extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $user_id = null;
        if (\Yii::$app->has("user")) {
            $user_id = \Yii::$app->user->id;
        }
        return ArrayHelper::merge(parent::behaviors(), [
            'time' => [
                'class' => TimestampBehavior::class,
            ],
            'by' => [
                'class' => ByBehavior::class
            ],
            'delete' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true,
                    'deleted_at' => time(),
                    'deleted_by' => $user_id
                ],
                'replaceRegularDelete' => false
            ],
        ]);
    }


    public function getCreatedBy()
    {
        return $this->hasOne(UserResource::class, ['id' => 'created_by']);
    }


    public function getUpdatedBy()
    {
        return $this->hasOne(UserResource::class, ['id' => 'updated_by']);
    }

    /**
     * @inheritDoc
     */
    public function getLinks()
    {
        return [];
    }
    public function delete()
    {
        $this->updateAttributes(['is_deleted'=>true,'deleted_at'=>time(),'deleted_by'=>Yii::$app->user->id]);
        return true;
    }

    public function isNotDeleted()
    {
        return $this->andWhere([
            'is_deleted' => [false,null]
        ]);
    }
}