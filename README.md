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
 1) Enable upgrade mode on the Super Admin panel or in the database directly
 2) Secure the current configuration.php and .hataccess file
 3) Create a backup of live database
 4) Dump data from live to production database
 5) Import new database date to Live MySQL server
 6) Perform an git clone with the new repo and delete the installer.php
 7) Get the old "configuration.php" and add it to includes/ remember the MYSQL details must match
 8) Continue on the Step 2 of installation without using the installer.php

## MVP LAUNCH (# is number of weeks)

 1) [DONE] Add Picture Capabilities To Listings, Test Accounts and fix Bugs [WEEk 1]
    
 2) [DONE] Improve "Submit Listing" Interface [WEEK 2-3]

 3) [DONE] Realtors and Landlords Accounts Creations [WEEK 4]

 4) Tenants Accounts Support & Risk Mitigation [WEEK 5-9]
      - Remove tenant autofill from contact form
      - Remove redirection to contact form on index.php for tenants
      - Account creation enabled
      - Rent now button add a dropdown date on the listing; we need a starting date and an ending date for the contract 

      - Tenant Risk Mitigation
         - Background check
         - Credit Check
         - Salary/Job verification (OPTIONAL)
         - Risk Score will be assigned to the tenant depending on the above results

      - "Calendly Like" Native Tour Scheduling for Tenants 
         - They need to create an account before doing a tour
         - They need to pass background check before getting accepted to do tours
         - Have a link that expires in 24 hours where they can see the checking information

 5) PandaDocs API and Renting Infracstructure [WEEK 10-16]
    - PandaDocs API Integration with Platform {https://www.pandadoc.com/api/esignature-api/}
      - We will able to automated and standarize listing creation
      - We will able to accept Payments
      - Need to create the databases that recors the transactions or extract that data using the pandaDocs API

    - lease.php
      - Realtors/Landlord will be able to see actual lease contracts
      - Tenants will be able to see lease contracts
      - Links under /my-properties attached to lease end date need to be fixed

    - LISTINGS.php
      - Book Now (save booking details when user is trying to log-in, use cookies)
      - Book now is redirecting to contact us with the desire rent date
      - On rent now, reddirect to login page if user is not logged in and use a ?back=listing-page

    - RENT.php
      - &date=[starting date]
      - &id=[property id]
      - class.theme.php verify if the house is really rented or not to disable the date usings js on the landlord/realtor panel; #lease-link on class.listings.php
      - Once the user rents the house update the availability date in the listing database
      - If a listing have other types of data in the database, like lease payments, etc, it CANT be deleted by any person!!, so fix that
      - when user is renting verify of it is a referral to give credit to listers

    - Landlords and Realtors
      - once an user rents landlords will receive an email if they decided to manually accept a tenant they have 12 hours to accept or reject the tenant, after that the tenant will be accepted by the system
      - Ability to view the user profile with lease docs of their tenants and the user risk score
      - Allow access to realtors and landlords to the user profile page only if they have a lease or pending lease with them
      - They can spefify to use a different bank information per lease lease, update the lease database with the pertinent bank information

    - Landlords, Realtors and Listers dashboards
      - Show all the payments made to them extracting the data from the database
      - Include also the bank transfer confirmation and the transfer date in the database tables

    - Tenant Account Dashboard
      - require lease type
      - lease details
      - current and past homebase
      - Tenants transactions will come from PandaDocs
      - They can see their landlord/realtor profile and contact information

    - Website Menu; enable the access to this new features
    - Allow landlords to order images

    - LISTERS
      -- Lister payments made
      -- Lister people referred (they'll get an email when they refer a new person)

 6) Admin & Roles Expansion [WEEk 17-18]
 
    - Master Admin Panel
      - Ability to edit settings
      - Ability to manage and create users
      - Ability to enter into upgrade mode
      - Ability to edit and disable account actions in the /profile user page
    
    - Master Admin & Admin
      - Ability to permanently disable a listing (status -> archive)
      - Ability to manually add a referral to an user

    - Master Admin & Admin & Accountant Role
      - Ability to mark a payment made to an lister
      - Ability to mark a payment made to a Landlord or Realtor using their bank information

   Platform Upgrade
      - Create a Cron algoryth that features the 5-10% most viewed listings every week that are vacant
      - Add a hot map to the website

## NOTES
   USER JOURNEY
      ==> LANDLORD 
         1) Create Account
         2) Create Profile
         3) Create Listing
         4) Lock box with key
         5) Receive tour notification
         6) Sign Lease
         7) Receive the rent deposit
         8) Move in details
         9) Property Filled

      ==> TENANT
         1) Seo Post
         2) Visit Listing on HB
         3) Create an account and book self-guided tour (with License privided as an ID)
         4) Tenant Screening
         5) Sign Lease
         6) Pay rent + deposit
         7) Move in details 
         8) Move in

    CRON FILE
        - Set it to run every Sunday

    OTHER
        - https://landbot.io/
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

         - Encrypted Cookies
               - USMP = user email and password hash
               - USRF = referral fullname and referral id

      DATABASE

        1) User
            - id_user_referral
            - status: {active, inactive, pending, archived}
            - --- pending = user is active but is pending email confirmation
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
