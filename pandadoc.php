<?php

//////////////////////////////////////////////////////////////////
///// INTITIAL VARIABLES

define('SCRIP_LOAD', true);
define('THEME_LOAD', true);

// Include the required libraries
require_once __DIR__ . '/includes/configuration.php';
require_once __DIR__ . '/includes/lib.php';

//////////////////////////////////////////////////////////////////

$array = [
    'name' => 'Lol Test Doc',
    'landlord_tag' => 'Landlord name',
    'tenant_tag' => 'Tenant Name',
    'country_tag' => '',
    'city_tag' => '',
    'landlord_first' => '',
    'landlord_last' => '',
    'landlord_email' => '',
    'tenant_first' => '',
    'tenant_last' => '',
    'tenant_email' => '',
    'homebase_agent_first' => '',
    'homebase_agent_last' => '',
    'homebase_agent_email' => '',
    'property_rent' => '',
    'property_streetAddress' => '',
    'property_city' => '',
    'property_state' => '',
    'property_postalCode' => '',
    'property_type' => '',
    'property_bedrooms' => '',
    'property_bathrooms' => '',
    'property_moveindate' => '',
    'property_moveoutdate' => '',
    'property_leaselenght' => '',
    'owner_agent_firstname' => '',
    'owner_agent_lastname' => '',
    'owner_agent_city' => '',
    'owner_agent_state' => '',
    'owner_agent_dl_number' => '',
    'owner_agent_streetaddress' => '',
    'owner_agent_city' => '',
    'owner_agent_state' => '',
    'owner_agent_country' => '',
    'owner_agent_postalcode' => '',
    'owner_agent_phone' => '',
    'leaseholder_firstname' => '',
    'leaseholder_last_name' => '',
    'leaseholder_city' => '',
    'leaseholder_state' => '',
    'leaseholder_country' => '',
    'leaseholder_postalcode' => '',
    'leaseholder_phone' => '',
    'leaseholder_accountnumber' => '',
    'leaseholder_routingnumber' => '',
];

echo create_document_from_template($array);
?>