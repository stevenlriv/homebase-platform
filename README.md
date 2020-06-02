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

## UPGRADE

## MVP LAUNCH (# is number of weeks)

 1) [DONE] Add Picture Capabilities To Listings, Test Accounts and fix Bugs
    
 2-3) Improve "Submit Listing" Interface

   LISTERS
      ** Listers referral action system on index.php also include it in the contact.php

   --- fix city, country and zip code allowed on the submit listing
   --- don't show cities until a state and country for that cities is selected

   ====

   -- only allow listings from PR currently show message to user using JS on the location section

 4) Realtors and Landlords Accounts Creations
    - Submmit-property.php
      -- Checkin images
      -- Checkin text
    - Remove realtor and landlord autofill from contact form
    - Remove redirection to contact form on index.php for realtor and landlord
    - Calendly integration into the platform
      -- remove calendly link form verification from user.js

   ======== =======

    LIVE RELEASE
      ** Dump data from live to production database
      ** Upgrade to new database in the live version
      ** Edit the pending approval admin emails to Ernesto@ and bianca@

   --- create a way to easily upgrade from github once its on the server

    - Move to a Managed MYSQL Database on Digital Ocean
    - Move Website to a Scalable Managed Digital Ocean dropplet by Cloudways

    ================
    
    - Create a small dropplet for a blog subdomain in Cloudways


 5-6-7-8-9) PandaDocs API and Renting Infracstructure
    - PandaDocs API Integration with Platform
      - We will able to automated and standarize listing creation
      - We will able to accept Payments
      - https://www.pandadoc.com/api/esignature-api/
    - lease.php
      - Realtors/Landlord will be able to see actual lease contracts
      - Tenants will be able to see lease contracts
      - Links under /my-properties attached to lease end date need to be fixed
      - Support rent by room, with lease, etc
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
    - class.theme.php verify if the house is really rented or not to disable the date usings js on the landlord/realtor panel
    - #lease-link -- on class.listings.php
    -- Allow access to tenants and landlords to the user profile page only if they have a lease or pending lease with them
    -- add edit and disable account actions in the /profile page, only for admins
    --0 Once the user rents the house update the availability date in the listing database
    -- If a listing have other types of data in the database, like lease payments, etc, it CANT be deleted, so fix that
    -- They can spefify to use a different bank information for that lease, update the lease database with the pertinent bank information

    ======

    -- Need to create the databases that recors the transactions or extract that data using the pandaDocs API
    -- Tenants transactions will come from PandaDocs
    -- Landlords and landlords payments are on a database using thier bank information
    
 10) Tenant account Journey consolidated
    - Account creation enabled
    - Background and credit checks after account creation
    - Salary/Job verification (OPTIONAL)
    - Risk Score will be assigned to the tenant
    - Tenant Account Dashboard
      - require lease type
      - lease details
      - current and past homebase
    - remove tenant autofill from contact form
    - Remove redirection to contact form on index.php for tenants

 11) Master Admin Panel
    - Ability to edit settings
    - Ability to manage and create users
    - Ability to enable new cities y countries and states
    -- When editiing them remmeber to change the values on the cities tables due to easier search we only use the city table for query
    
 12) Admin
    - Ability to permanently disable a listing (status -> archive)
    - Ability to manually add a referral to an user
    - Ability to mark a payment made to an lister
    - Ability to mark a payment made to a Landlord or Realtor using their bank information

 12) Platform Upgrade
    - Create a Cron algoryth that features the 5-10% most viewed listings every week that are vacant

## NOTES
    CRON FILE
        - Set it to run every Sunday

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
               - Formula
                  -- background check
                  -- credit check
                  -- salary
               - ** Include tenant risk score it in the user profile page

      DATABASE

        1) User
            - id_user_referral
            - status: {active, inactive, archived}
            - type: {super_admin, admin, landlords, realtors, tenants, listers}
            - code: variable that is used to verify a email, restore password or a phone number
        2) Cities
        3) Settings
        4) Listings
            - status: {active, inactive, archived, pending}
            - type: {house, apartment}
            - available: is the date when this unit becomes available again
        5) Referral
            - id_user_referred = new user referred
            - id_user_referral = lister that referred the new user
            - id_listing = id listing refered
            - id_lease = id lease aggreement
            - amount_owed = amount owed to the user whom made the referral
            - amount_paid = amount already paid to the user whom made the referral
            - amount_next_payment = if there is a balance left we will indicate here the amount of the next payment
            - full_amount_date = by this date the full amount needs to be paid in full
        6) Referral Payments
            - id_user = the user that we made the payment to
        6) Lease
            - id_user_listing  = id owner of the listing and/or property
            - id_user_tenant = id user that rented the property
