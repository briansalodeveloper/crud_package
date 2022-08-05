<?php

namespace Brian\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

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
        $repositoryFileName = "${fileName}EloquentRepository.php";
        $interfaceFileName = "${fileName}RepositoryInterface.php";

        if ($fileName === '' || is_null($fileName) || empty($fileName)) {
            return $this->error('Composer Name Invalid..!');
        }

        $contentsRepository =
        '<?php

namespace App\Repositories;

use App\Interfaces\\'.$fileName.'RepositoryInterface;
                
class '.$fileName.'EloquentRepository implements '.$fileName.'RepositoryInterface
{
            
}';

        $contentsInterface =
'<?php

namespace App\Interfaces;

interface '.$fileName.'RepositoryInterface
{
    //
}';
        if ($this->confirm('Do you wish to create '.$fileName.' Repository and Interface file?')) {
            $path=app_path();
            $repositoryFile = $path."/Repositories/$repositoryFileName";
            $interfaceFile = $path."/Interfaces/$interfaceFileName";
            $RepositoryDir = $path."/Repositories";
            $InterfaceDir = $path."/Interfaces";

            if ($this->files->isDirectory($RepositoryDir) || $this->files->isDirectory($InterfaceDir)) {
                if ($this->files->isFile($repositoryFile) && $this->files->isFile($interfaceFile)) {
                    return $this->error($fileName.' File Already exists!');
                }
                
                if (!$this->files->put($repositoryFile, $contentsRepository) || !$this->files->put($interfaceFile, $contentsInterface)) {
                    return $this->error('Something went wrong!');
                }
                $this->info("$fileName generated!");
            } else {
                $this->files->makeDirectory($RepositoryDir, 0777, true, true);
                $this->files->makeDirectory($InterfaceDir, 0777, true, true);

                if (!$this->files->put($repositoryFile, $contentsRepository) || !$this->files->put($interfaceFile, $contentsInterface)) {
                    return $this->error('Something went wrong!');
                }
                    
                $this->info("$fileName generated!");
            }

        }
    
    }
}
