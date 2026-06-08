<?php
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

namespace <?= $generator->queryNs ?>;

use common\models\query\DefaultEntityQueryTrait;
/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->queryBaseClass, '\\') . "\n" ?>
{
    use DefaultEntityQueryTrait;<?="\n"; ?>

<?php foreach ($properties as $property => $data): ?>
<?php if(in_array($property,\common\generators\mvc\helpers\AttributeHelper::getCommonAttributesList())) continue; ?>
<?php $typeColumn = $data['type']; if ($typeColumn == "double") { $typeColumn = "float"; } ?>
    public function <?= lcfirst(str_replace(' ','',ucwords(str_replace('_',' ',$property)))) ?>($value):self
    {
        return $this->andWhere([$this->getTableName() . '.[[<?=$property?>]]' => $value]);<?="\n" ?>
    }
<?php endforeach; ?>

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
