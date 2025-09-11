<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratorServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Service created successfully!';


    public function handle()
    {
        $input = $this->argument('name');
        $name = Str::studly(class_basename($input)); // اسم الترايت فقط

        $relativePath = str_replace('\\', '/', $input); // دعم للـ Windows-style paths
        $fullPath = app_path("Service/V1/{$relativePath}.php");

        // أنشئ الفولدرات المطلوبة
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (file_exists($fullPath)) {
            $this->error("Service {$name} already exists!");
            return 1;
        }

        // ✅ namespace الصحيح
        $sub = dirname(str_replace('/', '\\', $relativePath));
        $namespace = 'App\\Service\\V1' . ($sub !== '.' ? '\\' . $sub : '');

        file_put_contents($fullPath, $this->buildService($name, $namespace));
        $this->info("Service {$name} created successfully at Service/V1/{$relativePath}.php");
        return 0;
    }

    protected function buildService($name, $namespace)
{
    return <<<PHP
<?php

namespace {$namespace};

class {$name}
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // logic for listing resources
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\$request)
    {
        // logic for storing a new resource
    }

    /**
     * Display the specified resource.
     */
    public function show(\$id)
    {
        // logic for showing a single resource
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\$id,\$request)
    {
        // logic for updating a resource
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\$id)
    {
        // logic for deleting a resource
    }
}

PHP;
}

}
