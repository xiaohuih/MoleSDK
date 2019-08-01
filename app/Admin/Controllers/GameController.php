<?php

namespace App\Admin\Controllers;

use App\Model\Game;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GameController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Game';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Game);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('key', __('Key'));
        $grid->column('secret', __('Secret'));
        $grid->column('pub_key', __('Pub key'));
        $grid->column('pri_key', __('Pri key'));
        $grid->column('pay_callback', __('Pay callback'));
        $grid->column('pay_callback_debug', __('Pay callback debug'));
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
        $show = new Show(Game::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('key', __('Key'));
        $show->field('secret', __('Secret'));
        $show->field('pub_key', __('Pub key'));
        $show->field('pri_key', __('Pri key'));
        $show->field('pay_callback', __('Pay callback'));
        $show->field('pay_callback_debug', __('Pay callback debug'));
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
        $form = new Form(new Game);

        $form->text('name', __('Name'));
        $form->text('key', __('Key'));
        $form->text('secret', __('Secret'));
        $form->text('pub_key', __('Pub key'));
        $form->text('pri_key', __('Pri key'));
        $form->text('pay_callback', __('Pay callback'));
        $form->text('pay_callback_debug', __('Pay callback debug'));

        return $form;
    }
}
