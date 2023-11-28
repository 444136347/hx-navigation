<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\Suggest as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Suggest extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $classifyText = [
        'sites' => '网站',
        'down'  => '资源'
    ];

    public static function createFormData($data, $ip = '')
    {
        if (!$data['tougao_title']) {
            return ['status' => 0, 'message' => '名称不能为空'];
        } else if (Model::where('title',$data['tougao_title'])->count()) {
            return ['status' => 0, 'message' => '名称已存在'];
        }
        if (!$data['tougao_type']) {
            return ['status' => 0, 'message' => '类型不能为空'];
        }
        if (!$data['tougao_sites_link']) {
            return ['status' => 0, 'message' => '网站或官网链接不能为空'];
        }
        // tougao_title-投稿名称
        // tougao_type-投稿类型
        // tougao_cat-投稿分类
        // tougao_keywords-投稿关键字
        // tougao_description-投稿介绍
        // tougao_down_version-资源版本
        // tougao_sites_link-网站或官网链接
        // tougao_sites_down-网盘链接
        // tougao_down_preview-演示链接
        // tougao_sites_password-网盘密码
        // tougao_down_decompression-解压密码
        $resData = [
            'title'         => $data['tougao_title'] ?? '',
            'description'   => $data['tougao_description'] ?? '',
            'keywords'      => $data['tougao_keywords'] ?? '',
            'classify'      => $data['tougao_type'],
            'link'          => $data['tougao_sites_link'] ?? '',
            'submit_ip'     => $ip,
            'data_json'     => null,
            'category_id'   => $data['tougao_cat'] ?? 0,
            'status'        => 1
        ];
        if ($data['tougao_type'] == 'down') {
            $resData['data_json'] = json_encode([
                'tougao_down_version' => $data['tougao_down_version'] ?? '',
                'tougao_sites_down' => $data['tougao_sites_down'] ?? '',
                'tougao_down_preview' => $data['tougao_down_preview'] ?? '',
                'tougao_sites_password' => $data['tougao_sites_password'] ?? '',
                'tougao_down_decompression' => $data['tougao_down_decompression'] ?? '',
            ]);
        }

        $res = Model::create($resData);
        if ($res) {
            return ['status' => 1, 'message' => '投稿成功'];
        }
        return ['status' => 0, 'message' => '投稿失败'];
    }
}
