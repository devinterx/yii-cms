<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\base\InvalidConfigException;
use yii\db\Schema;
use yii\rbac\DbManager;

/**
 * Initializes RBAC tables
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($authManager->ruleTable, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => Schema::TYPE_STRING . '(64)',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id' => Schema::TYPE_STRING . '(64) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        // Permissions
        $accessBackend = $authManager->createPermission('accessBackend');
        $accessBackend->description = 'Can access old_backend';
        $authManager->add($accessBackend);

        $administrateRBAC = $authManager->createPermission('administrateRBAC');
        $administrateRBAC->description = 'Can administrate all "RBAC" module';
        $authManager->add($administrateRBAC);

        $BViewRoles = $authManager->createPermission('BViewRoles');
        $BViewRoles->description = 'Can view roles list';
        $authManager->add($BViewRoles);

        $BCreateRoles = $authManager->createPermission('BCreateRoles');
        $BCreateRoles->description = 'Can create roles';
        $authManager->add($BCreateRoles);

        $BUpdateRoles = $authManager->createPermission('BUpdateRoles');
        $BUpdateRoles->description = 'Can update roles';
        $authManager->add($BUpdateRoles);

        $BDeleteRoles = $authManager->createPermission('BDeleteRoles');
        $BDeleteRoles->description = 'Can delete roles';
        $authManager->add($BDeleteRoles);

        $BViewPermissions = $authManager->createPermission('BViewPermissions');
        $BViewPermissions->description = 'Can view permissions list';
        $authManager->add($BViewPermissions);

        $BCreatePermissions = $authManager->createPermission('BCreatePermissions');
        $BCreatePermissions->description = 'Can create permissions';
        $authManager->add($BCreatePermissions);

        $BUpdatePermissions = $authManager->createPermission('BUpdatePermissions');
        $BUpdatePermissions->description = 'Can update permissions';
        $authManager->add($BUpdatePermissions);

        $BDeletePermissions = $authManager->createPermission('BDeletePermissions');
        $BDeletePermissions->description = 'Can delete permissions';
        $authManager->add($BDeletePermissions);

        $BViewRules = $authManager->createPermission('BViewRules');
        $BViewRules->description = 'Can view rules list';
        $authManager->add($BViewRules);

        $BCreateRules = $authManager->createPermission('BCreateRules');
        $BCreateRules->description = 'Can create rules';
        $authManager->add($BCreateRules);

        $BUpdateRules = $authManager->createPermission('BUpdateRules');
        $BUpdateRules->description = 'Can update rules';
        $authManager->add($BUpdateRules);

        $BDeleteRules = $authManager->createPermission('BDeleteRules');
        $BDeleteRules->description = 'Can delete rules';
        $authManager->add($BDeleteRules);

        $BViewRoutes = $authManager->createPermission('BViewRoutes');
        $BViewRoutes->description = 'Can view routes list';
        $authManager->add($BViewRoutes);

        $BCreateRoutes = $authManager->createPermission('BCreateRoutes');
        $BCreateRoutes->description = 'Can create routes';
        $authManager->add($BCreateRoutes);

        $BUpdateRoutes = $authManager->createPermission('BUpdateRoutes');
        $BUpdateRoutes->description = 'Can edit routes';
        $authManager->add($BUpdateRoutes);

        $BViewAssignments = $authManager->createPermission('BViewAssignments');
        $BViewAssignments->description = 'Can view list of assignments';
        $authManager->add($BViewAssignments);

        $BUpdateAssignments = $authManager->createPermission('BUpdateAssignments');
        $BUpdateAssignments->description = 'Can edit users assignments';
        $authManager->add($BUpdateAssignments);

        $BViewUsers = $authManager->createPermission('BViewUsers');
        $BViewUsers->description = 'Can view users list';
        $authManager->add($BViewUsers);

        $BCreateUsers = $authManager->createPermission('BCreateUsers');
        $BCreateUsers->description = 'Can create users';
        $authManager->add($BCreateUsers);

        $BUpdateUsers = $authManager->createPermission('BUpdateUsers');
        $BUpdateUsers->description = 'Can edit users';
        $authManager->add($BUpdateUsers);

        $BDeleteUsers = $authManager->createPermission('BDeleteUsers');
        $BDeleteUsers->description = 'Can delete users';
        $authManager->add($BDeleteUsers);

        // Assignments
        $authManager->addChild($administrateRBAC, $BViewRoles);
        $authManager->addChild($administrateRBAC, $BCreateRoles);
        $authManager->addChild($administrateRBAC, $BUpdateRoles);
        $authManager->addChild($administrateRBAC, $BDeleteRoles);
        $authManager->addChild($administrateRBAC, $BViewPermissions);
        $authManager->addChild($administrateRBAC, $BCreatePermissions);
        $authManager->addChild($administrateRBAC, $BUpdatePermissions);
        $authManager->addChild($administrateRBAC, $BDeletePermissions);
        $authManager->addChild($administrateRBAC, $BViewRules);
        $authManager->addChild($administrateRBAC, $BCreateRules);
        $authManager->addChild($administrateRBAC, $BUpdateRules);
        $authManager->addChild($administrateRBAC, $BDeleteRules);
        $authManager->addChild($administrateRBAC, $BViewRoutes);
        $authManager->addChild($administrateRBAC, $BCreateRoutes);
        $authManager->addChild($administrateRBAC, $BUpdateRoutes);
        $authManager->addChild($administrateRBAC, $BViewAssignments);
        $authManager->addChild($administrateRBAC, $BUpdateAssignments);
        $authManager->addChild($administrateRBAC, $BViewUsers);
        $authManager->addChild($administrateRBAC, $BCreateUsers);
        $authManager->addChild($administrateRBAC, $BUpdateUsers);
        $authManager->addChild($administrateRBAC, $BDeleteUsers);

        // Roles
        $user = $authManager->createRole('user');
        $user->description = 'User';
        $authManager->add($user);

        $admin = $authManager->createRole('admin');
        $admin->description = 'Admin';
        $authManager->add($admin);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $accessBackend);
        $authManager->addChild($admin, $administrateRBAC);

        $authManager->assign($admin, 1);
    }

    public function down()
    {
        $authManager = $this->getAuthManager();
        $authManager->removeAll();
        $this->db = $authManager->db;

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
}
