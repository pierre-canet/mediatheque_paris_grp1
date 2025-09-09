mediatheque_paris_grp1/
│
├── config/
│   ├── database.php
│  
├── controllers/
│   ├──auth_controller.php
│   ├──catalog_controller.php
│   ├──rental_controller.php
|   └──home_controller.php
├── core/
│   ├──database.php
|   ├──router.php
|   └──view.php
├── database/
|   └──schema.sql
├── includes/
│   └──helpers.php
├── models/
|    ├──item_model.php
|    ├──rental_model.php
|    └──user_model.php
├── public/
|    ├──assets/
|    |   ├──css/
|    |   |  └──style.css
|    |   ├──images/    
|    |   └──js/
|    |      └──app.js                                                           
|    ├──.htaccess
|    └──index.php
├── views/
│   ├── auth/
|   |   ├──login.php    
|   |   └──register.php
│   ├── catalog/
|   |   ├──books.php   
|   |   ├──detail.php   
|   |   └──index.php
|   |  
|   ├──errors/
|   |   └──404.php
|   ├──home/  
|   |   ├──about.php
|   |   ├──contact.php
|   |   ├──index.php
|   |   ├──profile.php
|   |   └──test.php
|   ├──layouts/  
|   |  └──layouts.php
|   └──rental/
|      └──my_rentals.php
├── .gitignore
├──bootstrap.php
├──CHANGELOG.md
├──CODING_STANDARDS.md
├──CODING_STANDARDS.pdf
├──README.md
└── README.pdf