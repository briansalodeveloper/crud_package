<?php

namespace Brian\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files=$files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileName=ucwords(strtolower($this->argument('name'))); 
        $serviceFileName = "${fileName}Service.php";

        $content =
'<?php

namespace App\Services;

class '.$fileName.'Service extends MainService
{
    public function __construct()
    {
        //
    }

    /**
     * fetch all records
     *
     * @return Array $rtn
     */
    public function all(): array
    {
        //
    }

    /**
     * get one  record.
     *
     * @param Int|Null $id
     * @return Array $rtn
     */
    public function get(int $id = null): array
    {
        //
    }

    /**
     * store a record 
     *
     * @return Bool|'.$fileName.' $rtn
     */
    public function store()
    {
        //
    }

    /**
     * update a record
     *
     * @param Int $id
     * @return Bool|'.$fileName.' $rtn
     */
    public function update(int $id)
    {
        //
    }

    /**
     * destroy a record 
     *
     * @param Int $id
     * @return Bool
     */
    public function destroy($id)
    {
        //
    }

}';

        if ($this->confirm('Do you wish to create '.$fileName.' Service file?')) {
            $path=app_path();
            // $repositoryFile = $path."/Services/$serviceFileName";
            // $interfaceFile = $path."/Interfaces/$interfaceFileName";
            // $RepositoryDir = $path."/Repositories";
            // $InterfaceDir = $path."/Interfaces";

            $serviceFile = $path."/Services/$serviceFileName";
            $serviceDir = $path."/Services";

            if ($this->files->isDirectory($serviceDir)) {
                if ($this->files->isFile($serviceFile)) {
                    return $this->error($fileName.' File Already exists!');
                }
                
                if (!$this->files->put($serviceFile, $content)) {
                    return $this->error('Something went wrong!');
                }
                $this->info("$fileName generated!");
            } else {
                $this->files->makeDirectory($serviceDir, 0777, true, true);

                if (!$this->files->put($serviceFile, $content)) {
                    return $this->error('Something went wrong!');
                }
                    
                $this->info("$fileName generated!");
            }

        }
    }
}
