# Instructions
Considering the following scenario:
### Two tables
- **products** (id, name, description, price, created_at, updated_at)
- **orders** (id, product_id, user_id, quantity, order_date)

Create a query that returns:
* Orders that have sold more than 50 products.
* Average price of each product that has been sold more than 50 times.
* Products that have made the most revenue (price * quantity)

# Solution
```sql
SELECT 
    p.id AS product_id,
    p.name AS product_name,
    SUM(o.quantity) AS total_quantity,
    AVG(p.price) AS average_price,
    SUM(p.price * o.quantity) AS total_revenue
FROM 
    products p
JOIN 
    orders o ON p.id = o.product_id
GROUP BY 
    p.id
HAVING 
    total_quantity > 50
ORDER BY 
    total_revenue DESC;
```

Breakdown:
* `SUM(o.quantity)`: Calculates all orders by products.
* `AVG(p.price)`: Calculates the average price of each product.
* `SUM(p.price * o.quantity)`: Calculates total revenue by product.
* `HAVING total_quantity > 50`: Filters products that have only sold more than 50 times.

## Optimization indexes

* Index between _orders_ and _products_:

```sql
CREATE INDEX idx_orders_product_id ON orders (product_id);
```
This index optimizes any queries that require a JOIN between _products_ and _orders_ tables.


* Index `quantity` in _orders_:

```sql
CREATE INDEX idx_orders_quantity ON orders (quantity);
```
This index will speed up the calculation of orders quantity.

* Index `price` in _products_:

```slq
CREATE INDEX idx_products_price ON products (price);
```
This will improve the calculation of the products average price.

## Recommendations when working with huge data volumes
* **Proper indexing**: Indexing speeds up the retrieval of information by only searching for specific rows in a table instead of the entire table during a query.
* **Table partitioning**: If a table grows significantly over time, it can be partitioned in smaller data chunks, making query execution more efficient.
* **Paginated queries**: Queries can be paginated to avoid performance penalties in a table. Some database managers automatically paginate queries to 200 results, but it can always be overwritten.
* **Caching**: Cache systems can significantly improve performance by caching frequent queries.
* **Aggregate tables**: They can store preprocessed or aggregated data, which would be a nice optimization to do to the beforementioned query. This tables can be updated by adding a trigger so whenever a product is sold, the trigger updates the aggregated table.
