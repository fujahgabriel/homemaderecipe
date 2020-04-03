# homemaderecipe

API endpoints for shopping recipes and ingredients

**endpoint to create an ingredient - Post method = /ingredients**

- supply name, measure, supplier

**endpoint to list ingredients - GET method =  /ingredients**

- Paginated response

**endpoint to create a recipe - Post method = /recipes** 

- supply name, description and an array of ingredients and the amount of the ingredient required

**endpoint to list recipes - GET method =  /recipes** 

- Paginated response

**endpoint to create a box for a user - Post method = /orders**

- supply delivery_date

**endpoint to view the ingredients required to be ordered by the company - GET method =  /orders/{date}**
 - supply order_date

Laravel Framework 
