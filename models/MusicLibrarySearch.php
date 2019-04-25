<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MusicLibrary;

/**
 * MusicLibrarySearch represents the model behind the search form of `app\models\MusicLibrary`.
 */
class MusicLibrarySearch extends MusicLibrary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'musicSize', 'playTime'], 'integer'],
            [['musicNo', 'musicName', 'musicUrl', 'md5', 'createTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = MusicLibrary::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'musicSize' => $this->musicSize,
            'playTime' => $this->playTime,
            'createTime' => $this->createTime,
        ]);

        $query->andFilterWhere(['like', 'musicNo', $this->musicNo])
            ->andFilterWhere(['like', 'musicName', $this->musicName])
            ->andFilterWhere(['like', 'musicUrl', $this->musicUrl])
            ->andFilterWhere(['like', 'md5', $this->md5]);

        return $dataProvider;
    }
}
