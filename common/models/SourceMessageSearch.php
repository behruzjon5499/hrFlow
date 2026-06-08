<?php

namespace common\models;

use common\models\SourceMessage;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * SourceMessageSearch represents the model behind the search form about `common\models\SourceMessage`.
 */
class SourceMessageSearch extends SourceMessage
{
    /**
     * @inheritdoc
     */

    public $translation;
    public $language;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message', 'translation', 'language'], 'safe'],
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
        $query = SourceMessage::find();

        // add conditions that should always apply here

        $sort = new Sort();
        $sort->defaultOrder = ['id' => SORT_DESC];

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->joinWith(['messages'])->distinct();

        $query->andFilterWhere(['like', SourceMessage::tableName().'.category', $this->category])
            ->andFilterWhere(['or', ['like', Message::tableName().'.translation', $this->message], ['like',  SourceMessage::tableName().'.message', $this->message]])
            ->andFilterWhere([Message::tableName().'.language' => $this->language]);

        return $dataProvider;
    }
}
