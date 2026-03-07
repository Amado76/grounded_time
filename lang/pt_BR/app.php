<?php

/**
 * General application strings for the Brazilian Portuguese locale.
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
        'dashboard'    => 'Painel',
        'restrictions' => 'Restrições',
        'children'     => 'Filhos',
        'history'      => 'Histórico',
        'settings'     => 'Configurações',
        'logout'       => 'Sair',
    ],

    // -------------------------------------------------------------------------
    // Common actions
    // -------------------------------------------------------------------------

    'actions' => [
        'save'    => 'Salvar',
        'cancel'  => 'Cancelar',
        'edit'    => 'Editar',
        'delete'  => 'Excluir',
        'confirm' => 'Confirmar',
        'back'    => 'Voltar',
    ],

];
