<?php

class UserGroupTransformer extends League\Fractal\TransformerAbstract
{

    /**
     * Turn item into generic array
     *
     * @param  UserGroup $group
     * @return array
     */
    public function transform(UserGroup $group)
    {
        return [
            'id' => (int) $group->id,
            'name' => $group->name,
            'permissions' => $group->permissions,
            'created_at' => $group->created_at,
            'updated_at' => $group->updated_at,
        ];
    }
}
