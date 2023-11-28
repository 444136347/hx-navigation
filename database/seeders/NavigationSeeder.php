<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NavigationSeeder extends Seeder
{
    // 初始化填充数据
    public function run()
    {
        // 填充后台用户相关表
        $this->setAdminUsers();
        // 填充后台角色相关表
        $this->setAdminRoles();
        $this->setAdminRoleUsers();
        // 填充菜单表
        $this->setAdminMenu();
        // 填充权限表
        $this->setAdminPermissions();
        // 导航变量配置
        $this->setNavigationConfigs();
        // 统计所需填充
        $this->visitsPage();
    }

    public function setAdminMenu()
    {
        $now = Carbon::now();
        $dataColumn = ['id', 'parent_id', 'order', 'title', 'icon', 'uri', 'extension', 'show', 'created_at', 'updated_at'];
        $dataArray = [
            [1, 0, 1, '主页', 'feather icon-bar-chart-2', '/', '', 1, $now, $now],
            [2, 0, 13, '系统授权', 'feather icon-settings', NULL, '', 1, $now, $now],
            [3, 2, 14, '管理员', 'fa-users', 'auth/users', '', 1, $now, $now],
            [4, 2, 15, '角色', 'fa-address-card-o', 'auth/roles', '', 1, $now, $now],
            [5, 2, 16, '权限', 'fa-superpowers', 'auth/permissions', '', 1, $now, $now],
            [6, 2, 17, '菜单', 'fa-th-list', 'auth/menu', '', 1, $now, $now],
            [16, 0, 2, '内容管理', 'fa-list-alt', NULL, '', 1, $now, $now],
            [17, 16, 3, '文章管理', 'fa-book', 'content/article', '', 1, $now, $now],
            [20, 16, 4, '视频管理', 'fa-video-camera', 'content/video', '', 1, $now, $now],
            [21, 16, 5, '图集管理', 'fa-image', 'content/picture', '', 1, $now, $now],
            [29, 0, 6, '导航管理', 'fa-external-link-square', 'navigation', '', 1, $now, $now],
            [30, 29, 7, '网站列表', 'fa-link', 'navigation/site', '', 1, $now, $now],
            [31, 29, 8, '导航分类', 'fa-th-list', 'navigation/category', '', 1, $now, $now],
            [32, 29, 9, '导航标签', 'fa-tag', 'navigation/tag', '', 1, $now, $now],
            [37, 42, 20, '变量配置', 'fa-gear', 'navigation/config', '', 1, $now, $now],
            [38, 29, 10, '导航轮播', 'fa-volume-up', 'navigation/message', '', 1, $now, $now],
            [39, 29, 11, '用户投稿', 'fa-commenting', 'navigation/suggest', '', 1, $now, $now],
            [42, 0, 19, '系统管理', 'fa-tv', NULL, '', 1, $now, $now],
            [43, 29, 12, '导航搜索', 'fa-search', 'navigation/search', '', 1, $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('admin_menu')->delete();
        DB::table('admin_menu')->insert($res);
    }

    public function setAdminPermissions()
    {
        $now = Carbon::now();
        $dataColumn = ['id', 'name', 'slug', 'http_method', 'http_path', 'order', 'parent_id', 'created_at', 'updated_at'];
        $dataArray = [
            [1, '系统授权', 'auth-management', '', NULL, 13, 0, $now, $now],
            [2, '管理员', 'users', '', '/auth/users*', 14, 1, $now, $now],
            [3, '角色', 'roles', '', '/auth/roles*', 15, 1, $now, $now],
            [4, '权限', 'permissions', '', '/auth/permissions*', 16, 1, $now, $now],
            [5, '菜单', 'menu', '', '/auth/menu*', 17, 1, $now, $now],
            [14, '内容管理', 'content', '', NULL, 1, 0, $now, $now],
            [18, '文章管理', 'contentArticle', '', '/content/article*', 2, 14, $now, $now],
            [19, '视频管理', 'contentVideo', '', '/content/video*', 3, 14, $now, $now],
            [20, '图集管理', 'contentPicture', '', '/content/picture*', 4, 14, $now, $now],
            [27, '导航管理', 'navigation', '', NULL, 5, 0, $now, $now],
            [28, '网站列表', 'site', '', '/navigation/site*', 6, 27, $now, $now],
            [29, '导航分类', 'siteCategory', '', '/navigation/category*', 7, 27, $now, $now],
            [30, '导航标签', 'siteTag', '', '/navigation/tag*', 8, 27, $now, $now],
            [32, '变量配置', 'navigationConfig', '', '/navigation/config*', 12, 36, $now, $now],
            [33, '导航轮播', 'navigationMessage', '', '/navigation/message*', 9, 27, $now, $now],
            [34, '用户投稿', 'navigationSuggest', '', '/navigation/suggest*', 10, 27, $now, $now],
            [36, '系统管理', 'webManage', '', '', 19, 0, $now, $now],
            [38, '导航搜索', 'navigationSearch', '', '/navigation/search*', 11, 27, $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('admin_permissions')->delete();
        DB::table('admin_permissions')->insert($res);
    }

    public function setAdminRoleUsers()
    {
        $now = Carbon::now();
        $dataColumn = ['role_id', 'user_id', 'created_at', 'updated_at'];
        $dataArray = [
            [1, 1, $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('admin_role_users')->delete();
        DB::table('admin_role_users')->insert($res);
    }

    public function setAdminRoles()
    {
        $now = Carbon::now();
        $dataColumn = ['id', 'name', 'slug', 'created_at', 'updated_at'];
        $dataArray = [
            [1, 'Administrator', 'administrator', $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('admin_roles')->delete();
        DB::table('admin_roles')->insert($res);
    }

    public function setNavigationConfigs()
    {
        $now = Carbon::now();
        $dataColumn = ['id', 'type', 'name', 'key', 'string_value', 'description', 'text_value', 'user_id', 'status', 'created_at', 'updated_at'];
        $dataArray = [
            [1, 0, '阿里图标-去色cdn', 'icon_font_url', '//at.alicdn.com/t/c/font_4133690_8tfpu6pors6.css', '这里主要是分类的图标', NULL, 1, 1, $now, $now],
            [2, 0, '阿里图标-精美cdn', 'icon_font_color_url', '//at.alicdn.com/t/c/font_4165890_q3y5qvcuhb.css', '导航内的带颜色图标', NULL, 1, 1, $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('navigation_configs')->delete();
        DB::table('navigation_configs')->insert($res);
    }

    public function setAdminUsers()
    {
        $now = Carbon::now();
        $dataColumn = ['id', 'username', 'password', 'name', 'avatar', 'remember_token', 'created_at', 'updated_at'];
        $dataArray = [
            [1, 'admin', '$2y$10$HgTYaYjKxkNnxWtALc4ak.iUcq.k8Z8gKyNUJXPbvrLKrwHyL0weu', 'Administrator', NULL, 'Sb91uH88eKVzsns40pEuAD9vgZCshzauAY4l3ZflmdZnz1IaINEiZdEV0ngc', $now, $now],
        ];
        $res = $this->getInsertRes($dataArray, $dataColumn);
        DB::table('admin_users')->delete();
        DB::table('admin_users')->insert($res);
    }

    // 页面访问操作
    private function visitsPage()
    {
        if (!DB::table('visit_pages')->where('id', 1)->first()) {
            DB::table('visit_pages')->insert([
                'tag' => 'navigation_home',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            DB::table('visit_pages')->where('id', 1)->update([
                'tag' => 'navigation_home',
                'status' => 1,
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function getInsertRes($dataArray, $dataColumn)
    {
        $res = [];
        foreach ($dataArray as $key => $item) {
            foreach ($dataColumn as $k => $c) {
                $res[$key][$c] = $item[$k];
            }
        }
        return $res;
    }
}
