<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator \common\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);


/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
if (strlen($generator->tag) == 0) {
    $generator->tag = Inflector::camel2id($modelClass);
}

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\base\Exception;
use <?= ltrim($generator->modelClass, '\\') ?>;

use <?= ltrim($generator->baseControllerClass, '\\') ?>;

use <?= $generator->actionCreateClass ?>;
use <?= $generator->actionIndexClass ?>;
use <?= $generator->actionUpdateClass ?>;
use <?= $generator->actionDeleteClass ?>;


/**
* <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
*/
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

public function actionIndex()
{

return $this->sendResponse(
new <?= $modelClass ?>Filter( ),
Yii::$app->request->queryParams
);
}

public function actionCreate()
{

return $this->sendResponse(
new <?= $modelClass ?>CreateForm(new <?=$modelClass ?>()),
Yii::$app->request->bodyParams
);
}

public function actionUpdate($id)
{

return $this->sendResponse(
new <?= $modelClass ?>UpdateForm( $this->findOne($id) ),
Yii::$app->request->bodyParams
);
}

public function actionDelete($id)
{

return $this->sendResponse(
new <?= $modelClass ?>DeleteForm( $this->findOne($id) ),
Yii::$app->request->queryParams
);
}

public function actionView($id)
{
return $this->sendModel( $this->findOne($id) );
}

private function findOne($id)
{
$model = <?=$modelClass ?>::findOne($id);

if (!$model) {
throw new Exception("<?=$modelClass ?> not found");
}

return $model;
}

}
