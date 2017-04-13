<?php
/**
 * Created by PhpStorm.
 * User: lance
 * Date: 4/9/17
 * Time: 6:00 PM
 */

namespace App;

class Constant
{
    public static $normalEvent = array(
        "batteryAlarm",
        "clearBattryAlarm",
        "brokenAlarm",
        "wrongPwdAlarm",
        "pwdSync",
        "pwdAddLocal",
        "pwdDelLocal",
        "pwdUpdateLocal",
        "lockerOpenAlarm",
        "centerOfflineAlarm",
        "lockOfflineAlarm",
        "clearCenterOfflineAlarm",
        "clearLockOfflineAlarm",
        "batteryAsync"
    );
    public static $pswdService = array(
        ' Password_Add_Service ',
        ' Password_Delete_Service ',
        ' Password_Update_Service ',
        ' Password_Frozen_Service ',
        ' Password_Unfrozen_Service '
    );
    public static $elemeterEvent = array(
        'elemeterPowerAsync',
        ' elemeterHistory',
        ' elemeterOvercomeAmount',
        ' elemeterOvercomeCapacity', ' elemeterLocalClose',
        ' elemeterTransError', 'pwdDelLocal'
    );
    public static $elemeterService =array(
        ' Elemeter_Control_Service ',
        ' Elemeter_Passthrough_Service '
    );

}