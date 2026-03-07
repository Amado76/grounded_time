<?php

/**
 * General application strings for the English locale.
 *
 * Keys are used throughout Blade views via __('app.key').
 * Date/time format strings follow PHP date() conventions.
 */

return [

    // -------------------------------------------------------------------------
    // Date and time formats
    // Used with Carbon::translatedFormat(__('app.date_format'))
    // -------------------------------------------------------------------------

    'date_format'     => 'M j, Y',        // e.g. Mar 7, 2026
    'time_format'     => 'g:i A',          // e.g. 5:00 PM  (12-hour)
    'datetime_format' => 'M j, Y g:i A',   // e.g. Mar 7, 2026 5:00 PM

    // -------------------------------------------------------------------------
    // Navigation
    // -------------------------------------------------------------------------

    'nav' => [
        'dashboard'    => 'Dashboard',
        'restrictions' => 'Restrictions',
        'children'     => 'Children',
        'history'      => 'History',
        'settings'     => 'Settings',
        'logout'       => 'Log out',
    ],

    // -------------------------------------------------------------------------
    // Common actions
    // -------------------------------------------------------------------------

    'actions' => [
        'save'    => 'Save',
        'cancel'  => 'Cancel',
        'edit'    => 'Edit',
        'delete'  => 'Delete',
        'confirm' => 'Confirm',
        'back'    => 'Back',
    ],

];
