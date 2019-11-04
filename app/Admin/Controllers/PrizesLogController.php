<?php

namespace App\Admin\Controllers;

use App\Models\PrizesLog;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Arr;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PrizesLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '中奖日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PrizesLog);
        // 禁用新增
        $grid->disableCreateButton();
        // 查询过滤
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function($filter){
                $filter->between('id', 'ID');
                $filter->equal('user.username', '用户名');
                $filter->equal('user.mobile', '用户手机号');
                $filter->equal('prizes_group_id', '奖品组')->select('/selector/prizes-groups');
                $filter->equal('source', '来源')->radio([
                    'exchange' => '兑换/领取', 'lottery' => '抽奖',
                ]);
            });
            $filter->column(1/2, function ($filter) {
                $filter->equal('material_id', '物料')->select('/selector/materials');
                $filter->equal('material_code', '物料码');
                $filter->between('created_at', '中奖时间')->datetime();
                $filter->equal('status', '状态')->radio([
                    1 => '有效',
                    0 => '作废',
                ]);
            });
        });

        $grid->column('id', 'ID');
        $grid->column('prizes_group_id', '奖品组ID');
        $grid->column('group.title', '奖品组');        
        $grid->column('prize_id', '奖品ID');
        $grid->column('prize.name', '奖品');
        $grid->column('material_id', '物料ID');
        $grid->column('material.title', '物料名称');
        $grid->column('user_id', '用户ID');
        $grid->column('user.username', '用户名');
        $grid->column('status', '状态')->display(function($status) {
            $status_dic = [
                '0' => '<span style="color:red;">作废</span>',
                '1' => '<span style="color:green;">有效</span>',
            ];
            return Arr::get($status_dic, $status, '');
        });
        $grid->column('created_at', '中奖时间');

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
        $show = new Show(PrizesLog::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PrizesLog);

        // 去掉`删除`按钮
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->text('group.title', '奖品组')->readonly();
        $form->text('prize.name', '奖品名称')->readonly();
        $form->text('material.title', '物料名称')->readonly();
        $form->text('material_code', '物料代码')->readonly();
        $form->text('user.username', '用户名')->readonly();
        $form->text('user.mobile', '用户手机号')->readonly();
        $form->select('source', '来源')->options([
            '' => '', 'exchange' => '兑换/领取', 'lottery' => '抽奖'
        ])->readonly();
        $form->ip('ip', 'IP地址')->readonly();
        $form->datetime('created_at', '中奖时间')->readonly();
        $form->embeds('leaving_capital', '留资信息', function ($form) {
            $form->text('name', '收件人');
            $form->mobile('mobile', '手机号');
            $form->text('address', '收件地址');
        });
        $form->radio('status', '状态')->options([
            '0' => '作废', '1' => '有效'
        ])->default('1');
        return $form;
    }
}
