<?php
use common\generators\insp\model\Generator;
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator Generator */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $modelClassName string related model class name */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

echo "<?php\n";
?>

namespace <?= $generator->traitsNs ?>;

/**
 * This is the Attribute Trait class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 */
trait <?= $className ?>  <?=  "\n" ?>
{

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
    return [
    <?php foreach ($labels as $name => $label): ?>
        <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
    <?php endforeach; ?>
    ];
    }

}
