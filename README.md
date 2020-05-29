# Homebase PHP Site

## INSTALLATION
 1) Git Clone To dir
 2) Install Composer (user terminal on cd to folder dir)
    - php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    - php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    - php composer-setup.php
    - php -r "unlink('composer-setup.php');"
 3) Install Dependencies (run)
    - php composer.phar install
 4) Installation (run)
    - On your browser go to your website and follow the steps
    - If installation file has not been deleted, on your terminal run
        - php -r "unlink('/includes/install.php');"
 5) Export database details to server mysql database
 6) You're done!

## MVP LAUNCH (# is number of weeks)

 1) [DONE] Add Picture Capabilities To Listings, Test Accounts and fix Bugs
    
 2-3) Improve "Submit Listing" Interface
    - certification box: "i certify that this property can be accesed with the details provided above. I understand that if i'm lieng my account can and will be penalized and I will not be able to list on Homebase anymore"
    - add 10% increase on listing pricing
    - show how much will be listed at on Homebase based on their price
    - limit listing title to 40 characters per website design in message add "do not make titles like 2 bed/1 bath, bed and bath are always indicated when we show the listing"
    - limit search keywords to 5 and 255 characters
    - Fix uri flexibility
    - Fix "Submit Listing" form cache system and why all of it is not working
    - Canonical url for find-a-homebase.php searchs
    - picture sorting and ordering jquery
    - Contact form: if user is logged in add their email & name and lock those inputs to view only
   ========
    - Create the part where you can add self-checkin data
    --- Postal Address
    --- Include images feauture for self-checkin
    - Rent by the room
    - JQUERY FORM VALIDATION STRUCTURE: "my-profile", "submit-listings"
    ========
    - Test accounts types to see how they work: tenants, realtors, landlords, admins, super admin
    - See how their platform page looks like
    - Create a Cron algoryth that features the 5-10% most viewed listings every week that are vacant
    - There is a listing search bug with the year date that need to be fixed for example listing of 2021 listing-search.php
    --- it can be esaly fixed by changing the date format on the database to time stampt and then converting that timestamp to a date you can show on the full script. there would be a lot of places where changes would need to be done, specially the footer.php
    ========
    - Restructure the Country, City and State type of
    - Improve the cities table with a country table that is connected to that city
    - Only show the cities available once the person choose the country
    --- Files that might need to be updated "submit-property-login.php", "find-a-homebase.php", "listing-search.php"

 4) Realtors and Landlords Accounts Creations
    - Allow for new realtor and landlords to conviniently create an account
      - FOR-LANDLORDS.php - Get started should redirect them to create an account
      - FOR-REALTORS.php - Get started should redirect them to create an account
    - Realtor bank information settings: Bank Name, Routing Number, Bank Account Number
    - Allow for realtors to filter the houses by Occupancy (Any) or "Occupied" and "Not Ocuppied"
    - Change Status Listing (Any); on realtor and landlord search

 5-6-7-8-9) PandaDocs API and Renting Infracstructure
    - PandaDocs API Integration with Platform
      - We will able to automated and standarize listing creation
      - We will able to accept Payments
      - https://www.pandadoc.com/api/esignature-api/
    - lease.php
      - Realtors/Landlord will be able to see actual lease contracts
      - Tenants will be able to see lease contracts
      - Links under /my-properties need to be fixed
      - Support rent by room, with lease, etc
    - Tenants will be able to create an account and rent from the website
    - LISTINGS.php
      - Book Now (save booking details when user is trying to log-in, use cookies)
      - **Book now is redirecting to contact us
    - RENT.php
      - &date=[starting date]
      - &id=[property id]
    - Monthly payment history for users and realtors & landlords
    - Ability to view the user profile with lease docs of their tenants
    - Calendly integration into the platform
    - class.theme.php verify if the house is really rented or not to disable the date usings js on the landlord/realtor panel
    
 10) Tenant account Journey consolidated
    - Account creation enabled
    - Background and credit checks after account creation
    - Salary/Job verification (OPTIONAL)
    - Risk Score will be assigned to the tenant
    - Tenant Account Dashboard
      - require lease type
      - lease details
      - current and past homebase

 11) Master Admin Panel
    - Ability to edit settings
    - Ability to manage and create users
    - Ability to enable new cities y countries

 12) Platform Upgrade
    - Move to a Managed MYSQL Database on Digital Ocean
    - Move Website to a Scalable Managed Digital Ocean dropplet by Cloudways

 13) User Feedback Iteration ** Repeat

## NOTES
    CRON FILE
        - Set it to run every Sunday

    Find My Homebase
        - &type=[apartment, house]
        - &location=[city name or uri, phisical address, etc]
        - &date=[move in date]
        - &bedroom=[# of bethroom]
        - &bathroom=[# of bathrooms]
        - &maxprice=[Max house price]

      Edit Property
        - &q=[uri]

    SOFTWARE
        - Send grid
        - Digital ocean Mysql 
        - Digital Ocean Spaces for uploads
        - Panda Docs

    OTHER
        - Logo color: #282828
        - Logo Font: Museo Sans
        - Files with hardcoded images links
            - lib
               - class.seo.php
               - class.email.php
            - views
               - submit-property-not-login.php
               - my-profile.php
               - listing.php
               - index.php
               - header.php
               - for-realtors.php
               - for-landlords.php
               - footer.php
               - find-a-homebase.php

    Database
        1) User
            - status: {active, inactive, archived}
            - type: {super_admin, admin, landlords, realtors, tenants}
            - code: variable that is used to verify a email, restore password or a phone number
        2) Cities
        3) Settings
        4) Listings
            - status: {active, inactive, archived}
            - type: {house, apartment}
            - available: is the date when this unit becomes available again


