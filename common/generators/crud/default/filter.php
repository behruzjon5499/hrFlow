<?php

namespace api\modules\client\filters;

use common\generators\crud\Generator;

/* @var $generator Generator */
echo "<?php\n";
?>
namespace  <?=   str_replace('/', '\\', dirname(str_replace('\\', '/',  $generator->actionIndexClass)))?>;
use <?= $generator->modelClass ?> ;
use api\components\BaseRequest;
use Yii;


class <?= $generator->tag ?>Filter extends BaseRequest
{
    public $search;
    public $status;

    public function rules()
    {
        return [
            [['search', 'status'], 'safe'],
        ];
    }

    public function getResult()
    {
        $model = <?= $generator->tag ?>::find()
            ->andWhere(['is_deleted' => [false, null]]);

        if ($this->status) {
            $model->andWhere(['status' => $this->status]);
        }

        if ($this->search) {
            $model->andWhere(['ILIKE', 'name', $this->search]);
        }

        $model->orderBy(['order' => SORT_ASC]);

        return paginate($model);
    }
}
