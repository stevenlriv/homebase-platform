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

## WHEN LIVE
 - Move database to Managed Mysql digital ocean

## MVP LAUNCH
   **On all the functions, you need to check if the variable, user, city, listing exists, before making any update to them;
   UPDATE THE FUNCTIONS TO REFLECT THOSE CHANGES
   
 1) Submit Property:
    - all that relates to adding a property

 2) SEO:
    - canonical url for find-a-homebase.php searchs

 3) RENT.php
    - &date=[starting date]
    - &id=[property id]
    - users are required to create an account

 4) LISTING.php
    - Book Now (save booking details when user is trying to log-in, use cookies)
    - Book now is redirecting to contact us
    - Date picker not working on mobile

 5) User Account Ready
    - FOR-LANDLORDS.php - Get started should redirect them to create an account
    - FOR-REALTORS.php - Get started should redirect them to create an account

 6) ACCOUNT.php 
    - Allow user registration

## NOTES
    Find My Homebase
        - &type=[apartment, house]
        - &location=[city name or uri, phisical address, etc]
        - &date=[move in date]
        - &bedroom=[# of bethroom]
        - &bathroom=[# of bathrooms]
        - &maxprice=[Max house price]

    SOFTWARE
        - Send grid
        - Digital ocean Mysql 
        - Digital Ocean Spaces for uploads
        - Panda Docs

    OTHER
        - Logo color: #282828
        - Logo Font: Museo Sans

    Database
        1) User
            - status: {active, inactive, archived}
            - type: {super_admin, admin, landlords, realtors, tenants}
            - code: variable that is used to verify a email, restore password or a phone number
            - profile_image: 200x200
        2) Cities
        3) Settings
        4) Listings
            - status: {active, inactive, archived}
            - type: {house, apartment}
            - available: is the date when this unit becomes available again


