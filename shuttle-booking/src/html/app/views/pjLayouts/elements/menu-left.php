<?php
$controller_name = $controller->_get->toString('controller');
$action_name = $controller->_get->toString('action');

// Dashboard
$isScriptDashboard = in_array($controller_name, array('pjAdmin')) && in_array($action_name, array('pjActionIndex'));

// Bookings
$isScriptBookings = in_array($controller_name, array('pjAdminBookings'));

// Clients
$isScriptClientsController = in_array($controller_name, array('pjAdminClients'));
$isScriptClientsIndex = $isScriptClientsController && in_array($action_name, array('pjActionIndex', 'pjActionCreate', 'pjActionUpdate'));

// Locations
$isScriptLocationsController = in_array($controller_name, array('pjAdminLocations'));
$isScriptLocationsIndex = $isScriptLocationsController && in_array($action_name, array('pjActionIndex', 'pjActionCreate', 'pjActionUpdate'));

// Lines
$isScriptLinesController         = in_array($controller_name, array('pjAdminLines'));

// Timetable
$isScriptTimetableController         = in_array($controller_name, array('pjAdminTimetable'));

// Payments
$isScriptPaymentsController = in_array($controller_name, array('pjPayments'));

// Settings
$isScriptOptionsController = in_array($controller_name, array('pjAdminOptions')) && !in_array($action_name, array('pjActionPreview', 'pjActionInstall'));
$isScriptOptionsBooking         = $isScriptOptionsController && in_array($action_name, array('pjActionBooking'));
$isScriptOptionsBookingForm     = $isScriptOptionsController && in_array($action_name, array('pjActionBookingForm'));
$isScriptOptionsTerm            = $isScriptOptionsController && in_array($action_name, array('pjActionTerm'));
$isScriptOptionsNotifications   = $isScriptOptionsController && in_array($action_name, array('pjActionNotifications'));

// Permissions - Dashboard
$hasAccessScriptDashboard = pjAuth::factory('pjAdmin', 'pjActionIndex')->hasAccess();


// Permissions - Bookings
$hasAccessScriptBookings = pjAuth::factory('pjAdminBookings', 'pjActionIndex')->hasAccess();

// Permissions - Clients
$hasAccessScriptClients            = pjAuth::factory('pjAdminClients')->hasAccess();
$hasAccessScriptClientsIndex       = pjAuth::factory('pjAdminClients', 'pjActionIndex')->hasAccess();

// Permissions - Locations
$hasAccessScriptLocations            = pjAuth::factory('pjAdminLocations')->hasAccess();
$hasAccessScriptLocationsIndex       = pjAuth::factory('pjAdminLocations', 'pjActionIndex')->hasAccess();

// Permissions - Lines
$hasAccessScriptLines       = pjAuth::factory('pjAdminLines')->hasAccess();

// Permissions - Timetable
$hasAccessScriptTimetable       = pjAuth::factory('pjAdminTimetable')->hasAccess();

// Permissions - Payments
$hasAccessScriptPayments = pjAuth::factory('pjPayments', 'pjActionIndex')->hasAccess();

// Permissions - Settings
$hasAccessScriptOptions                 = pjAuth::factory('pjAdminOptions')->hasAccess();
$hasAccessScriptOptionsBooking          = pjAuth::factory('pjAdminOptions', 'pjActionBooking')->hasAccess();
$hasAccessScriptOptionsBookingForm      = pjAuth::factory('pjAdminOptions', 'pjActionBookingForm')->hasAccess();
$hasAccessScriptOptionsTerm             = pjAuth::factory('pjAdminOptions', 'pjActionTerm')->hasAccess();
$hasAccessScriptOptionsNotifications    = pjAuth::factory('pjAdminOptions', 'pjActionNotifications')->hasAccess();
?>

<?php if ($hasAccessScriptDashboard): ?>
    <li<?php echo $isScriptDashboard ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdmin&amp;action=pjActionIndex"><i class="fa fa-th-large"></i> <span class="nav-label"><?php __('plugin_base_menu_dashboard');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptBookings): ?>
    <li<?php echo $isScriptBookings ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionIndex"><i class="fa fa-list"></i> <span class="nav-label"><?php __('menuEnquiries');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptClients): ?>
    <li<?php echo $isScriptClientsIndex ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminClients&amp;action=pjActionIndex"><i class="fa fa-user"></i> <span class="nav-label"><?php __('menuClients');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptLocations): ?>
    <li<?php echo $isScriptLocationsIndex ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLocations&amp;action=pjActionIndex"><i class="fa fa-map-marker"></i> <span class="nav-label"><?php __('menuLocations');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptLines): ?>
    <li<?php echo $isScriptLinesController ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLines&amp;action=pjActionIndex"><i class="fa fa-exchange"></i> <span class="nav-label"><?php __('menuLines');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptTimetable): ?>
    <li<?php echo $isScriptTimetableController ? ' class="active"' : NULL; ?>>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionIndex"><i class="fa fa-plus-circle"></i> <span class="nav-label"><?php __('menuTimetable');?></span></a>
    </li>
<?php endif; ?>

<?php if ($hasAccessScriptOptions || $hasAccessScriptPayments): ?>
    <li<?php echo $isScriptOptionsController || $isScriptPaymentsController ? ' class="active"' : NULL; ?>>
        <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label"><?php __('menuOptions');?></span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <?php if ($hasAccessScriptOptionsBooking): ?>
                <li<?php echo $isScriptOptionsBooking ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionBooking"><?php __('menuReservations');?></a></li>
            <?php endif; ?>

            <?php if ($hasAccessScriptPayments): ?>
                <li<?php echo $isScriptPaymentsController ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjPayments&amp;action=pjActionIndex"><?php __('script_menu_payments');?></a></li>
            <?php endif; ?>

            <?php if ($hasAccessScriptOptionsBookingForm): ?>
                <li<?php echo $isScriptOptionsBookingForm ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionBookingForm"><?php __('menuReservationForm');?></a></li>
            <?php endif; ?>
            
            <?php if ($hasAccessScriptOptionsNotifications): ?>
                <li<?php echo $isScriptOptionsNotifications ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionNotifications"><?php __('menuNotifications');?></a></li>
            <?php endif; ?>
            
            <?php if ($hasAccessScriptOptionsTerm): ?>
                <li<?php echo $isScriptOptionsTerm ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionTerm"><?php __('menuTerms');?></a></li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>