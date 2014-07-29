<?php

/**
 * Class UserTransformer
 */
class UserTransformer extends League\Fractal\TransformerAbstract
{

    /**
     * List resources possible to embed via this transformer
     *
     * @var array
     */
    protected $availableIncludes = [
        'groups',
    ];

    /**
     * Turn item into generic array
     *
     * @param  User  $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'activated' => $user->activated,
            'permissions' => $user->permissions,
            'last_login' => $user->last_login,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    /**
     * Embed groups
     *
     * @param  User                         $user
     * @return \League\Fractal\ItemResource
     */
    public function includeGroups(User $user)
    {
        $groups = $user->groups;

        return $this->collection($groups, new UserGroupTransformer());
    }
}
