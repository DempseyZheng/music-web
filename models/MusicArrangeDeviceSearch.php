<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MusicArrangeDevice;

/**
 * MusicArrangeDeviceSearch represents the model behind the search form of `app\models\MusicArrangeDevice`.
 */
class MusicArrangeDeviceSearch extends MusicArrangeDevice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'progress', 'pubStatus', 'arrangeStatus', 'arrangeLevel'], 'integer'],
            [['storeNo', 'deviceNo', 'arrangeNo', 'arrangeName', 'beginDate', 'endDate', 'beginTime', 'endTime', 'createTime', 'updateTime'], 'safe'],
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
        $query = MusicArrangeDevice::find();

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
            'progress' => $this->progress,
            'pubStatus' => $this->pubStatus,
            'arrangeStatus' => $this->arrangeStatus,
            'beginDate' => $this->beginDate,
            'endDate' => $this->endDate,
            'arrangeLevel' => $this->arrangeLevel,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'storeNo', $this->storeNo])
            ->andFilterWhere(['like', 'deviceNo', $this->deviceNo])
            ->andFilterWhere(['like', 'arrangeNo', $this->arrangeNo])
            ->andFilterWhere(['like', 'arrangeName', $this->arrangeName])
            ->andFilterWhere(['like', 'beginTime', $this->beginTime])
            ->andFilterWhere(['like', 'endTime', $this->endTime]);

        return $dataProvider;
    }
}
