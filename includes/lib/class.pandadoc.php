<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all PandaDoc actions
	 * 
     * Production request are limited to 100 request per minute
     * 
     * Resources used
     *  @https://developers.pandadoc.com/reference#about
     *  @https://github.com/guzzle/guzzle
     *  @https://github.com/garethhallnz/pandadoc
	 */

    /**
     * Global Vars
     */
    $pd_api_url = 'https://api.pandadoc.com/public/v1/documents';
    $pd_api_key = get_setting(27);

    /**
     * We generare a document using an established PandaDoc template
     * 
     * @folder_id = The document section folder id (can be found in the browser url) where the doc is going to be saved
     * @template_id = The pregenerated template id that is going to be used to fill the lease
     * @array = The document data
     *      - name
     *      - landlord_tag
     *      - tenant_tag
     *      - country_tag
     *      - city_tag
     *      - landlord_first
     *      - landlord_last
     *      - landlord_email
     *      - tenant_first
     *      - tenant_last
     *      - tenant_email
     *      - homebase_agent_first
     *      - homebase_agent_last
     *      - homebase_agent_email
     *      - etc....
     * 
     * We also use tags with the landlord name and tenant name so it can be more easily searched
     * 
     * Returned variables by PandaDoc
     *  "id":"DOCUMENT ID",
     *  "name":"DOCUMENT NAME",
     *  "status":"document.uploaded",
     *  "date_created":"2020-10-29T11:23:27.170116Z",
     *  "date_modified":"2020-10-29T11:23:27.170116Z",
     *  "expiration_date":null,
     *  "version":null,
     *  "uuid":"4kfckadyBqeF2m3m5GKZj9"}
     */
    function create_document_from_template($array, $folder_id = '', $template_id = '') {
        global $pd_api_url, $pd_api_key;

        // Establish default PandaDoc variables if they are empty
        if($folder_id == '') { $folder_id = get_setting(29); }
        if($template_id == '') { $template_id = get_setting(28); }

        //Start the HTTP request
        $client = new \GuzzleHttp\Client();

        $headers = [
            'Authorization' => 'API-Key '.$pd_api_key,        
            'Accept'        => 'application/json',
        ];

        $data = [  
            "name" => $array['name'],
            "template_uuid" => $template_id,
            "folder_uuid" => $folder_id,
            "tags" => [
                $array['landlord_tag'],
                $array['tenant_tag'],
                $array['country_tag'],
                $array['city_tag']
            ],
            "recipients" => [  
                [ 
                    "email" => $array['landlord_email'],
                    "first_name" => $array['landlord_first'],
                    "last_name" => $array['landlord_last']
                ],
                [ 
                    "email" => $array['tenant_email'],
                    "first_name" => $array['tenant_first'],
                    "last_name" => $array['tenant_last']
                ],
                [ 
                    "email" => $array['homebase_agent_email'],
                    "first_name" => $array['homebase_agent_first'],
                    "last_name" => $array['homebase_agent_last']
                ]
            ],
            "tokens" => [  
                [ 
                    "name" => "Property.Rent",
                    "value" => $array['property_rent']
                ],
                [ 
                    "name" => "Property.StreetAddress",
                    "value" => $array['property_streetAddress']
                ],
                [ 
                    "name" => "Property.City",
                    "value" => $array['property_city']
                ],
                [ 
                    "name" => "Property.State",
                    "value" => $array['property_state']
                ],
                [ 
                    "name" => "Property.PostalCode",
                    "value" => $array['property_postalCode']
                ],
                [ 
                    "name" => "Property.Type",
                    "value" => $array['property_type']
                ],
                [ 
                    "name" => "Property.Bedrooms",
                    "value" => $array['property_bedrooms']
                ],
                [ 
                    "name" => "Property.Bathrooms",
                    "value" => $array['property_bathrooms']
                ],
                [ 
                    "name" => "Property.MoveInDate",
                    "value" => $array['property_moveindate']
                ],
                [ 
                    "name" => "Property.MoveOutDate",
                    "value" => $array['property_moveoutdate']
                ],
                [ 
                    "name" => "Property.LeaseLenghts",
                    "value" => $array['property_leaselenght']
                ],
                [ 
                    "name" => "Owner/Agent.FirstName",
                    "value" => $array['owner_agent_firstname']
                ],
                [ 
                    "name" => "Owner/Agent.LastName",
                    "value" => $array['owner_agent_lastname']
                ],
                [ 
                    "name" => "Owner/Agent.City",
                    "value" => $array['owner_agent_city']
                ],
                [ 
                    "name" => "Owner/Agent.State",
                    "value" => $array['owner_agent_state']
                ],
                [ 
                    "name" => "Owner/Agent.DLNumber",
                    "value" => $array['owner_agent_dl_number']
                ],
                [ 
                    "name" => "Owner/Agent.StreetAddress",
                    "value" => $array['owner_agent_streetaddress']
                ],
                [ 
                    "name" => "Owner/Agent.City",
                    "value" => $array['owner_agent_city']
                ],
                [ 
                    "name" => "Owner/Agent.State",
                    "value" => $array['owner_agent_state']
                ],
                [ 
                    "name" => "Owner/Agent.Country",
                    "value" => $array['owner_agent_country']
                ],
                [ 
                    "name" => "Owner/Agent.PostalCode",
                    "value" => $array['owner_agent_postalcode']
                ],
                [ 
                    "name" => "Owner/Agent.Phone",
                    "value" => $array['owner_agent_phone']
                ],

                [ 
                    "name" => "Leaseholder.FirstName",
                    "value" => $array['leaseholder_firstname']
                ],
                [ 
                    "name" => "Leaseholder.LastName",
                    "value" => $array['leaseholder_last_name']
                ],
                [ 
                    "name" => "Leaseholder.City",
                    "value" => $array['leaseholder_city']
                ],
                [ 
                    "name" => "Leaseholder.State",
                    "value" => $array['leaseholder_state']
                ],
                [ 
                    "name" => "Leaseholder.Country",
                    "value" => $array['leaseholder_country']
                ],
                [ 
                    "name" => "Leaseholder.PostalCode",
                    "value" => $array['leaseholder_postalcode']
                ],
                [ 
                    "name" => "Leaseholder.Phone",
                    "value" => $array['leaseholder_phone']
                ],
                [ 
                    "name" => "Leaseholder.AccountNumber",
                    "value" => $array['leaseholder_accountnumber']
                ],
                [ 
                    "name" => "Leaseholder.RoutingNumber",
                    "value" => $array['leaseholder_routingnumber']
                ],
            ],
        ];

        $response = $client->request(
            'POST',
            $pd_api_url,
            [
                'headers' => $headers,
                'json' => $data,
            ]
        );

        // We can return or print the body
        return $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

    }
?>