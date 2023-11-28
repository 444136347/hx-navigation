<?php

namespace App\Admin\Metrics\Navigation;

use Dcat\Admin\Widgets\Metrics\Round;
use Illuminate\Http\Request;
use App\Models\Navigation\Site as SiteModel;

class Site extends Round
{
    protected $listArr = ['第一', '第二', '第三'];
    protected function init()
    {
        parent::init();

        $this->title('导航网站访问排名');
        $this->chartColors(['#ea5455','#dda451','#586cb1']);
        $this->chartLabels($this->listArr);
        $this->dropdown([
            '1' => '今天',
            '7' => '最近7天',
            '30' => '最近一个月',
            '365' => '最近一年',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        // 卡片内容
        $topArr = $this->getVisitTop($request->get('option'));
        $this->withContent($topArr);
        // 总数
        $total = $this->getVisitCount($request->get('option'));
        $this->chartTotal('总访问', $total);

        // 图表数据(占比)
        $this->withChart($this->getZb($topArr, $total));
        // 总数
        $this->chartTotal('总访问', $this->getVisitCount($request->get('option')));
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 卡片内容
     * @param array $topArr
     * @return $this
     */
    public function withContent($topArr)
    {
        $str = '';
        foreach ($topArr as $key => $top) {
            if ($key == 0) {
            $str .= '<div class="chart-info d-flex justify-content-between mb-1 mt-2">
                          <div class="series-info d-flex align-items-center">
                              <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                              <span class="text-bold-600 ml-50">'.$topArr[0]['title'].'</span>
                          </div>
                          <div class="product-result">
                              <span>访问量：'.$topArr[0]['count'].'</span>
                          </div>
                     </div>';
            } else if ($key == 1) {
                $str .= '<div class="chart-info d-flex justify-content-between mb-1 mt-2">
                          <div class="series-info d-flex align-items-center">
                              <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                              <span class="text-bold-600 ml-50">'.$topArr[1]['title'].'</span>
                          </div>
                          <div class="product-result">
                              <span>访问量：'.$topArr[1]['count'].'</span>
                          </div>
                     </div>';
            } else if ($key == 2) {
                $str .= '<div class="chart-info d-flex justify-content-between mb-1 mt-2">
                          <div class="series-info d-flex align-items-center">
                              <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                              <span class="text-bold-600 ml-50">'.$topArr[2]['title'].'</span>
                          </div>
                          <div class="product-result">
                              <span>访问量：'.$topArr[2]['count'].'</span>
                          </div>
                     </div>';
            }
        }
        if ($str) {
            return $this->content(
                <<<HTML
<div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
{$str}
</div>
HTML
            );
        }
        return $this->content(
        <<<HTML
<div class="col-12 d-flex flex-column flex-wrap" style="max-width: 220px">
❌ 暂无数据
</div>
HTML
    );
    }

    public function getVisitCount($day)
    {
        if ($day == 7) {
            return visits(SiteModel::class)->period('week')->count();
        } else if ($day == 30) {
            return visits(SiteModel::class)->period('month')->count();
        } else if ($day == 365) {
            return visits(SiteModel::class)->period('year')->count();
        } else {
            return visits(SiteModel::class)->period('day')->count();
        }
    }

    public function getVisitTop($day)
    {
        $topArr = [];
        if ($day == 7) {
            $period = 'week';
        } else if ($day == 30) {
            $period = 'month';
        } else if ($day == 365) {
            $period = 'year';
        } else {
            $period = 'day';
        }
        $topListObj = visits(SiteModel::class)->period($period)->top(3);

        foreach ($topListObj as $top) {
            $site = SiteModel::find($top->id);
            if ($site) {
                array_push($topArr, [
                    'title' => $site->toArray()['title'],
                    'count' => visits($site)->period($period)->count(),
                ]);
            }
        }
        return $topArr;
    }

    public function getZb($topArr, $total)
    {
        $resArr = [];
        foreach ($topArr as $top) {
            array_push($resArr,($top['count']/$total)*100);
        }
        return $resArr;
    }
}
