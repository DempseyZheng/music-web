<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MusicDevice;

/**
 * MusicDeviceSearch represents the model behind the search form of `app\models\MusicDevice`.
 */
class MusicDeviceSearch extends MusicDevice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'onlineStatus', 'registerStatus'], 'integer'],
            [['deviceNo', 'deviceName', 'mac', 'storeNo', 'storageCard', 'appVersion', 'deviceSound', 'lastMsgTime', 'createTime', 'updateTime'], 'safe'],
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
        $query = MusicDevice::find();

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
            'onlineStatus' => $this->onlineStatus,
            'registerStatus' => $this->registerStatus,
            'lastMsgTime' => $this->lastMsgTime,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'deviceNo', $this->deviceNo])
            ->andFilterWhere(['like', 'deviceName', $this->deviceName])
            ->andFilterWhere(['like', 'mac', $this->mac])
            ->andFilterWhere(['like', 'storeNo', $this->storeNo])
            ->andFilterWhere(['like', 'storageCard', $this->storageCard])
            ->andFilterWhere(['like', 'appVersion', $this->appVersion])
            ->andFilterWhere(['like', 'deviceSound', $this->deviceSound]);

        return $dataProvider;
    }
}
