<?php

return [
    // Formulations
    'Title' => 'Formulaciones',
    'Title_Formulations' => 'Lista de Formulaciones',
    'Create' => 'Crear Formulación',
    'Edit' => 'Editar Formulación',
    'Show' => 'Detalles de Formulación',
    'Breadcrumb_Formulations_1' => 'Formulaciones',
    'Breadcrumb_Active_Formulations_1' => 'Lista de Formulaciones',
    'Breadcrumb_Active_Create_Formulations_1' => 'Crear Formulación',
    'Title_Form_Owner' => 'Propietario',
    'Unit' => 'Unidad',
    'Delete_Ingredient' => 'Eliminar Ingrediente',
    'Tooltip_Owner' => 'El propietario de la formulación, asignado automáticamente al usuario actual.',
    'Tooltip_Element' => 'Seleccione el elemento principal para la formulación.',
    'Tooltip_Date' => 'Seleccione la fecha de creación de la formulación.',
    'Tooltip_Amount' => 'Ingrese la cantidad total de la formulación.',
    'Tooltip_Save' => 'Guardar la formulación en el sistema.',
    'Tooltip_Back' => 'Volver a la lista de formulaciones.',
    'Tooltip_Create' => 'Crear una nueva formulación.',
    'Tooltip_Export_CSV' => 'Exportar la lista de formulaciones como CSV.',
    'Tooltip_Export_PDF' => 'Exportar la lista de formulaciones como PDF.',
    'Filter_Element' => 'Filtrar por Elemento',
    'All_Statuses' => 'Todos los Estados',
    'Approved' => 'Aprobado',
    'Pending' => 'Pendiente',
    'Show_Details' => 'Mostrar Detalles',
    'Tooltip_Dark_Mode' => 'Alternar entre modo oscuro y claro.', // Added for dark mode toggle
    'Tooltip_Voice' => 'Ingresar cantidad usando voz.', // Added for voice input
    'Tooltip_Convert' => 'Convertir la unidad del ingrediente.', // Added for unit conversion
    'Search_Element' => 'Buscar Elemento', // Added for typeahead placeholder
    'Preview' => 'Vista Previa', // Added for preview panel
    'Voice_Not_Supported' => 'El reconocimiento de voz no es compatible con este navegador.', // Added for voice input error

    // Messages
    'Created' => 'Formulación creada exitosamente.',
    'Updated' => 'Formulación actualizada exitosamente.',
    'Approved' => 'Formulación aprobada exitosamente.',
    'Deleted' => 'Formulación eliminada exitosamente.',

    // Form Fields
    'Element' => 'Elemento',
    'Amount' => 'Cantidad',
    'Date' => 'Fecha',
    'Ingredients' => 'Ingredientes',
    'Add Ingredient' => 'Agregar Ingrediente',
    'Save' => 'Guardar',
    'Back' => 'Volver',
    'Update' => 'Actualizar',
    'None' => 'Ninguno',
    'units' => 'unidades',
    'Status' => 'Estado',
    'Actions' => 'Acciones',
    'View' => 'Ver',
    'Approve' => 'Aprobar',
    'Create New Formulation' => 'Crear Nueva Formulación',
    'No formulations found' => 'No se encontraron formulaciones',
    'Are you sure?' => '¿Estás seguro?',
    'Grams' => 'Gramos (g)',
    'Milligrams' => 'Miligramos (mg)',
    'Milliliters' => 'Mililitros (ml)',
    'Back to Formulations' => 'Volver a Formulaciones',
    'Convert' => 'Convertir', // Added for unit conversion button

    // Validation
    'validation' => [
        'ingredients_required' => 'Se requiere al menos un ingrediente.',
        'amount_negative' => 'La cantidad no puede ser negativa.',
    ],

    // Errors
    'errors' => [
        'unauthenticated' => 'Por favor, inicia sesión para acceder a esta página.',
        'unauthorized' => 'No tienes permiso para :action.',
        'create_failed' => 'No se pudo crear la formulación. Por favor, intenta de nuevo.',
        'update_failed' => 'No se pudo actualizar la formulación. Por favor, intenta de nuevo.',
        'approve_failed' => 'No se pudo aprobar la formulación. Por favor, intenta de nuevo.',
        'delete_failed' => 'No se pudo eliminar la formulación. Por favor, intenta de nuevo.',
    ],
];