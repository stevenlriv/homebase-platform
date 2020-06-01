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

   LISTERS
      ** People referred page and database
      ** Listers action system on index.php

    LIVE RELEASE
      ** Compare Live and Production databases
      ** Update database table and files on the live site

 4) Realtors and Landlords Accounts Creations
    - Allow for new realtor and landlords to conviniently create an account
      - FOR-LANDLORDS.php - Get started should redirect them to create an account
      - FOR-REALTORS.php - Get started should redirect them to create an account
    - Allow for realtors to filter the houses by Occupancy (Any) or "Occupied" and "Not Ocuppied"
    - Submmit-property.php
      -- Checkin images
      -- Checkin text
    - Remove realtor and landlord autofill from contact form
    - Remove redirection to contact form on index.php
    ====
    ---- show counts of pendings post on the user account 
    ---- send an email to all the admins when there is a listing to be approoved

     ---- Have listings on pending approval
      ------ admin allow for approval
      ------ allow draft view for admins on all listen hidden or pendin
      ------ allow draft view of hidden listing for users logged in for owners of that listing

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
      ** On rent now, reddirect to login page if user is not logged in and use a ?back=listing-page
      ** Create a redirrection system
    - RENT.php
      - &date=[starting date]
      - &id=[property id]
    - Monthly payment history for users and realtors & landlords
    - Ability to view the user profile with lease docs of their tenants
    - Calendly integration into the platform
      -- remove calendly link form verification from user.js
    - class.theme.php verify if the house is really rented or not to disable the date usings js on the landlord/realtor panel
    - #lease-link -- on class.listings.php
    
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
    - Ability to permanently disable a listing

 12) Platform Upgrade
    - Create a Cron algoryth that features the 5-10% most viewed listings every week that are vacant
    - Move to a Managed MYSQL Database on Digital Ocean
    - Move Website to a Scalable Managed Digital Ocean dropplet by Cloudways

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
        - Files with 10% business model
            - actions
               - submit-property.php
            - views
               - footer.php
               - submit-property-login.php
            - lib/
               - class.listings.php
               - class.theme.php

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
               - for-listers.php
               - footer.php
               - find-a-homebase.php
         - Tenant Risk Score from 1-10
               - 8-10 = Low Risk
               - 5-7  = Medium Risk
               - 1-4  = High Risk

    Database
         NEW STRUCTURE CHANGES
            xvls_users
               - id_referral
               - bank_name
               - bank_sole_owner
               - bank_routing_number
               - bank_account_number
            xvls_listings
               - available - 255 char; and update all of the datos to strtotime (one way to do it, is just to edit the listings)
               - monthly_house_original; price established by user or landlord
               - checkin_access_code
               - deposit_house_original
            
               
        1) User
            - id_referral: starts at 1000 and increments +1 per user
            - status: {active, inactive, archived}
            - type: {super_admin, admin, landlords, realtors, tenants, listers}
            - code: variable that is used to verify a email, restore password or a phone number
        2) Cities
        3) Settings
        4) Listings
            - status: {active, inactive, archived, pending}
            - type: {house, apartment}
            - available: is the date when this unit becomes available again


