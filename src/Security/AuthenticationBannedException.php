<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AuthenticationBannedException extends AccountStatusException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Le compte est banni';
    }
}