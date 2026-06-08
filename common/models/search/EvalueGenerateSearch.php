<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EvalueGenerate;

/**
 * EvalueGenerateSearch represents the model behind the search form about `common\models\EvalueGenerate`.
 */
class EvalueGenerateSearch extends EvalueGenerate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fileable_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['fileable_type', 'data'], 'safe'],
            [['sum'], 'number'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EvalueGenerate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fileable_id' => $this->fileable_id,
            'sum' => $this->sum,
            'order' => $this->order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['ilike', 'fileable_type', $this->fileable_type])
            ->andFilterWhere(['ilike', 'data', $this->data]);

        return $dataProvider;
    }
}
