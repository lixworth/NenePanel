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

namespace App\Model\Panel;

use App\Model\Model;

class CommandCache extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'command_cache';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'panel';
}