<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Domain\Dao\UserDao;
use App\Domain\Model\User;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Security;

final class DeleteUser
{
    private UserDao $userDao;

    public function __construct(
        UserDao $userDao
    ) {
        $this->userDao = $userDao;
    }

    /**
     * @Mutation
     * @Logged
     * @Security("is_granted('ROLE_ADMINISTRATOR')")
     */
    public function deleteUser(User $user): bool
    {
        // Cascade = true will also delete the reset
        // password token (if any).
        $this->userDao->delete($user, true);

        return true;
    }
}
