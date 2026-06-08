<?php

namespace common\traits;

use yii\web\NotFoundHttpException;

trait FindOrFail
{
    public static function findOrFail($id, ?array $condition = null)
    {
        $query = self::find()->where(['id' => $id, 'deleted_at' => null]);

        if ($condition) $query->andWhere($condition);

        $model = $query->one();

        if (!$model) throw new NotFoundHttpException("Product not found");

        return $model;
    }
}
