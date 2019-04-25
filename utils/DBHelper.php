<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-28
 * Time: 下午7:38
 */

namespace app\utils;


use app\models\MusicDevice;
use Yii;
use yii\db\Query;

class DBHelper
{

    public static function getDB()
    {
        return Yii::$app->db;
    }

    public static function newQuery()
    {
        return new Query();
    }

    public static function insert($table, $data)
    {
        if (count($data) === 0) {

            return 0;
        }
        $keys = [];
        $values = [];
        foreach ($data[0] as $k => $v) {
            $keys[] = $k;
        }
        foreach ($data as $item) {
            $vs = [];
            foreach ($item as $k => $v) {
                $vs[] = $v;
            }
            $values[] = $vs;

        }

        $com = self::getDB()
            ->createCommand()
            ->batchInsert($table, $keys, $values);
        Debugger::log($com->getRawSql(), 'sql');
        return $com->execute();


    }

    public static function limitAll($limit, $offset, $table, $col)
    {
        $list =self::newQuery()
            ->from($table)
            ->select($col)
            ->offset($offset)
            ->limit($limit)
            ->all();

        $count = self::newQuery()
            ->from($table)
            ->count('id');

        $ret = [
            'total' => $count,
            'rows' => $list,
        ];
        RequestHelper::formatJson();
        return $ret;
    }

    public static function limitWhere($limit, $offset, $table, array $col, array $condition)
    {
        $list = self::newQuery()
            ->from($table)
            ->select($col)
            ->where($condition)
            ->offset($offset)
            ->limit($limit)
            ->all();

        $count = self::newQuery()
            ->from($table)
            ->where($condition)
            ->count('id');

        $ret = [
            'total' => $count,
            'rows' => $list,
        ];
        RequestHelper::formatJson();
        return $ret;
    }
}
