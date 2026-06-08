<?php
use common\generators\mvc\model\Generator;
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

namespace <?= $generator->scopeTraitsNs ?>;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the Attribute Trait class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 */
trait <?= $className ?>  <?=  "\n" ?>
{
        /**
         *  {@inheritdoc}
         */
        public function rules()
        {
             return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
        }

        public function behaviors()
        {
                return ArrayHelper::merge(parent::behaviors(), [
                        'time' => [
                             'class' => TimestampBehavior::class,
                        ],
                        'by' => [
                              'class' => BlameableBehavior::class
                        ],
                        'delete' => [
                            'class' => SoftDeleteBehavior::className(),
                            'softDeleteAttributeValues' => [
                                'is_deleted' => true,
                                'deleted_at' => time(),
                                'deleted_by' => \Yii::$app->user->id ?? null
                            ],
                             'replaceRegularDelete' => true
                        ],
                ]);
        }
}
