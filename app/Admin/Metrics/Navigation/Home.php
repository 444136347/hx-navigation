<?php

namespace App\Admin\Metrics\Navigation;

use App\Models\Visits\Page;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Http\Request;

class Home extends Card
{

    // 保存自定义参数
    protected $data = [];

    // 构造方法参数必须设置默认值
    public function __construct(array $data = [])
    {
        $this->data = $data;

        parent::__construct();
    }

    protected function init()
    {
        parent::init();

        // 设置标题
        $this->title('导航首页统计');
        // 设置下拉菜单
        $this->dropdown([
            '1' => '今天',
            '7' => '最近7天',
            '30' => '最近一个月',
            '365' => '最近一年',
        ]);
    }

    public function handle(Request $request)
    {
        switch ($request->get('option')) {
            case '365':
                $this->content($this->getVisitCount(365));
                break;
            case '30':
                $this->content($this->getVisitCount(30));
                break;
            case '7':
                $this->content($this->getVisitCount(7));
                break;
            default:
                $this->content($this->getVisitCount(1));
        }
    }

    /**
     * 渲染卡片内容.
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-large-1">{$content}</h2>
</div>
HTML;
    }

    public function getVisitCount($day)
    {
        $home = Page::find(1);
        if (!$home) return 0;
        if ($day == 1) {
            return visits(Page::find(1))->period('day')->count();
        } else if ($day == 7) {
            return visits($home)->period('week')->count();
        } else if ($day == 30) {
            return visits($home)->period('month')->count();
        } else if ($day == 365) {
            return visits($home)->period('year')->count();
        }
        return 0;
    }
}
