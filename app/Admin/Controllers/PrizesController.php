<?php

namespace App\Admin\Controllers;

use App\Models\Prize;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Arr;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PrizesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '奖品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Prize);

        // 查询过滤
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function($filter){
                $filter->between('id', 'ID');
                $filter->like('name', '奖品名称');
            });
            $filter->column(1/2, function ($filter) {
                $filter->equal('prizes_group_id', '奖品组')->select('/selector/prizes-groups');
                $filter->equal('status', '状态')->radio([
                    1 => '启用',
                    0 => '停用',
                ]);
            });
        });

        $grid->column('id', 'ID');
        $grid->column('prizes_group_id', '奖品组ID');
        $grid->column('group.title', '奖品组');
        $grid->column('product_id', '物料ID');
        $grid->column('product.title', '物料名称');
        $grid->column('name', '奖品名称');
        $grid->column('prize_type', '奖品类型')->display(function($type) {
            $type_dic = [
                'empty' => '空奖',
                'virtual' => '虚拟奖',
                'material' => '实物奖品',
            ];
            return Arr::get($type_dic, $type, '');
        });
        $grid->column('status', '状态')->display(function($status) {
            $status_dic = [
                '0' => '<span style="color:red;">停用</span>',
                '1' => '<span style="color:green;">启用</span>',
            ];
            return Arr::get($status_dic, $status, '');
        });
        $grid->column('created_at', '创建时间');

        // 去掉删除按钮
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            // $actions->disableEdit();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Prize::findOrFail($id));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Prize);

        $form->tab('基本信息', function($form) {
            $form->select('prizes_group_id', '奖品组')->options('/selector/prizes-groups');
            $form->select('product_id', '物料')->options('/selector/products');
            $form->text('name', '奖品名称');
            $form->number('level', '奖品等级')->default('1')->help('奖品等次，一等奖二等奖类，将会按照这个从小到大排序');
            $form->radio('prize_type', '奖品类型')->options([
                'empty' => '空奖', 'virtual' => '虚拟奖品', 'material' => '实物奖品'
            ])->default('empty')->required();
            $form->radio('is_default', '是否默认中奖')->options(['0' => '否', '1'=> '是'])->default('0')->help('默认中奖，当没抽中的时候，从奖品组默认中奖中随机发放给用户');
            $form->number('num', '奖品总数')->default('0');
            $form->number('probability', '中奖概率')->default('0')->help('每组奖品的限量奖品总概率为n*10000,即每种奖品的概率为0~10000，单个默认奖品不考虑概率，多个跟限量奖品一样');
            $form->text('bz', '奖品描述');
            $form->textarea('rule_bz', '规则描述');
            $form->radio('status', '状态')->options([
                '0' => '停用', '1' => '启用'
            ])->default('1');
        })->tab('抽奖配置', function($form){
            $form->radio('limit_user', '用户限制')->options(['0' => '不限制', '1'=> '限制'])->default('0')->help('当限制用户的时候,则中奖的用户将会在下列用户中产生');
            $form->tags('seled_users', '限制用户名');
            $form->radio('user_limit_type', '用户抽奖限制')->options([
                'no' => '无限制', 'per_day' => '每天至多一次', 'only' => '至多一次'
            ])->default('no');
            $form->table('date_config', '日期-发放量', function ($table) {
                $table->datetime('date', '时间');
                $table->number('num', '数量');
            })->default('[]')->help('时间格式如: 2019-11-11 或 2019-11-11 00:00:00');

        })->tab('图库', function($form){
            $form->embeds('imgs', '附加信息', function ($form) {
                // 列表小图
                $form->image('small', '列表方图')->help('方形的图,推荐大小 80px*80px');
                // 详情图
                $form->image('detail', '详情')->help('详情图, 推荐长图');
            });
        });

        return $form;
    }
}
