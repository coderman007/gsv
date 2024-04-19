<?php
/*
namespace App\Livewire\Projects;

use App\Models\Material;
use App\Models\Position;
use App\Models\Project;
use App\Models\Tool;
use App\Models\Transport;
use Livewire\Component;

class ProjectCreate extends Component
{
    // Propiedades del componente
    public $openCreate = false;
    public $name;
    public $description;
    public $kilowatts_to_provide;
    public $status;
    public $selectedPositions = [];
    public $selectedMaterials = [];
    public $selectedTools = [];
    public $selectedTransport;
    public $positionQuantities = [];
    public $materialQuantities = [];
    public $toolQuantities = [];
    public $toolRequiredDays = [];
    public $transportQuantity;
    public $transportRequiredDays;
    public $selectedPosition; // Nueva propiedad para controlar la selección de una nueva posición
    public $positionQuantity; // Nueva propiedad para la cantidad de la nueva posición
    public $positionRequiredDays; // Nueva propiedad para los días requeridos de la nueva posición

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'status' => 'required|string|in:Activo, Inactivo',
        'selectedPositions.*' => 'required|exists:positions,id',
        'positionQuantities.*' => 'required|numeric|min:0',
        'positionRequiredDays.*' => 'required|numeric|min:0',
        'selectedMaterials.*' => 'required|exists:materials,id',
        'materialQuantities.*' => 'required|numeric|min:0',
        'selectedTools.*' => 'required|exists:tools,id',
        'toolQuantities.*' => 'required|numeric|min:0',
        'toolRequiredDays.*' => 'required|numeric|min:0',
        'selectedTransport' => 'nullable|exists:transports,id',
        'transportQuantity' => 'nullable|numeric|min:0',
        'transportRequiredDays' => 'nullable|numeric|min:0',
    ];

    // Método para guardar el proyecto
    public function saveProject()
    {
        $this->validate();

        // Verificar la existencia de los recursos seleccionados
        $this->validateSelectedResources();

        // Crear un nuevo proyecto en la base de datos
        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
            'status' => $this->status,
        ]);

        // Asociar recursos seleccionados al proyecto con cantidades y días requeridos
        foreach ($this->selectedPositions as $index => $selectedPositionId) {
            $project->positions()->attach($selectedPositionId, [
                'quantity' => $this->positionQuantities[$index],
                'required_days' => $this->positionRequiredDays[$index],
                'total_cost' => 0, // Calcular el costo total correctamente
            ]);
        }

        foreach ($this->selectedMaterials as $index => $selectedMaterialId) {
            $project->materials()->attach($selectedMaterialId, [
                'quantity' => $this->materialQuantities[$index],
                'total_cost' => 0, // Calcular el costo total correctamente
            ]);
        }

        foreach ($this->selectedTools as $index => $selectedToolId) {
            $project->tools()->attach($selectedToolId, [
                'quantity' => $this->toolQuantities[$index],
                'required_days' => $this->toolRequiredDays[$index],
                'total_cost' => 0, // Calcular el costo total correctamente
            ]);
        }

        if ($this->selectedTransport) {
            $project->transports()->attach($this->selectedTransport, [
                'quantity' => $this->transportQuantity,
                'required_days' => $this->transportRequiredDays,
                'total_cost' => 0, // Calcular el costo total correctamente
            ]);
        }

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

    // Método para validar la existencia de recursos seleccionados
    private function validateSelectedResources()
    {
        $invalidResources = [];

        // Obtener todos los IDs de recursos seleccionados
        $selectedResourceIds = array_merge(
            $this->selectedPositions,
            $this->selectedMaterials,
            $this->selectedTools,
            ($this->selectedTransport) ? [$this->selectedTransport] : []
        );

        // Obtener todos los recursos seleccionados en una sola consulta
        $resources = [
            'positions' => Position::find($this->selectedPositions),
            'materials' => Material::find($this->selectedMaterials),
            'tools' => Tool::find($this->selectedTools),
            'transport' => ($this->selectedTransport) ? Transport::find($this->selectedTransport) : null,
        ];

        // Verificar la existencia de cada recurso
        foreach ($resources as $type => $resource) {
            foreach ($resource as $item) {
                if (!$item) {
                    $invalidResources[] = ucfirst($type) . " no encontrado.";
                }
            }
        }

        // Si se encontraron recursos inválidos, agregar mensajes de error
        if (!empty($invalidResources)) {
            $this->addError('selectedResources', $invalidResources);
        }
    }

    // Método para guardar una nueva posición y continuar con la creación del proyecto
    public function savePosition()
    {
        // Validar los campos de la posición
        $this->validate([
            'positionQuantity' => 'required|numeric|min:0',
            'positionRequiredDays' => 'required|numeric|min:0',
        ]);

        // Si se seleccionó una nueva posición
        if ($this->selectedPosition === 'new') {
            // Validar que la posición no esté vacía
            if (empty($this->positionQuantity) || empty($this->positionRequiredDays)) {
                $this->addError('selectedPosition', 'Por favor completa los campos para la nueva posición.');
                return;
            }

            // Crear la nueva posición
            $newPosition = Position::create([
                'name' => 'Nueva Posición', // Puedes ajustar esto según tus necesidades
            ]);

            // Asignar la nueva posición
            $this->selectedPositions[] = $newPosition->id;
            $this->positionQuantities[] = $this->positionQuantity;
            $this->positionRequiredDays[] = $this->positionRequiredDays;
        }

        // Limpiar campos de posición
        $this->selectedPosition = null;
        $this->positionQuantity = null;
        $this->positionRequiredDays = null;
    }

    public function render()
    {
        // Obtener recursos disponibles para la selección
        $positions = Position::all();
        $materials = Material::all();
        $tools = Tool::all();
        $transports = Transport::all();

        return view('livewire.projects.project-create', compact('positions', 'materials', 'tools', 'transports'));
    }
}*/
