<?php

namespace App\Policies;

use App\Realm;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RealmPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any realms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the realm.
     *
     * @param  \App\User  $user
     * @param  \App\Realm  $realm
     * @return mixed
     */
    public function view(?User $user, Realm $realm)
    {
        return true;
    }

    /**
     * Determine whether the user can create realms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the realm.
     *
     * @param  \App\User  $user
     * @param  \App\Realm  $realm
     * @return mixed
     */
    public function update(User $user, Realm $realm)
    {
        //
    }

    /**
     * Determine whether the user can delete the realm.
     *
     * @param  \App\User  $user
     * @param  \App\Realm  $realm
     * @return mixed
     */
    public function delete(User $user, Realm $realm)
    {
        //
    }

    /**
     * Determine whether the user can restore the realm.
     *
     * @param  \App\User  $user
     * @param  \App\Realm  $realm
     * @return mixed
     */
    public function restore(User $user, Realm $realm)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the realm.
     *
     * @param  \App\User  $user
     * @param  \App\Realm  $realm
     * @return mixed
     */
    public function forceDelete(User $user, Realm $realm)
    {
        //
    }
}
