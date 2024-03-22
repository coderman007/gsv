<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectCreate extends Component
{
    // Propiedades del componente
    public $openCreate = false;
    public $name;
    public $description;
    public $kilowatts_to_provide;
    public $status;
    public $showResource = '';
    public $totalLaborCost = 0;
    public $totalMaterialsCost = 0;
    // public $totalToolsCost = 0;
    // public $totalTransportCost = 0;

    // Reglas de validación
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'status' => 'required|string|in:Activo, Inactivo',
    ];

    // Método para guardar el proyecto
    public function saveProject()
    {
        $this->validate();

        // Verificar la existencia de los recursos seleccionados (modify as needed)
        $this->validateSelectedResources(); // Placeholder, modify for your logic

        // Crear un nuevo proyecto en la base de datos
        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
            'status' => $this->status,
            'total_labor_cost' => $this->totalLaborCost, // Asignar el valor total de la mano de obra
            'total_materials_cost' => $this->totalMaterialsCost, // Asignar el valor total de los materiales
            // 'total_tools_cost' => $this->totalToolsCost, // Asignar el valor total de las herramientas
            // 'total_transport_cost' => $this->totalTransportCost, // Asignar el valor total del transporte
        ]);

        // Redireccionar o mostrar mensaje de éxito
        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        $this->dispatch('newProjectNotification', [
            'title' => 'Success',
            'text' => 'Proyecto Creado Exitosamente!',
            'icon' => 'success'
        ]);
        $this->reset();
    }

    public function showLaborForm()
    {
        $this->showResource = 'labor'; // Update property based on clicked resource
    }

    public function showMaterialsForm()
    {
        $this->showResource = 'materials'; // Update property based on clicked resource
    }

    public function showToolsForm()
    {
        $this->showResource = 'tools'; // Update property based on clicked resource
    }

    public function showTransportForm()
    {
        $this->showResource = 'transport'; // Update property based on clicked resource
    }

    #[On('totalLaborCostUpdated')]  // Escuchar el evento
    public function updateTotalLaborCost($totalLaborCost)
    {
        // Actualizar el valor recibido en ProjectCreate
        $this->totalLaborCost = number_format($totalLaborCost, 2);
    }

    #[On('totalMaterialsCostUpdated')]  // Escuchar el evento
    public function updateTotalMaterialsCost($totalMaterialsCost)
    {
        // Actualizar el valor recibido en ProjectCreate
        $this->totalMaterialsCost = number_format($totalMaterialsCost, 2);
    }

    #[On('hideResourceForm')]  // Escuchar el evento
    public function hideResourceForm()
    {
        $this->showResource = '';
    }

    public function render()
    {
        return view('livewire.projects.project-create');
    }
}
