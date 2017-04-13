<?php

namespace Laralum\Advertisements\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisementPolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can view advertisements moule.
     *
     * @param  mixed $user
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.access');
    }

    /**
     * Determine if the current user can view advertisements statistics.
     *
     * @param  mixed $user
     * @return bool
     */
    public function statistics($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.statistics');
    }

    /**
     * Determine if the current user can view specific advertisement statistics.
     *
     * @param  mixed $user
     * @return bool
     */
    public function specific_statistics($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.specific_statistics');
    }

    /**
     * Determine if the current user can (pre)view advertisements.
     *
     * @param  mixed $user
     * @return bool
     */
    public function view($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.view');
    }

    /**
     * Determine if the current user can create advertisements.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.create');
    }

    /**
     * Determine if the current user can update advertisements.
     *
     * @param  mixed $user
     * @return bool
     */
    public function update($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.update');
    }

    /**
     * Determine if the current user can delete advertisements.
     *
     * @param  mixed $user
     * @return bool
     */
    public function delete($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::advertisements.delete');
    }

}
