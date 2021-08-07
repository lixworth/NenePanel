<?php
/**
 * Cattery Mc
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Cattery Team
 */

namespace App\Model\Daemon;

use App\Model\Model;


class FtpUserServer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ftp_user_server';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'daemon';
}