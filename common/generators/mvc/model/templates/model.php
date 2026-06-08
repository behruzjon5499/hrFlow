<?php
/**
 * This is the template for generating the model class of a specified table.
 */

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

echo "<?php\n";

$relationsVars=[];
?>
<?php if ($relations) :?>
    <?php foreach ($relations as $name => $relation): ?><?php $relationsVars[] = lcfirst($name); ?><?php endforeach; ?>
<?php endif;?>

namespace <?= $generator->ns ?>;

use Yii;
use  <?= $generator->scopeTraitsNs ?>\<?=$traitScopeClassName?>;
use  <?= $generator->relationTraitsNs ?>\<?=$traitRelationClassName?>;
use  <?= $generator->getterTraitsNs ?>\<?=$traitGetterClassName?>;
use  <?= $generator->setterTraitsNs ?>\<?=$traitSetterClassName?>;

/**
* This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
*
* @OA\Schema(
*     description="<?= count($relationsVars) > 0 ? "include=" . implode(",", $relationsVars) : "" ?>"
* )
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
     use <?=$traitScopeClassName?>;<?= "\n" ?>
     use <?=$traitRelationClassName?>;<?= "\n" ?>
     use <?=$traitGetterClassName?>;<?= "\n" ?>
     use <?=$traitSetterClassName?>;<?= "\n" ?>

<?php foreach ($properties as $property => $data): ?>
<?php
    $swaggerType = $data['type'];
    if ($swaggerType == "int") {
        $swaggerType = "integer";
    }
    ?>
    /**
     * @OA\Property(
     *   property="<?= str_replace("$", null, $property) ?>",
     *   type="<?= $swaggerType ?>",
     *   description="<?= $labels[str_replace("$", null, $property)] ?>"
     * )
    */
<?php endforeach; ?>

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>


<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find():<?= $queryClassFullName ?><?= "\n" ?>
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
