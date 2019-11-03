<?php

namespace App\Admin\Controllers;

use App\Models\PrizesLog;
use Encore\Admin\Controllers\AdminController;
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
    protected $title = 'App\Models\PrizesLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PrizesLog);

        $grid->column('id', __('Id'));
        $grid->column('prize_group_id', __('Prize group id'));
        $grid->column('prize_id', __('Prize id'));
        $grid->column('user_id', __('User id'));
        $grid->column('leaving_capital', __('Leaving capital'));
        $grid->column('ip', __('Ip'));
        $grid->column('status', __('Status'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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

        $show->field('id', __('Id'));
        $show->field('prize_group_id', __('Prize group id'));
        $show->field('prize_id', __('Prize id'));
        $show->field('user_id', __('User id'));
        $show->field('leaving_capital', __('Leaving capital'));
        $show->field('ip', __('Ip'));
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
        $form = new Form(new PrizesLog);

        $form->number('prize_group_id', __('Prize group id'));
        $form->number('prize_id', __('Prize id'));
        $form->number('user_id', __('User id'));
        $form->text('leaving_capital', __('Leaving capital'));
        $form->ip('ip', __('Ip'));
        $form->text('status', __('Status'))->default('1');

        return $form;
    }
}
