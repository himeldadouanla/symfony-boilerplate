<?php

declare(strict_types=1);

namespace App\Domain\Enum\Filter;

use MyCLabs\Enum\Enum;
use TheCodingMachine\GraphQLite\Annotations as GraphQLite;

/**
 * @method static EmployeesSortBy FULL_NAME()
 * @method static EmployeesSortBy ADDRESS()
 * @method static EmployeesSortBy PHONE()
 * @method static EmployeesSortBy EMAIL()
 */
#[GraphQLite\EnumType]
final class EmployeesSortBy extends Enum
{
    private const FULL_NAME = 'full_name';
    private const ADDRESS  = 'address';
    private const PHONE  = 'phone';
    private const EMAIL      = 'email';
}
