<?php

namespace common\models\query;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class UserTokenQuery
 * @package common\models\query
 * @author Eugene Terentev <eugene@terentev.net>
 */
class NotDeletedFromCompanyQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function notDeleted()
    {
        $tableName = $this->modelClass::tableName();

        $this->andWhere([$tableName.'.deleted_at' => null]);
        
        return $this;
    }

    public function notDeletedAndFromCompany()
    {
        $tableName = $this->modelClass::tableName();

        $this->andWhere([$tableName.'.deleted_at' => null, $tableName.'.company_id' => Yii::$app->user->identity->company_id]);

        return $this;
    }
}