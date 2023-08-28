<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('sys_tasks')->insert([
			[
			    'module_id' 		=> '1', //Dashboard
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '2', //SysModule
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '2', //SysModule
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '2', //SysModule
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '2', //SysModule
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[

			    'module_id' 		=> '3', //SysTask
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '3', //SysTask
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '3', //SysTask
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
			    'module_id' 		=> '3', //SysTask
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[

				'module_id' 		=> '4', //SysRole
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '4', //SysRole
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '4', //SysRole
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '4', //SysRole
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[

				'module_id' 		=> '5', //SysMenu
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '5', //SysMenu
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '5', //SysMenu
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '5', //SysMenu
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[

				'module_id' 		=> '6', //Users
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '6', //Users
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '6', //Users
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '6', //Users
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[

				'module_id' 		=> '7', //UserGroup
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '7', //UserGroup
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '7', //UserGroup
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '7', //UserGroup
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '8', //LogActivity
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '8', //LogActivity
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '9', //LogActivity
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '8', //LogActivity
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '8', //LogActivity
				'task_name'			=> 'view',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '9', //Configuration
				'task_name'			=> 'index',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '9', //Configuration
				'task_name'			=> 'create',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '9', //Configuration
				'task_name'			=> 'edit',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
			[
				'module_id' 		=> '9', //Configuration
				'task_name'			=> 'delete',
				'created_by'		=> '1',
				'created_at'		=> date('Y-m-d H:i:s')
			],
		]);
	}
}
