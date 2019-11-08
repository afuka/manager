<?php

namespace App\Admin\Controllers;

use App\Models\Material;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Arr;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MaterialsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '物料';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Material);

        // 查询过滤
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function($filter){
                $filter->between('id', 'ID');
                $filter->like('title', '名称');
                $filter->equal('type', '类型')->radio([
                    'coupon' => '优惠券', 'virtual' => '虚拟商品', 'material' => '实物奖品',
                ]);
            });
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at', '创建时间')->datetime();
                $filter->equal('status', '状态')->radio([
                    1 => '启用',
                    0 => '停用',
                ]);
            });
            
        });

        $grid->column('id', 'ID');
        $grid->column('title', '名称');
        $grid->column('sub_title', '子名称');
        $grid->column('type', '类型')->display(function($type) {
            $type_dic = [
                'coupon' => '优惠券', 'virtual' => '虚拟商品', 'material' => '实物奖品',
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
        $show = new Show(Material::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Material);

        // 去掉`删除`按钮
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->tab('基本信息', function($form) {
            $form->text('title', '物料名称')->required();
            $form->text('sub_title', '物料子名称')->required();
            $form->radio('type', '类型')->options([
                'coupon' => '优惠券', 'virtual' => '虚拟商品', 'material' => '实物奖品',
            ])->default('empty')->required();
            $form->number('limit_draw', '每人限领数')->default('0');
            $form->number('cost', '兑换价')->default('0');
            $form->number('num', '总数限制')->default('0');
            $form->text('bz', '描述');
            $form->radio('status', '状态')->options([
                '0' => '停用', '1' => '启用'
            ])->default('1');

            $form->fieldset('拓展信息', function (Form $form) {
                $form->embeds('ext_info', '拓展信息', function ($form) {
                    $form->width(6)->currency('prime_cost', '成本价')->symbol('￥');
                    $form->width(6)->currency('sale_cost', '销售价')->symbol('￥');
                    $form->width(6)->currency('market_cost', '市场价')->symbol('￥');
                });
            });

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
