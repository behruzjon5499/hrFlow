<?php

namespace common\models;

use backend\modules\rbac\models\RbacAuthItemChild;
use common\enums\RoleEnum;
use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $order
 */
class AuthItem extends \yii\db\ActiveRecord
{
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'rbac_auth_item';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['order', 'type'], 'safe'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * Attribute labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => t('Name'),
            'type' => t('Type'),
            'description' => t('Description'),
            'rule_name' => t('Rule name'),
            'data' => t('Data'),
            'created_at' => t('Created on'),
            'updated_at' => t('Updated on'),
        ];
    }

    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['permissions'] = 'permissions';
        $extraFields['pages'] = 'pages';
        return $extraFields;
    }


    public function getPages()
    {
        $items = [];
        foreach (RoleEnum::PERMISSIONS as $key=>$permission) {
            $actions = [];
            foreach (RoleEnum::ACTIONS as $key1=>$action) {
                $item=[];
                $item['name'] =$key1;
                $item['value'] = self::check($key, $key1);
                $item['label'] = $action;
                $actions[] = $item;
            }
            $items[] = [
                $key => [
                    'actions' => $actions,
                    'label' => $permission,
                ]
            ];
        }
        return $items;
    }

    public function check($permission,$action)
    {

       return RbacAuthItemChild::find()->andWhere(['parent' => $this->name])
            ->andWhere(new \yii\db\Expression("
        split_part(child, '-', 1) = :module
        AND
        split_part(child, '-', 2) = :action
    ", [
                ':module' => $permission,
                ':action' => $action
            ]))
            ->exists();


    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * Gets query for [[AuthItemChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * Gets query for [[AuthItemChildren0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('rbac_auth_item_child', ['parent' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('rbac_auth_item_child', ['child' => 'name']);
    }

    /**
     * Get created by
     *
     * @return void
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Get created by
     *
     * @return void
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
