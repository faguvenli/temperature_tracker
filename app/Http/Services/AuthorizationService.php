<?php

namespace App\Http\Services;

use Illuminate\Validation\ValidationException;

class AuthorizationService
{
    public $name;

    private const AUTH_MESSAGE = "Bu işlemi yapmak için yetkiniz bulunmamaktadır."; // You don't have authorization to do this.

    private $user;

    private $isSuperAdmin = false;

    /**
     * @return void
     */
    public function check_SuperAdmin(): bool
    {
        $this->user = auth()->user();
        $this->isSuperAdmin = $this->user->isSuperAdmin ?? false;
        return $this->isSuperAdmin;
    }

    /**
     * @return bool
     */
    public function canDisplayAndModify(): bool
    {
        if ($this->check_SuperAdmin()) {
            return true;
        }

        if(!$this->user) {
            throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
        }

        if (
            !$this->user->hasPermissionTo($this->name . ' - Görüntüle') &&
            !$this->user->hasPermissionTo($this->name . ' - Ekle') &&
            !$this->user->hasPermissionTo($this->name . ' - Düzenle') &&
            !$this->user->hasPermissionTo($this->name . ' - Sil')
        ) {

            if (!$this->isSuperAdmin) {
                throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function canDisplay($sidebar = false): bool
    {
        if ($this->check_SuperAdmin()) {
            return true;
        }

        if(!$this->user) {
            throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
        }

        if (!$this->user->hasPermissionTo($this->name . ' - Görüntüle')) {

            if (!$this->isSuperAdmin) {
                if($sidebar) {
                    return false;
                }
                throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function canCreate(): bool
    {

        if ($this->check_SuperAdmin()) {
            return true;
        }

        if(!$this->user) {
            throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
        }

        if (!$this->user->hasPermissionTo($this->name . ' - Ekle')) {

            if (!$this->isSuperAdmin) {
                throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function canUpdate(): bool
    {

        if ($this->check_SuperAdmin()) {
            return true;
        }

        if(!$this->user) {
            throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
        }

        if (!$this->user->hasPermissionTo($this->name . ' - Düzenle')) {

            if (!$this->isSuperAdmin) {
                throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function canDelete(): bool
    {

        if ($this->check_SuperAdmin()) {
            return true;
        }

        if(!$this->user) {
            throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
        }

        if (!$this->user->hasPermissionTo($this->name . ' - Sil')) {

            if (!$this->isSuperAdmin) {
                throw ValidationException::withMessages(["authorization" => self::AUTH_MESSAGE]);
            }
        }
        return true;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): AuthorizationService
    {
        $this->name = $name;
        return $this;
    }
}
