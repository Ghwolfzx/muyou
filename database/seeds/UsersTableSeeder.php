<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

    /*

INSERT INTO `user_has_departments` (`user_id`, `category_id`, `department_id`)
VALUES
    (2, 1, 4),
    (2, 2, 4),
    (3, 1, 4),
    (3, 2, 4),
    (4, 1, 2),
    (4, 2, 2),
    (5, 1, 3),
    (5, 2, 3),
    (6, 1, 5),
    (6, 2, 5),
    (7, 1, 1),
    (7, 2, 1),

    (8, 3, 4),
    (9, 3, 2),
    (10, 3, 3),
    (11, 3, 5),
    (12, 3, 1),
    (13, 3, 1),
    (14, 3, 8);

UPDATE `users` SET name = '杨庆', email='yangqing@52muyou.com' where id = 2;
UPDATE `users` SET name = '齐苑', email='qiyuan@52muyou.com' where id = 3;
UPDATE `users` SET name = '李莎莎', email='lishasha@52muyou.com' where id = 4;
UPDATE `users` SET name = '关世全', email='guansq@52muyou.com' where id = 5;
UPDATE `users` SET name = '李帅帅', email='lishuaishuai@52muyou.com' where id = 6;
UPDATE `users` SET name = '王志勇', email='wangzhiyun@52muyou.com' where id = 7;
UPDATE `users` SET name = '孙文平', email='sunwenping@52muyou.com' where id = 8;
UPDATE `users` SET name = '张天姿', email='zhangtianzi@52muyou.com' where id = 9;
UPDATE `users` SET name = '张皓霖', email='zhanghaolin@52muyou.com' where id = 10;
UPDATE `users` SET name = '许辰', email='xuchen@52muyou.com' where id = 11;
UPDATE `users` SET name = '刘家利', email='liujiali@52muyou.com' where id = 12;
UPDATE `users` SET name = '燕鹏宇', email='yanpengyu@52muyou.com' where id = 13;
UPDATE `users` SET name = '张瑜', email='zhangyu@52muyou.com' where id = 14;
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(14)
                        ->make()
                        ->each(function ($user, $index)
                            use ($faker, $avatars)
        {
            // 从头像数组中随机取出一个并赋值
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'lizhi';
        $user->email = 'lizhi@52muyou.com';
        $user->password = bcrypt('123456');
        $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        // $user = User::find(2);
        // $user->assignRole('Maintainer');

    }
}