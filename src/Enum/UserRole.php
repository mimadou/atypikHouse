<?php

namespace App\Enum;


class UserRole
{

    /**
     * The user is a owner
     */
    public const OWNER = 'ROLE_OWNER';

    /**
     * The user is a client (parent or pupil)
     */
    public const CLIENT = 'ROLE_CLIENT';
    /**
     * The user is a admin (parent or pupil)
     */
    public const ADMIN = 'ROLE_ADMIN';

    /**
     * The user is an admin. It is a status with privileged rights.
     */
    public const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

}