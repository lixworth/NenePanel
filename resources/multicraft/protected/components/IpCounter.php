<?php
/**
 *
 *   Copyright © 2010-2021 by xhost.ch GmbH
 *
 *   All rights reserved.
 *
 **/
class IpCounter
{
    static function ip()
    {
        return Yii::app()->user->ip;
    }

    static function limit()
    {
        return intval(@Yii::app()->params['login_tries']);
    }

    static function interval()
    {
        return intval(@Yii::app()->params['login_interval']);
    }

    static function recordFail()
    {
        if (!IpCounter::limit())
            return;
        $sql = 'select `count`,`time` from `ip_counter` where `ip`=:ip';
        try {
            $row = Yii::app()->db->createCommand($sql)->queryRow(false, array(
                'ip'=>IpCounter::ip(),
            ));
        } catch (Exception $e) {
            return;
        }
        if (!$row)
            $sql = 'insert into `ip_counter` (`ip`,`time`,`count`) values (:ip, :time, :count)';
        else
            $sql = 'update `ip_counter` set `count`=:count, `time`=:time where `ip`=:ip';
        Yii::app()->db->createCommand($sql)->execute(array(
            'ip'=>IpCounter::ip(),
            'time'=>time(),
            'count'=>($row && ($row[1] < (time() - IpCounter::interval()))) ? 1 : (intval(@$row[0]) + 1),
        ));
    }

    static function recordSuccess()
    {
        if (!IpCounter::limit())
            return;
        $sql = 'delete from `ip_counter` where `time`<:time';
        try {
            Yii::app()->db->createCommand($sql)->execute(array(
                'time'=>(time() - IpCounter::interval())
            ));
        } catch (Exception $e) {
            return;
        }
    }

    static function blocked()
    {
        if (!IpCounter::limit())
            return false;
        $sql = 'select 1 from `ip_counter` where `ip`=:ip and `time`>=:time and `count`>=:count';
        try {
            return 1 == Yii::app()->db->createCommand($sql)->queryScalar(array(
                'ip'=>IpCounter::ip(),
                'time'=>(time() - IpCounter::interval()),
                'count'=>IpCounter::limit(),
            ));
        } catch (Exception $e) {
            return false;
        }
    }
}
