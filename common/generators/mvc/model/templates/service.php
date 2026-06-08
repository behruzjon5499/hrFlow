<?php
use common\generators\mvc\model\Generator;
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $modelClassName string related model class name */
/* @var $this yii\web\View */
/* @var $generator \common\generators\mvc\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $traitScopeClassName string list of relations (name => relation declaration) */
/* @var $traitRelationClassName string list of relations (name => relation declaration) */
/* @var $traitGetterClassName string list of relations (name => relation declaration) */
/* @var $traitSetterClassName string list of relations (name => relation declaration) */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}



echo "<?php\n";
?>

namespace <?= $generator->serviceNs ?>;

use common\models\getter\DefaultGetterTrait;
use <?=$generator->repositoryNs?>\<?=$repositoryClassName?>;
use <?=$generator->dtoNs?>\<?=lcfirst($modelClassName)?>\<?=$createDTOClassName?>;
use <?=$generator->dtoNs?>\<?=lcfirst($modelClassName)?>\<?=$updateDTOClassName?>;
use <?=$generator->ns?>\<?=$modelClassName?>;
use yii\base\Model;
/**
* This is the Getter Trait class for [[<?= $modelFullClassName ?>]].
*
* @see <?= $modelClassName . "\n" ?>
*/
class <?= $className ?> extends Model  <?=  "\n" ?>
{

    private $repository;

    public function __construct(<?=$repositoryClassName?> $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }


    public function create(<?=$createDTOClassName?> $createDTO):<?=$modelClassName?><?="\n" ?>
    {
      $model = new <?=$modelClassName?>(); <?=  "\n" ?>
<?php foreach ($properties as $property => $data): ?>
<?php if(in_array($property,\common\generators\mvc\helpers\AttributeHelper::getCommonAttributesList())) continue; ?>
<?php $typeColumn = $data['type']; if ($typeColumn == "double") { $typeColumn = "float"; } ?>
<?php $attribute=str_replace(' ','',ucwords(str_replace('_',' ',$property))); ?>
<?php $value=lcfirst(str_replace(' ','',ucwords(str_replace('_',' ',$property)))); ?>
      $model->set<?=$attribute?>($createDTO-><?=$value?>);<?="\n" ?>
<?php endforeach; ?><?="\n" ?>
      return $this->repository->saveThrow($model);<?="\n" ?>
    }<?="\n" ?><?="\n" ?>
    public function update(<?=$modelClassName?> $model,<?=$updateDTOClassName?> $updateDTO):<?=$modelClassName?><?="\n" ?>
    {
<?php foreach ($properties as $property => $data): ?>
<?php if(in_array($property,\common\generators\mvc\helpers\AttributeHelper::getCommonAttributesList())) continue; ?>
<?php $typeColumn = $data['type']; if ($typeColumn == "double") { $typeColumn = "float"; } ?>
<?php $attribute=str_replace(' ','',ucwords(str_replace('_',' ',$property))); ?>
<?php $value=lcfirst(str_replace(' ','',ucwords(str_replace('_',' ',$property)))); ?>
      $model->set<?=$attribute?>($updateDTO-><?=$value?>);<?="\n" ?>
<?php endforeach; ?><?="\n" ?>
      return $this->repository->saveThrow($model);<?="\n" ?>
    }<?="\n" ?><?="\n" ?>

}
