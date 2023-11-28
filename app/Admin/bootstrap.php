<?php

use Dcat\Admin\Form\Field\File;
use Illuminate\Support\Facades\Storage;

// 扩展文件上传方法让浏览器直传七牛云
// 七牛云扩展github：https://github.com/zgldh/qiniu-laravel-storage
// 参考文章：https://www.yangdx.com/2022/10/224.html
File::macro('qiniu', function (string $path, bool $saveFullUrl = true) {
    $path = trim($path, '/');

    // 文件保存路径（使用魔法变量）
    $saveKey = $path.'/$(etag)$(ext)';

    $disk = Storage::disk('qiniu');

    $policy = [
        'saveKey' => $saveKey,
        // 返回 Dcat 上传文件需要的报文格式
        'returnBody' => json_encode([
            'status' => true,
            'data' => [
                'id'        => $saveFullUrl ? $disk->url(['path' => $saveKey, 'domainType' => 'https']) : $saveKey,
                'fname'     => '$(fname)',
                'fsize'     => '$(fsize)',
                'uuid'      => '$(uuid)',
                'etag'      => '$(etag)',
                'mimeType'  => '$(mimeType)',
            ],
        ]),
    ];

    // 七牛云上传 token
    $token = $disk->getAdapter()->uploadToken(null, 3600, $policy);

    $this->options([
        'fileVal' => 'file', // Dcat 默认为 _file_
        'server' => 'https://up.qiniup.com', //上传地址
        'formData' => [
            'token' => $token, //添加 token
        ],
    ]);

    return $this;
});
