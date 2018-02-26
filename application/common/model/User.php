<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    protected $table = 'shop_users';  // 设置表名称
    protected $pk = 'uid';            // 设置主键
}
