<?php

namespace App\Model;


class UpdatePassword{
    private $oldPassword = "";
    private $newPassword = "";

    public function __construct()
    {
    }

    public function setOldPassword($oldPassword){
        $this->oldPassword = $oldPassword;
    }

    public function getOldPassword(): string{
        return $this->oldPassword;
    }

    public function setNewPassword($newPassword){
        $this->newPassword = $newPassword;
    }

    public function getNewPassword(): string{
        return $this->newPassword;
    }
}