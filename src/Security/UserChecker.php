<?php
namespace App\Security;

use App\Entity\User;
use App\Security\AuthenticationBannedException;
use App\Security\AuthenticationDeletedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->isDeleted()) {
            throw new AuthenticationDeletedException("Mauvais identifiant");
        }

        if ($user->isBan()) {
            throw new AuthenticationBannedException("Vous avez été banni");
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        return;
    }
}