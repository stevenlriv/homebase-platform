# Homebase PHP Site

## INSTALLATION
 1) Export database details to server mysql database
 2) Add database configuration to "includes/configuration.php"
 3) Upload files to php server
 4) Run composer install
 5) Most likely you will need to generate new keys for security purposes, look in "includes/configuration.php" for more information
 5) You're done!

## WHEN LIVE
 - Move database to Managed Mysql digital ocean
 - Start Using Digital Ocean Spaces
 - npm install
 - npm start

## MVP LAUNCH
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
            - code: variable that is used to verify a email, restore password or a phone number
        2) Cities
        3) Settings
        4) Listings
            - status: {active, inactive, archived}
            - type: {house, apartment}
            - available: is the date when this unit becomes available again


