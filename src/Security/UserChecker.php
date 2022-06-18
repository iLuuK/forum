<?php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->getIsClose()) {
            throw new CustomUserMessageAuthenticationException("Le compte est clôturé.");
        }

        if ($user->getIsBan()) {
            throw new CustomUserMessageAuthenticationException("Le compte est banni.");
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