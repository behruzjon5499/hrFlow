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

namespace <?= $generator->setterTraitsNs ?>;

use common\models\setter\DefaultSetterTrait;
/**
* This is the Setter Trait class for [[<?= $modelFullClassName ?>]].
*
* @see <?= $modelFullClassName . "\n" ?>
*/
trait <?= $className ?>  <?=  "\n" ?>
{
    use DefaultSetterTrait;<?=  "\n" ?>

<?php foreach ($properties as $property => $data): ?>
<?php if(in_array($property,\common\generators\mvc\helpers\AttributeHelper::getCommonAttributesList())) continue; ?>
    public function set<?= str_replace(' ','',ucwords(str_replace('_',' ',$property))) ?>($value)<?="\n" ?>
    {
        $this-><?=$property?> = $value;<?="\n" ?>
    }
<?php endforeach; ?>

}
