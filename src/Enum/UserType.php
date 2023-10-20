<?php

namespace App\Enum;

use App\Entity\Admin;
use App\Entity\SuperAdmin;
use App\Entity\Client;
use App\Entity\Owner;

class UserType
{

    public const CLIENT = 'client';
    public const OWNER = 'owner';
    public const ADMIN = 'admin';
    public const SUPERADMIN = 'superAdmin';

    /**
     * Returns the corresponding `discr` value according to the class type of the user.
     * @see Account
     */
    public static function getUserTypeFromClassType($classType) {
        switch ($classType){
            case Client::class:
                return self::CLIENT;
            case Owner::class;
                return self::OWNER;
            case Admin::class;
                return self::ADMIN;
            case SuperAdmin::class;
                return self::SUPERADMIN;
            default:
                return null;
        }
    }

    /**
     * Returns the class type of the account according to the `discr` value.
     * @return null|string
     */
    public static function getClassTypeFromUserType($userType) {
        switch ($userType){
            case self::CLIENT:
                return Client::class;
            case self::OWNER:
                return Owner::class;
            case self::ADMIN:
                return Admin::class;
            case self::SUPERADMIN:
                return SuperAdmin::class;
            default:
                return null;
        }
    }

}