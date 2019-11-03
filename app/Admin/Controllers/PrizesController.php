<?php

namespace App\Admin\Controllers;

use App\Models\Prize;
use Encore\Admin\Controllers\AdminController;
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
            return Arr::get($status_dic, $status, '');
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

        $show->field('id', __('Id'));
        $show->field('prizes_group_id', __('Prize group id'));
        $show->field('product_id', __('Product id'));
        $show->field('name', __('Name'));
        $show->field('bz', __('Bz'));
        $show->field('level', __('Level'));
        $show->field('prize_type', __('Prize type'));
        $show->field('num', __('Num'));
        $show->field('probability', __('Probability'));
        $show->field('user_limit_type', __('User limit type'));
        $show->field('date_config', __('Date config'));
        $show->field('ext_info', __('Ext info'));
        $show->field('rule_bz', __('Rule bz'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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

        $form->number('prizes_group_id', __('Prize group id'));
        $form->number('product_id', __('Product id'));
        $form->text('name', __('Name'));
        $form->text('bz', __('Bz'));
        $form->switch('level', __('Level'));
        $form->text('prize_type', __('Prize type'))->default('empty');
        $form->number('num', __('Num'));
        $form->number('probability', __('Probability'));
        $form->text('user_limit_type', __('User limit type'))->default('no');
        $form->text('date_config', __('Date config'));
        $form->text('ext_info', __('Ext info'));
        $form->textarea('rule_bz', __('Rule bz'));
        $form->text('status', __('Status'))->default('1');

        return $form;
    }
}
