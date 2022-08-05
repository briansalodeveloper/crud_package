<?php

namespace Brian\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

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
        $content =
'<?php

namespace App\Traits\Models;

trait BrianModel
{
    /**
     * empty table column values
     */
    public static function empty()
    {
        return new static();
    }

    /**
     * auto hash the password attribute
     */    
    public function setPasswordAttribute($password)
    {
        $this->attributes["password"] = Hash::make($password);
    }

}';

        $path=app_path();
        $traitFile = $path."/Traits/Models/BrianModel.php";
        $directory = $path."/Traits/Models";

        if ($this->files->isDirectory($directory)) {
            if ($this->files->isFile($traitFile)) {
                return $this->error(' File Already exists!');
            }
                
            if (!$this->files->put($traitFile, $content)) {
                return $this->error('Something went wrong!');
            }

            $this->info("new trait generated!");
        } else {
            $this->files->makeDirectory($directory, 0777, true, true);
            $this->files->makeDirectory($directory, 0777, true, true);

            if (!$this->files->put($traitFile, $content)) {
                return $this->error('Something went wrong!');
            }   
                    
            $this->info("new trait generated!");
        }

    
    }
}
