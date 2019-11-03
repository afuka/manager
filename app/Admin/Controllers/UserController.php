<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Arr;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        // 查询过滤
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(1/2, function($filter){
                $filter->between('id', 'ID');
                $filter->like('nickname', '昵称');
                $filter->equal('mobile', '手机号')->mobile();
            });
            $filter->column(1/2, function ($filter) {
                $filter->equal('username', '昵称');
                $filter->between('updated_at', '更新时间')->datetime();
                $filter->equal('status')->radio([
                    1 => '启用',
                    0 => '停用',
                ]);
            });
            
        });
        // 去掉删除按钮
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            // $actions->disableEdit();
        });
        // 列表显示
        $grid->column('id', 'ID')->sortable();
        $grid->column('username', '用户名')->sortable()->copyable();
        $grid->column('mobile', '手机号')->sortable()->copyable();
        $grid->column('email', 'Email')->sortable();
        $grid->column('nickname', '昵称')->sortable();
        $grid->column('status', '状态')->display(function($status) {
            $status_dic = [
                '0' => '<span style="color:red;">停用</span>',
                '1' => '<span style="color:green;">启用',
            ];
            return Arr::get($status_dic, $status, '');
        });
        $grid->column('created_at', '创建时间')->sortable();

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
        $show = new Show(User::findOrFail($id));
        $show->avatar()->image();
        $show->username('用户名');
        $show->mobile('手机号');
        $show->email('Email');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);
        // 去掉`删除`按钮
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->tab('基本信息', function ($form) {
            $form->row(function($row){
                $row->width(4)->image('avatar', '头像');
                $row->width(4)->text('nickname', '昵称');
                $row->width(4)->text('username', '用户名')->required();
                $row->width(4)->mobile('mobile', '手机号')->required();
                $row->width(4)->email('email', 'Email');
                // 拓展表
                $row->width(4)->text('info.name', '姓名');
                $row->width(4)->text('info.id_no', '身份证号');
                $row->width(4)->date('info.birthday', '生日')->format('YYYY-MM-DD');
                $row->width(4)->select('info.gender', '性别')->options([
                    'male' => '男',
                    'female' => '女',
                    'unknown' => '未知'
                ]);
                $row->width(4)->switch('status', '状态');
            });
        })->tab('拓展信息', function ($form) {
            // json 类型
            $form->embeds('info.ext_info', '附加信息', function ($form) {
                $form->textarea('memo', '描述');
            });

        });

        return $form;
    }
}
