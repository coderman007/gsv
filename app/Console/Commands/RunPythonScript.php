<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunPythonScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run_python_script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a Python script';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Ruta del script de Python
        $pythonScript = base_path('python_scripts/generate_cashflow_chart.py');

        // Comando para ejecutar el script de Python
        $command = "python " . escapeshellarg($pythonScript);

        // Ejecuta el comando
        $output = exec($command);

        // Mostrar el resultado en la consola de Laravel
        $this->info($output);
    }
}
