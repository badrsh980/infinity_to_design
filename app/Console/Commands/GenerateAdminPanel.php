<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class GenerateAdminPanel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:panel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $ignored_columns = [
        'token',
        'passowrd',
        'remember_token',
        'id',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    protected $ignored_tables = [
        'migrations',
        'chat_messages',
        'chats',
        'failed_jobs',
        'model_has_permissions',
        'model_has_roles',
        'order_extras',
        'extras',
        'password_reset_tokens',
        'options',
        'permissions',
        'personal_access_tokens',
        'roles',
        'role_has_permissions',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $c = [];
        $tables = $this->getAllTables();

        foreach ($tables as $table) {
            if (in_array($table, $this->ignored_tables)) continue;
            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            $this->createIndexPage($table, $columns);
            $this->createCreatePage($table, $columns);
            $this->createEditPage($table, $columns);
            $this->createShowPage($table, $columns);
        }
    }

    protected function getAllTables()
    {
        return DB::connection()->getDoctrineSchemaManager()->listTableNames();
    }

    protected function createIndexPage($table, $columns)
    {
        $template = file_get_contents(app_path('/Console/Commands/templates/index.txt'));

        $model = substr($table, 0, strlen($table) - 1);
        $template = str_replace('{{model}}', $model, $template);

        $ths = "";
        $tds = "";

        foreach ($columns as $column) {
            if (in_array($column, $this->ignored_columns)) continue;
            $ths .= '<th scope="col" class="px-6 py-3">{{ $t("message.' . $column . '") }}</th>' . PHP_EOL;
            $tds .= '<td class="px-6 py-4" v-text="' . $model . '.' . $column . '"></td>' . PHP_EOL;
        }

        $template = str_replace('{{ths}}', $ths, $template);
        $template = str_replace('{{tds}}', $tds, $template);

        @mkdir(resource_path('/js/Pages/Admin/' . ucfirst($model)));

        $index = fopen(resource_path('/js/Pages/Admin/' . ucfirst($model) . '/index.vue'), "w+") or die("Unable to open file!");
        fwrite($index, $template);
        fclose($index);

        Artisan::call('make:controller Admin/' . ucfirst($model) . 'sController --resource');
    }

    protected function createCreatePage($table, $columns)
    {
        $template = file_get_contents(app_path('/Console/Commands/templates/create.txt'));

        $model = substr($table, 0, strlen($table) - 1);
        $template = str_replace('{{model}}', $model, $template);

        $inputs = '';
        $cols = '';


        foreach ($columns as $column) {
            if (in_array($column, $this->ignored_columns)) continue;
            $cols .= "$column: null,";

            $inputs .= "
                <div class='mb-4'>
                <InputLabel for='$column' :value='\$t('message.$column')' />
            ";

            $type = DB::getSchemaBuilder()->getColumnType($table, $column);

            switch ($type) {
                case 'integer':
                case 'bigint':
                case 'float':
                    $inputs .= "
                        <input
                            type='number'
                            step='0.01'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
                case 'string':
                    $inputs .= "
                        <input
                            type='text'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
                case 'text':
                    $inputs .= "
                        <textarea
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        ></textarea>
                    ";
                    break;

                default:
                    $inputs .= "
                        <input
                            type='text'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
            }

            $inputs .= "
                <InputError
                    class='mt-2'
                    :message='form.errors.$column'
                />
                </div>
            ";
        }

        $template = str_replace('{{inputs}}', $inputs, $template);
        $template = str_replace('{{columns}}', $cols, $template);

        @mkdir(resource_path('/js/Pages/Admin/' . ucfirst($model)));

        $create = fopen(resource_path('/js/Pages/Admin/' . ucfirst($model) . '/create.vue'), "w+") or die("Unable to open file!");
        fwrite($create, $template);
        fclose($create);
    }

    protected function createEditPage($table, $columns)
    {
        $template = file_get_contents(app_path('/Console/Commands/templates/edit.txt'));

        $model = substr($table, 0, strlen($table) - 1);
        $template = str_replace('{{model}}', $model, $template);

        $inputs = '';
        $cols = '';
        $update_cols = '';


        foreach ($columns as $column) {
            if (in_array($column, $this->ignored_columns)) continue;
            $cols .= "$column: null,";
            $update_cols .= "this.form.$column = this.$model.$column";

            $inputs .= "
                <div class='mb-4'>
                <InputLabel for='$column' :value='\$t('message.$column')' />
            ";

            $type = DB::getSchemaBuilder()->getColumnType($table, $column);

            switch ($type) {
                case 'integer':
                case 'bigint':
                case 'float':
                    $inputs .= "
                        <input
                            type='number'
                            step='0.01'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
                case 'string':
                    $inputs .= "
                        <input
                            type='text'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
                case 'text':
                    $inputs .= "
                        <textarea
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        ></textarea>
                    ";
                    break;

                default:
                    $inputs .= "
                        <input
                            type='text'
                            id='$column'
                            class='border-gray-500 rounded-sm shadow-sm w-full'
                            v-model='form.$column'
                        />
                    ";
                    break;
            }

            $inputs .= "
                <InputError
                    class='mt-2'
                    :message='form.errors.$column'
                />
                </div>
            ";
        }

        $template = str_replace('{{inputs}}', $inputs, $template);
        $template = str_replace('{{columns}}', $cols, $template);
        $template = str_replace('{{columns_update}}', $update_cols, $template);

        @mkdir(resource_path('/js/Pages/Admin/' . ucfirst($model)));

        $edit = fopen(resource_path('/js/Pages/Admin/' . ucfirst($model) . '/edit.vue'), "w+") or die("Unable to open file!");
        fwrite($edit, $template);
        fclose($edit);
    }

    protected function createShowPage($table, $columns)
    {
        $template = file_get_contents(app_path('/Console/Commands/templates/show.txt'));

        $model = substr($table, 0, strlen($table) - 1);
        $template = str_replace('{{model}}', $model, $template);

        $body = '';

        foreach ($columns as $column) {
            $body .= "<tr>" . PHP_EOL;
            $body .= "<th scope='col' class='px-6 py-3'>{{\$t('message.$column')}}</th>" . PHP_EOL;
            $body .= "<td class='px-6 py-4'>{{" . $model . "." . $column . "}}</td>" . PHP_EOL;
            $body .= "</tr>" . PHP_EOL;
        }

        $template = str_replace('{{body}}', $body, $template);

        @mkdir(resource_path('/js/Pages/Admin/' . ucfirst($model)));

        $show = fopen(resource_path('/js/Pages/Admin/' . ucfirst($model) . '/show.vue'), "w+") or die("Unable to open file!");
        fwrite($show, $template);
        fclose($show);
    }
}
