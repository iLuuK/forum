<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AuthenticationDeletedException extends AccountStatusException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Le compte est supprimé';
    }
}