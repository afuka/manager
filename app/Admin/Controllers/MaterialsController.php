<?php

namespace App\Admin\Controllers;

use App\Models\Material;
use Encore\Admin\Controllers\AdminController;
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

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('sub_title', __('Sub title'));
        $grid->column('type', __('Type'));
        $grid->column('imgs', __('Imgs'));
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
        $show = new Show(Material::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('sub_title', __('Sub title'));
        $show->field('type', __('Type'));
        $show->field('imgs', __('Imgs'));
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
        $form = new Form(new Material);

        $form->text('title', __('Title'));
        $form->text('sub_title', __('Sub title'));
        $form->text('type', __('Type'))->default('virtual');
        $form->text('imgs', __('Imgs'));

        return $form;
    }
}
