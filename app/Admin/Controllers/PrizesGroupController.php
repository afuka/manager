<?php

namespace App\Admin\Controllers;

use App\Models\PrizesGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Arr;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PrizesGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '抽奖组';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PrizesGroup);
        // 查询过滤
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function($filter){
                $filter->between('id', 'ID');
                $filter->like('title', '标题');
            });
            $filter->column(1/2, function ($filter) {
                $filter->between('begin', '开始时间')->datetime();
                $filter->between('end', '结束时间')->datetime();
                $filter->equal('status', '状态')->radio([
                    1 => '启用',
                    0 => '停用',
                ]);
            });
            
        });
        // 设置列
        $grid->column('id', 'ID')->sortable();
        $grid->column('title', '标题')->expand(function ($model) {
            $prizes = $model->prizes()->take(100)->get()->map(function ($prize) {
                $arr = $prize->only(['id', 'name', 'level', 'bz', 'status']);
                $status_dic = ['0' => '停用', '1' => '启用'];
                $arr['status'] =  $status_dic[$arr['status']];
                return $arr;
            });
            return new Table(['ID', '奖品名称', '奖品等级', '奖品描述', '状态'], $prizes->toArray());
        });
        $grid->column('sub_title', '副标题');
        $grid->column('begin', '开始时间')->sortable();
        $grid->column('end', '结束时间')->sortable();
        $grid->column('type', '类型')->display(function($type) {
            $type_dic = [
                'lottery' => '随机抽奖',
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
        $show = new Show(PrizesGroup::findOrFail($id));

        $show->field('id', __('Id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PrizesGroup);

        // 去掉`删除`按钮
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->text('title', '标题')->required();
        $form->text('sub_title', '副标题');
        $form->datetime('begin', '开始时间')->default(date('Y-m-d H:i:s'))->required();
        $form->datetime('end', '结束时间')->default(date('Y-m-d H:i:s'))->required();
        $form->radio('limit_user', '用户限制')->options(['0' => '不限制', '1'=> '限制'])->default('0')->help('当限制用户的时候,则中奖的用户将会在下列用户中产生');
        $form->tags('seled_users', '限制用户名');
        $form->radio('type', '抽奖形式')->options(['lottery' => '随机抽奖'])->default('lottery');
        $form->radio('status', '状态')->options(['0' => '停用', '1'=> '启用'])->default('1');

        return $form;
    }

}
