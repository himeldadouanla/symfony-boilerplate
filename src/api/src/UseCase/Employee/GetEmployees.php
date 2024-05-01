<?php

declare(strict_types=1);

namespace App\UseCase\Employee;

use App\Domain\Dao\EmployeeDao;
use App\Domain\Enum\Filter\EmployeesSortBy;
use App\Domain\Enum\Filter\SortOrder;
use App\Domain\Model\Employee;
use TheCodingMachine\GraphQLite\Annotations\Factory;
use TheCodingMachine\GraphQLite\Annotations\HideParameter;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Security;
use TheCodingMachine\TDBM\ResultIterator;

final class GetEmployees
{
    private EmployeeDao $employeeDao;

    public function __construct(EmployeeDao $employeeDao)
    {
        $this->employeeDao = $employeeDao;
    }

    /**
     * @return ResultIterator|Employee[]
     * @phpstan-return ResultIterator<Employee>
     *
     * @noinspection PhpDocSignatureInspection
     */
    #[Query]
    #[Logged]
    #[Security("is_granted('ROLE_ADMINISTRATOR')")]
    public function employees(
        ?string $search = null,
        //?EmployeesSortBy $sortBy = null,
        ?SortOrder $sortOrder = null
    ): ResultIterator {
        return $this->employeeDao->search(
            $search,
            //$sortBy,
            null,
            $sortOrder
        );
    }
}
