<?php

namespace App\Admin\Controllers;

use App\Model\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('Id'));
        $grid->column('currency', __('Currency'));
        $grid->column('amount', __('Amount'));
        $grid->column('state', __('State'));
        $grid->column('game_id', __('Game id'));
        $grid->column('user_id', __('User id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('product_name', __('Product name'));
        $grid->column('cp_order_id', __('Cp order id'));
        $grid->column('callback_url', __('Callback url'));
        $grid->column('callback_info', __('Callback info'));
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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('currency', __('Currency'));
        $show->field('amount', __('Amount'));
        $show->field('state', __('State'));
        $show->field('game_id', __('Game id'));
        $show->field('user_id', __('User id'));
        $show->field('product_id', __('Product id'));
        $show->field('product_name', __('Product name'));
        $show->field('cp_order_id', __('Cp order id'));
        $show->field('callback_url', __('Callback url'));
        $show->field('callback_info', __('Callback info'));
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
        $form = new Form(new Order);

        $form->text('currency', __('Currency'));
        $form->number('amount', __('Amount'));
        $form->number('state', __('State'));
        $form->number('game_id', __('Game id'));
        $form->number('user_id', __('User id'));
        $form->text('product_id', __('Product id'));
        $form->text('product_name', __('Product name'));
        $form->text('cp_order_id', __('Cp order id'));
        $form->text('callback_url', __('Callback url'));
        $form->text('callback_info', __('Callback info'));

        return $form;
    }
}
