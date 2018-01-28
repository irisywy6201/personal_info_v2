<?php

namespace App\Entities;

use App\Ncucc\AppConfig;

class NcuRemoteDB extends BaseEntity
{

    public $timestamps = false;
    protected $connection = 'NcuRemoteDB';
    protected $fillable = [];

    /**
     * The table names of NCU remote database which stores information
     * of NCU users such as Chinese name, English name, personal ID number,...
     * and so on.
     */
    private static $infoTableNames = [
        'student_info', 'schoolmate_info', 'staff_info'
    ];

    /**
     * Retrieves the real name of user.
     * @param int $portalID The portal ID number of user.
     * @param int $role The AppConfig role of user.
     * @return string | null Returns the real name of user.
     */
    public static function getUserRealName($portalID, $role) {
        $tableNames = NcuRemoteDB::toTableNames($role);

        if ($tableNames == null) {
            return null;
        }

        $personalID = NcuRemoteDB::getPersonalID($tableNames, $portalID, $role);

        if (!$personalID) {
            return null;
        }
        
        $remoteDB = new NcuRemoteDB;
        $remoteDB->setTable('basicinfo');

        return NcuRemoteDB::retrieveName($remoteDB, $personalID);
    }

    /**
     * Converts the given role to a ranked NCU remote DB info table name.
     * @param int $role The role of user.
     * @return array Returns a ranked array with info table names.
     */
    private static function toTableNames($role) {
        $tableNames = NcuRemoteDB::$infoTableNames;
        $topOneTableName = NcuRemoteDB::toTableName($role);
        $topElementKey = array_search($topOneTableName, $tableNames);
        unset($tableNames[$topElementKey]);
        array_unshift($tableNames, $topOneTableName);

        return $tableNames;
    }

    /**
     * Converts the user role into remote database table name.
     * @param int $role The AppConfig role of user.
     * @return string | null Returns the remote table name.
     */
    private static function toTableName($role) {
        if ($role & AppConfig::ROLE_STUDENT) {
            return 'student_info';
        }

        if ($role & AppConfig::ROLE_FACULTY) {
            return 'staff_info';
        }

        if ($role & AppConfig::ROLE_ALUMNI) {
            return 'schoolmate_info';
        }

        return null;
    }

    /**
     * Retrieves the real name (Chinese or English) from the given connection
     * and personal ID number.
     * @param NcuRemoteDB $dbConnection The database connection.
     * @param string $personalID the personal ID number.
     * @return string | null Returns the real name of interesting user.
     */
    private static function retrieveName($dbConnection, $personalID) {
        $realName = null;
        $realName = $dbConnection->where('personal_no', $personalID)->pluck('cname');
        
        if (!$realName) {
            $realName = $dbConnection->where('personal_no', $personalID)->pluck('ename');
        }

        return $realName;
    }

    /**
     * Gets the personal ID number from the ranked info table names.
     * @param array $tableNames The ranked info table names.
     * @param string $portalID The portal ID number of user.
     * @param int $role The role of user.
     * @return string | null Returns the personal ID number of user.
     */
    private static function getPersonalID($tableNames, $portalID, $role) {
        $personalID = null;

        foreach ($tableNames as $key => $tableName) {
            $remoteDB = new NcuRemoteDB;
            $remoteDB->setTable($tableName);

            if ($tableName === 'staff_info') {
                $personalID = $remoteDB->where('portal_id', $portalID)->pluck('personal_no');
            }
            else {
                $personalID = $remoteDB->where('s_id', $portalID)->pluck('personal_no');
            }

            if ($personalID) {
                return $personalID;
            }
        }

        return null;
    }

}

?>