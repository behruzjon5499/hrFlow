<?php
/* @var $generator common\generators\crud\Generator */

$modelClass = $generator->modelClass;

$model = new $modelClass();
$attributes = [];
if ($model->getTableSchema()) {
    $attributes = array_keys($model->getTableSchema()->columns);
}
echo "<?php\n";
?>

namespace  <?=   str_replace('/', '\\', dirname(str_replace('\\', '/',  $generator->actionCreateClass)))?>;

use api\components\BaseRequest;
use <?= $generator->modelClass ?>;

class <?= $generator->tag ?>CreateForm extends BaseRequest
{

<?php foreach ($attributes as $attribute): ?>
    public $<?= $attribute ?>;
<?php endforeach; ?>
public <?=  $generator->tag ?> $model;

public function __construct(<?=  $generator->tag ?> $model, $params = [])
{
$this->model = $model;
parent::__construct($params);
}

public function rules()
{
return [
[array_keys($this->model->attributes), 'safe'],
];
}

public function getResult()
{
$transaction = \Yii::$app->db->beginTransaction();

$this->model->setAttributes($this->attributes, false);

if ($this->model->validate() && $this->model->save()) {
$transaction->commit();
return true;
}

$transaction->rollBack();
$this->addErrors($this->model->errors);
return false;
}
}
