# Products viewer Fullstack App test project

A small project that let's the user create and filter a list of products in a seamless and comprehensive way. It implements products management through API calls, pagination and filtering.

# Contents
- [Products viewer Fullstack App test project](#products-viewer-fullstack-app-test-project)
- [Contents](#contents)
- [Technologies](#technologies)
- [Architecture](#architecture)
  - [Design patterns](#design-patterns)
  - [Project structure](#project-structure)
    - [Backend](#backend)
    - [Frontend](#frontend)
  - [Folder structure](#folder-structure)
  - [External libraries](#external-libraries)
- [Entities](#entities)
- [Instalation](#instalation)
    - [Prerequisites](#prerequisites)
    - [Steps](#steps)
    - [Access the Application](#access-the-application)
- [API endpoints](#api-endpoints)
  - [Products](#products)
    - [GET `/api/v1/products/{id?}`](#get-apiv1productsid)
    - [POST `/api/v1/products`](#post-apiv1products)
    - [PUT `/api/v1/products/{id}`](#put-apiv1productsid)
    - [PATCH `/api/v1/products/{id}`](#patch-apiv1productsid)
    - [DELETE `/api/v1/products/{id}`](#delete-apiv1productsid)
  - [Categories](#categories)
    - [GET `/api/v1/categories`](#get-apiv1categories)
- [Product filtering](#product-filtering)

# Technologies

* Backend: 
	* Main: PHP 8.2, Laravel 11.31 
	* Testing: PHP Unit 11
* Database: 
	* Main: MySQL 8
	* Testing: SQLite 3
* Frontend: 
	* Main: Vue 3.5
	* API client: Axios 1.7
	* State management: Vuex 4
	* Styles: Bootstrap 5.3 and Sass

# Architecture

Overall, the project, being done with Laravel, is a monolithic application that follows the MVC arquitecture and the following design patterns:
## Design patterns
1.  **Repository Pattern**:
    
    -   The service classes act as repositories, encapsulating the data access logic.
    -   Examples:  ProductService,  CategoryService.
2.  **Dependency Injection**:
    
    -   Controllers and services use dependency injection to receive their dependencies.
    -   Example:  ProductController  injects  ProductService.
3.  **API Resource Pattern**:
    
    -   Uses API resources to transform models into JSON responses.
    -   Example:  ProductResource.
4.  **Component-Based Architecture**:
    
    -   The frontend uses Vue.js components to build the UI.
    -   Example:  ProductCard.vue.
5.  **State Management Pattern**:
    
    -   Uses Vuex for managing the application state.
    -   Example:  productStore.js.

## Project structure
### Backend
1.  **Controllers**: Handle incoming HTTP requests and return responses.
    
    -   `ProductController.php`: Manages product-related operations.
    -   `CategoryController.php`: Manages category-related operations.

2.  **Services**: Contain business logic and interact with models. They are the communication bridge between the controllers and the models.
    
    -   `ProductService.php`: Handles product-related business logic.
    -   `CategoryService.php`: Handles category-related business logic.
3.  **Models**: Represent the data structure and interact with the database.
    
    -   `Product.php`: Defines the product schema and relationships.
    -   `Category.php`: Defines the category schema and relationships.

4.  **Resources**: Transform models into JSON responses.
    
    -   `ProductResource.php`: Transforms product data for API responses.
5. **Routes**: Define the routes of the project, and are separated between web routes and API routes.
	- `web.php`: Handles web routes.
	- `api.php`: Handles api routes.
6. **Migrations and seeders**: Migrations define the database schema and seeders populate the database with initial data.
	- `2025_01_11_222051_create_categories_table.php`: Creates the categories table.
	- `2025_01_11_223002_create_products_table.php`: Creates the products table.
	- `CategorySeeder.php`: Populates the category table with initial data.
	- `ProductSeeder.php`: Populates the product table with initial data.

### Frontend
1. **Views**: Uses a combination of blade templates that render the HTML and are directly linked to the web routing with laravel, and Vue to handle interactivity and componetization.
	- `app.blade.php`: Contains the application layout that all pages will follow.
	- `products.blade.php`: Contains the product page.
	- `ProductPage.vue`: Contains the structure of the product page, where all the interactivity with the products is done.
2. **Components**: Created with Vue, are a combination of HTML and JS to create interactive and reusable code that serve an specific purpose.
	- `CreateProduct.vue`: A form component used to create a new product.
	- `Filters.vue`: Handles all of the filters that can be applied to the product cards.
	- `ProductCard.vue`: Shows all the product information in an organized manner.
	- `Pagination.vue`: Handles the pagination and is independent of the product main component, which means that it is ready to be used with any other page component that requires pagination.
3. **Configuration**: These files contain the configuration rules that make Vue work seamlessly with Laravel.
	- `app.js`: Initializes the Vue app, its components and store.
	- `App.vue`: It's the main component of the application, where all the other components are going to be rendered.
4. **Helpers**: These files contain code that serve one purpose and can be used in any part of the application frontend.
	- `getCurrentPage.js`: Gets the current page from the URL param 'page'.
	- `handleUrlPagination.js`: Crutial for content navigation without reloading the page.
	- `normalizeFilters.js`: Normalizes search filters by removing all the empty values, so they don't get sent during an API call.
5. **State management**: Uses Vuex for state management which can be used in any component.
	- `productStore.js`: It's the only 'source of truth' of products. It's also the communication bridge between the client and the backend by managing all requests and responses with the API.
6. **Styles**: Uses bootstrap and Sass to easily handle styling.

 ## Folder structure
```
root/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php
│   │   │   ├── ProductController.php
│   │   │   └── ...
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   ├── Resources/
│   │   │   ├── CategoryResource.php
│   │   │   ├── ProductResource.php
│   │   │   └── ...
│   │   └── ...
│   ├── Models/
│   │   ├── Category.php
│   │   ├── Product.php
│   │   └── ...
│   ├── Providers/
│   ├── Services/
│   │   ├── CategoryService.php
│   │   ├── ProductService.php
│   │   └── ...
│   └── ...
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   │   ├── CategoryFactory.php
│   │   ├── ProductFactory.php
│   │   └── ...
│   ├── migrations/
│   │   ├── 2025_01_11_223002_create_products_table.php
│   │   ├── 2025_01_11_223003_create_categories_table.php
│   │   └── ...
│   ├── seeders/
│   │   ├── CategorySeeder.php
│   │   ├── ProductSeeder.php
│   │   └── ...
│   └── ...
├── public/
├── resources/
│   ├── css/
│   │   ├── app.css
│   │   └── ...
│   ├── js/
│   │   ├── app.js
│   │   ├── helpers/
│   │   │   ├── getCurrentPage.js
│   │   │   ├── handleUrlPagination.js
│   │   │   ├── normalizeFilters.js
│   │   ├── stores/
│   │   │   ├── productStore.js
│   │   │   └── ...
│   │   ├── vue/
│   │   │   ├── components/
│   │   │   │   ├── general/
│   │   │   │   │   ├── Pagination.vue
│   │   │   │   │   └── ...
│   │   │   │   ├── products/
│   │   │   │   │   ├── CreateProduct.vue
│   │   │   │   │   ├── Filters.vue
│   │   │   │   │   ├── ProductCard.vue
│   │   │   │   │   └── ...
│   │   │   ├── pages/
│   │   │   │   ├── ProductsPage.vue
│   │   │   │   └── ...
│   │   │   └── ...
│   │   └── ...
│   ├── views/
│   │   ├── products.blade.php
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── ...
│   │   └── ...
│   └── ...
├── routes/
│   ├── api.php
│   ├── web.php
│   └── ...
├── storage/
├── tests/
├── vendor/
└── ...

``` 

## External libraries
Here is a list of some external libraries with an explanation of why they were used:
* **Axios**: API client used in the frontend. Easy to use and implement.
* **Sass**: CSS preprocessor that makes writing styles simpler and gives more flexibility than plain CSS.
* **Bootstrap**: CSS library that comes with pre-made components and styles, saving a lot of time when putting together the app styles.
* **Element-plus**: Vue component library with lots of pre-made components that are easy to use. This was used to create notifications during API calls.
* **Vue**: Frontend framework that has pre-made Laravel integration. Used to componetize the frontend and to add dynamism.
* **Vuex**: One of Vue's state management systems, which integrates easily with the project. Used to handle all API calls from one place.

# Entities
The project has only two entities: **products** and **categories**.
**Categories** were separated into an entity because a single category can have many products.

All entities are going to have a `created_at` and `updated_at` attributes, which are just timestamps that Laravel creates when defining migrations.

**Products**:
```
    id: primary key
    name: varchar
    description: text
    price: decimal
    category_id: foreign key
    image: varchar
```
**Categories**:
```
    id: primary key
    name: varchar
    description: text
```
**Relationships**:
A one-to-many relationship between **category** and **product**:

![alt text](/public/readme-images/image.png)

# Instalation
### Prerequisites
- Apache
- PHP >= 8.2
- Composer
- MySQL
- SQLite3
- Node.js
- NPM
### Steps
1.  **Clone the Repository**:
    ```
    git  clone  https://github.com/your-username/your-repo.git
    cd  your-repo
    ```
    
2.  **Install PHP Dependencies**:
    ```
    composer  install
    ```    
3.  **Install JavaScript Dependencies**:
	```
	npm install
	```
4.  **Copy the Environment File**:
	```    
	cp  .env.example  .env
    ```
5.  **Generate Application Key**:
	```
	php  artisan  key:generate
	```
6.  **Configure Environment Variables**:
    -   Open the  `.env` file and configure your database and other environment variables.
    -   Example:
        ```
        DB_CONNECTION=mysql
        
        DB_HOST=127.0.0.1
        
        DB_PORT=3306
        
        DB_DATABASE=your_database
        
        DB_USERNAME=your_username
        
        DB_PASSWORD=your_password
        ```
7.  **Run Database Migrations**:
    ```
    php artisan migrate || php artisan migrate --seed
    ```
8.  **Seed the Database (Optional)**:
    ```
    php artisan db:seed
    ```
9. **Serve the application**: 
    To correctly serve the application, both laravel and vite must be running in parallel. To do this, the easiest way is to execute the following in one terminal:
    ```
    php artisan serve
    ```
    and the following in another terminal:
    ```
    npm run dev
    ```
    By doing so, both the laravel app will be running and Vite will be executing the Vue frontend.
### Access the Application

-   Open your web browser and navigate to  `http://localhost:8000`.

# API endpoints

All API endpoints are located in `api.php` file and managed through the app's controllers.

## Products

### GET `/api/v1/products/{id?}`
-   Description: Get all the products in the app. By default, they are paginated to a maximum of 10 products per page.
    -   If a product `id` is given, it will only show that product.
-   Response:
    ```json
    {
        "data": [
            {
                "id": "int",
                "name": "string",
                "description": "string",
                "price": "string",
                "image": "string",
                "category_id": "int"
            },
            { ... },
        ],
        "links": {
            "first": "string",
            "last": "string",
            "prev": "string",
            "next": "string"
        },
        "meta": {
            "current_page": "int",
            "from": "int",
            "last_page": "int",
            "links": [
                {
                    "url": "string",
                    "label": "string",
                    "active": "bool"
                },
            ],
            "path": "string",
            "per_page": "int",
            "to": "int",
            "total": "int"
        }
    }
    ```

### POST `/api/v1/products`
- Description: Creates a product and appends it in the database. By default, images are inserted automatically from an external service, so there's no need to send an `image` property.
- Request body:
    ```json
    {
        "name": "string",
        "description": "string",
        "price": "int",
        "category_id": "int"
    }
    ```
- Response
    ```json
    {
        "code": 201,
        "message": "Product created successfully",
        "data": {
            "name": "string",
            "description": "string",
            "price": "int",
            "image": "string",
            "category_id": 1,
            "updated_at": "string",
            "created_at": "string",
            "id": "int"
        }
    }
    ```

### PUT `/api/v1/products/{id}`
- Description: Replaces the product with `id`.
- Request body:
    ```json
    {
        "name": "string",
        "description": "string",
        "price": "int",
        "category_id": "int"
    }
    ```
- Response
    ```json
    {
        "code": 201,
        "message": "Product created successfully",
        "data": {
            "name": "string",
            "description": "string",
            "price": "int",
            "image": "string",
            "category_id": 1,
            "updated_at": "string",
            "created_at": "string",
            "id": "int"
        }
    }
    ```

### PATCH `/api/v1/products/{id}`
- Description: Overwrites the product's properties with `id` with the ones sent in the request body.
- Request body:
    ```json
    {
        "name": "string",
        "description": "string",
        "price": "int",
        "category_id": "int" 
    }
    ```
- Response
    ```json
    {
        "code": 200,
        "message": "Product updated successfully",
        "data": {
            "name": "string",
            "description": "string",
            "price": "int",
            "image": "string",
            "category_id": "int",
            "updated_at": "string",
            "created_at": "string",
            "id": "int"
        }
    }
    ```

### DELETE `/api/v1/products/{id}`
- Description: Deletes the product with `id`.
- Response:
    ```json
    {
        "code": 200,
        "message": "Product deleted successfully"
    }
    ```

## Categories
Categories only has the GET method, because the scope of the project is not working directly with the categories, they are used mainly for filtering purposes.

### GET `/api/v1/categories`
- Description: Get all the categories.
- Response
    ```json
    [
        {
            "id": "int",
            "name": "string",
            "description": "string",
            "created_at": "string",
            "updated_at": "string"
        },
        { ... }
    ]
    ```

# Product filtering
The application gives the possibility of filtering the products by _name_, _price_ range and _category_. This is done through **query params** sent to the API GET products route as follows:

* **Price**: `/api/v1/products?min-price=10&max-price=100`: Products will be filtered by price range, ranging from 10 to 100.
* **Name**: `/api/v1/products?name=shoe`: Products will be filtered by name, so only the products that contain the "show" name will be displayed. This filter is not case sensitive.
* **Category**: `/api/v1/products?category-id=3`: Products will be filtered by category, so all the products that belong to the category with id 5 will be displayed.

Also, because Laravel pagination system facilitates query params to load different pages, pagination is also done through query params:
* **Page**: `/api/v1/products?page=3`: If there's more than 30 products, the last 10 products will be displayed if filtering to page 3.

The advantage of working with query params is that all the filters can work simultaneosly and also, taking advantage of the API approach and Vue's reactive system, filtering can be done dynamically.
