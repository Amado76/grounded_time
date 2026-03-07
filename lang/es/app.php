<?php

/**
 * General application strings for the Spanish locale.
 *
 * Keys are used throughout Blade views via __('app.key').
 * Date/time format strings follow PHP date() conventions.
 */

return [

    // -------------------------------------------------------------------------
    // Date and time formats
    // Used with Carbon::translatedFormat(__('app.date_format'))
    // -------------------------------------------------------------------------

    'date_format'     => 'd/m/Y',      // e.g. 07/03/2026
    'time_format'     => 'H:i',         // e.g. 17:00  (24-hour)
    'datetime_format' => 'd/m/Y H:i',   // e.g. 07/03/2026 17:00

    // -------------------------------------------------------------------------
    // Navigation
    // -------------------------------------------------------------------------

    'nav' => [
        'dashboard'    => 'Panel',
        'restrictions' => 'Restricciones',
        'children'     => 'Hijos',
        'history'      => 'Historial',
        'settings'     => 'Configuración',
        'logout'       => 'Cerrar sesión',
    ],

    // -------------------------------------------------------------------------
    // Common actions
    // -------------------------------------------------------------------------

    'actions' => [
        'save'    => 'Guardar',
        'cancel'  => 'Cancelar',
        'edit'    => 'Editar',
        'delete'  => 'Eliminar',
        'confirm' => 'Confirmar',
        'back'    => 'Volver',
    ],

];
