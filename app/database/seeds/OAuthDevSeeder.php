<?php

class OAuthDevSeeder extends Seeder
 {
    
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
     {
                // Create the available OAuth Grants.
                OAuthGrant::insert(array('grant' => 'password'));
        
                // Create the basic scope this is the default scope used during requests.
                OAuthScope::insert(array(
                        'scope'       => 'basic',
                        'name'        => 'Basic',
                        'description' => 'Default Scope - Most limited available scope',
                    ));
        
                // Insert an OAuth Client for development use.
                OAuthClient::insert(array(
                        'id'     => '1',
                        'secret' => '123456abcdef',
                        'name'   => 'Development',
                    ));
        
                // Link the development Client with the 'password' Grant.
                OAuthClientGrant::insert(array(
                        'client_id' => '1',
                        'grant_id'  => '1',
                    ));
        
                // Link the development Client with the 'basic' Scope.
                OAuthClientScope::insert(array(
                        'client_id' => '1',
                        'scope_id'  => '1',
                    ));
        
                // Create an User group.
                UserGroup::insert(array(
                        'name' => 'Employees',
                        'permissions' => '{"admin":1,"users":1}',
                    ));
        
                // Link the user with the 'Employees' User Group.
                UserGroupRelation::insert(array(
                        'user_id' => '1',
                        'group_id' => '1',
                    ));
            }
 
 }