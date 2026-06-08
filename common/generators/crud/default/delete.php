<?php

namespace api\modules\client\forms;
/* @var $generator Generator */

use common\generators\crud\Generator;

echo "<?php\n";
?>
namespace  <?=   str_replace('/', '\\', dirname(str_replace('\\', '/',  $generator->actionDeleteClass)))?>;
use <?= $generator->modelClass ?>;

use yii\base\Exception;
use yii\db\StaleObjectException;
use api\components\BaseRequest;

class <?= $generator->tag ?>DeleteForm extends BaseRequest
{


    public <?= $generator->tag ?> $model;

    public function __construct(<?= $generator->tag ?> $model, $params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     * @throws \Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function getResult()
    {
        $transaction = \Yii::$app->db->beginTransaction();

        $this->model->is_deleted = true;
        $this->model->deleted_at = time();
        $this->model->deleted_by = \Yii::$app->user->id;

        if ($this->model->save()) {

            $transaction->commit();
            return true;
        }

        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;
    }
}
