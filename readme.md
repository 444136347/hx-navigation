## Logo

![Logo View](/public/vendor/web-stack/logo.png)

## 关于慧信导航

慧信导航网站通过对网址进行分类、标签等标识方式，为用户提供更加方便和高效的浏览体验。这种分类和标签的方式可以帮助用户快速找到自己感兴趣的网站。 

此外，慧信导航网站支持发布文章、图集和视频内容，丰富了网站的展示形式，吸引更多用户参与交流和分享。通过这些多样化的内容展现形式，网站不仅能提供网址导航功能，用户还可以发挥自己的想象力，使其成为一个充满活力和创新的分享社区。

值得一提的是，慧信导航网站采用dcat-admin作为后台系统构建工具，这使得项目具有高度的可扩展性和灵活性（dcat-admin是一个基于Laravel框架开发的后台管理系统构建工具，它提供了丰富的后台管理功能和组件，方便开发者进行二次开发和自定义）。这意味着慧信导航网站可以根据实际需求进行定制开发，满足不同用户和运营方的特定需求，增强网站的可用性和功能性。

## 内置功能

### 后台功能
1、主页
- 展示导航首页访问统计、导航网站访问排名信息。该功能模块通常是网站的首页，可以显示最近的热门导航网站，以及用户访问该导航网站的排名情况。

2、内容管理
- 文章管理：通过该功能模块，管理员可以编辑、发布、删除文章内容。在导航网站中，这些文章可以作为导航内容的附属品，提供更多的相关信息。
- 视频管理：通过该功能模块，管理员可以编辑、发布、删除视频内容。在导航网站中，这些视频可以作为导航内容的附属品，提供更多的相关信息。
- 图集管理：通过该功能模块，管理员可以编辑、发布、删除图集内容。在导航网站中，这些图集可以作为导航内容的附属品，提供更多的相关信息。

3、导航管理
- 网站列表：在该功能模块中，管理员可以添加、编辑和删除导航网站。管理员可以为每个网站添加描述和分类标签，以便用户查找和浏览。
- 导航分类：在该功能模块中，管理员可以添加、编辑和删除导航分类。每个导航网站会被分配到一个分类中，以便用户浏览和查找。
- 导航标签：该功能模块用于管理导航网站的标签。每个网站可以分配一个或多个标签，用户可以通过标签搜索相关网站。
- 导航轮播：轮播为文字载体，通常用于展示热门或特色网站，以吸引用户访问。在该功能模块中，管理员可以添加、编辑和删除轮播项。
- 用户投稿：用户投稿列表，用户可以推荐自己喜欢的网站。管理员可以审核并添加这些推荐到导航网站列表中。
- 导航搜索：该功能模块用于记录和管理用户端的搜索数据，以便管理员分析用户搜索习惯，并对导航网站进行优化改进。

4、系统授权
- 管理员：管理员管理功能允许系统中的超级管理员或特定权限的管理员创建、编辑和删除其他管理员账号。这样可以确保系统管理工作的分工和安全性，不同管理员可以拥有不同的权限和操作范围。
- 角色：角色管理功能用于定义系统中的角色和权限组合。管理员可以创建不同的角色，并分配相应的权限给这些角色。通过角色管理功能，管理员可以根据用户的职责和权限需求，将不同的角色分配给系统用户。这样可以简化权限管理，并确保不同用户能够按照其角色执行相应的操作。
- 权限：权限管理是指对系统中各个功能模块和操作进行权限设置和管理。通过权限管理功能，管理员可以根据用户角色和职责划分不同的权限，确保只有具备相应权限的用户才能访问和操作相关功能。比如，某些敏感数据的访问和修改只能由高级管理员或特定角色的用户执行。
- 菜单：菜单管理功能用于管理后台系统中的菜单组织和显示方式。管理员可以通过菜单管理功能定义系统的导航菜单，设置菜单的层级结构和显示顺序，以及配置各个菜单项的权限。这样，系统用户可以方便地浏览和访问不同模块和功能。

5、系统管理
- 变量配置：变量配置功能允许管理员动态配置系统变量，如站点名称、站点描述、主题颜色等，便于二次开发。

## 技术架构

### 后端
- Laravel 8+
- DcatAdmin 2.2.3

### 前端
- Bootstrap 4.3.1
- jQuery 3.2.1

## 环境部署
- PHP 7.4.30
- Mysql 5.7
- Nginx 1.12.2
- Redis latest(最新版)

### 本地环境
- Windows建议使用小皮面板。请移步[phpstudy](https://www.xp.cn/) 
- Mac环境提供自己本地开发的docker部署环境。请移步[docker-muzi](https://github.com/444136347/docker-muzi) ,使用docker-compose一键部署。

### 线上环境
- 线上运维环境请根据自己的需求部署，没有一定运维能力的建议使用宝塔（[宝塔服务器面板，一键全能部署及管理，送你10850元礼包，点我领取](https://www.bt.cn/?invite_code=M196bmt3cnM=) ）。

## 项目部署
项目建议您使用[七牛云云存储Kodo](https://s.qiniu.com/reiEbe) ，作为多媒体内容（图片，视频等）存储。
- 1、克隆代码：
```shell
（1）github：
$ git clone https://github.com/444136347/hx-navigation.git
（2）gitee：
$ git clone https://gitee.com/muzi-space/hx-navigation.git
```
- 2、env配置：
```shell
$ cp .env.example .env
进入env配置
（1）APP_URL：
默认情况下是localhost，但是请改成你的域名:端口，比如：www.xxx.com:8080
...
APP_URL=www.xxx.com:8080
...
（2）数据库信息：
...
DB_CONNECTION=mysql
DB_HOST=IP
DB_PORT=端口（一般是3306）
DB_DATABASE=库名
DB_USERNAME=账号
DB_PASSWORD=密码
...
（3）Redis信息：
...
REDIS_HOST=IP
REDIS_PASSWORD=密码（没有设置的话为null）
REDIS_PORT=端口（一般是6379）
...
（4）七牛云存储信息（如果使用七牛云的话）：
...
FILESYSTEM_DRIVER=qiniu

QINIU_ACCESS_KEY=七牛云存储access key
QINIU_SECRET_KEY=七牛云存储secret key
QINIU_BUCKET=七牛云存储bucket
QINIU_DOMAIN=七牛云存储domain
...
```
- 3、安装依赖：
```shell
$ composer install
```
- 4、生成KEY：
```shell
php artisan key:generate
```
- 5、数据迁移和填充：
```shell
php artisan migrate:refresh --seed
```

## 服务支持

作者在空余时间将会提供各种服务方式帮助您了解和使用该项目：

| 服务项       | 服务内容              | 服务收费   | 服务方式   |
|-----------|-----------------|--------|-------------|
| 基础问题    | 问题答疑  | 免费     | 技术交流群支持，请关注微信服务号：**慧信软件**，发消息：慧信导航，可获取群号和相关信息
| 产品使用      | 教学产品各功能使用   | 免费     | 文档自助。[慧信导航产品文档](https://www.yuque.com/u39104802/xbg3ty) |
| 二次开发      | 源码二次开发；| 免费     | 文档自助。[DcatAdmin文档](https://learnku.com/docs/dcat-admin/2.x)  |
| 其他服务 | 独家支撑；定制化开发； | 面议     | 交流群找群主 |

## 鸣谢

- [Dcat Admin](http://www.dcatadmin.com/)
- [liutongxu.github.io](https://github.com/liutongxu/liutongxu.github.io)

## License
MIT
