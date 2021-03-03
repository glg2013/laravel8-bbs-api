<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        User::factory()->count(10)->create();

        // 单独处理第1个用户的数据
        $user = User::find(1);
        $user->name = 'fengniancong';
        $user->email = 'fengniancong@163.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('glg7850782');
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 单独处理第2个用户的数据
        $user = User::find(2);
        $user->name = 'honglang';
        $user->email = 'honglang@163.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->password = bcrypt('glg7850782');
        $user->save();

        // 将 2 号用户指派为『管理员』
        //$user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
