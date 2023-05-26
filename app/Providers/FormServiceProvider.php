<?php

namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('textField', 'admin.form_components.textField', [
           'name', 'text', 'value' => null, 'attributes' => []
        ]);

        Form::component('numberField', 'admin.form_components.numberField', [
            'name', 'text', 'value' => null, 'attributes' => []
        ]);

        Form::component('passwordField', 'admin.form_components.passwordField', [
            'name', 'text'
        ]);

        Form::component('selectField', 'admin.form_components.selectField', [
            'name', 'text', 'values', 'selected' => null
        ]);

        Form::component('selectMultipleField', 'admin.form_components.selectMultipleField', [
            'name', 'text', 'values', 'selected' => []
        ]);

        Form::component('selectPackageProductField', 'admin.form_components.selectPackageProductField', [
            'name', 'text', 'values', 'selected' => []
        ]);

        Form::component('checkboxField', 'admin.form_components.checkboxField', [
           'name', 'text', 'value', 'selected' => false
        ]);

        Form::component('textareaField', 'admin.form_components.textareaField', [
            'name', 'text', 'value' => null, 'attributes' => []
        ]);
    }
}
