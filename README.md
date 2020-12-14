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
 6) Twillio Enviroment
    - echo "export TWILIO_ACCOUNT_SID='ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'" > twilio.env
    - echo "export TWILIO_AUTH_TOKEN='your_auth_token'" >> twilio.env
    - source ./twilio.env
 7) You're done!

## UPGRADE
 1) Enable upgrade mode on the Super Admin panel or in the database directly
 2) Secure the current configuration.php and .hataccess file
 3) Create a backup of live database
 4) Dump data from live to production database
 5) Import new database date to Live MySQL server
 6) Perform an git clone with the new repo and delete the installer.php
 7) Get the old "configuration.php" and add it to includes/ remember the MYSQL details must match
 8) Continue on the Step 2 of installation without using the installer.php

## ROADMAP (# is number of weeks)

   PHASE 1 - Establish an user base of 1,000 user using the Saas model for listings
   
      2 membership levels
         - free and paid $25
         - real estate agents post their property with us and we cross-post it to multiple sites

## NOTES
    CRON FILE
        - Set it to run every Sunday

    OTHER
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



