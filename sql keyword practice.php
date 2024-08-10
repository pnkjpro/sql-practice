<?php
//mulitple order by
"SELECT * FROM payments 
ORDER BY payment_value, payment_type DESC";

//limit
"SELECT * FROM payments
LIMIT 2,3" //excludes first two rows and reads next 3 rows

//aggregate function  like sum, round, max, min,avg,count, distinct
"SELECT
ROUND(SUM(payment_value),2) as total
FROM payments"

//use of distinct
"SELECT
DISTINCT customer_city
FROM customers"

"SELECT
COUNT(DISTINCT customer_city) as cities
FROM customers"

//ceil and floor
"SELECT 
payment_value,
ceil(payment_value),
floor(payment_value)
FROM `payments`"
//================= text functions ===================
//length of string
"SELECT 
seller_city, 
LENGTH(TRIM(seller_city)) as length_city
FROM `sellers`"

//upper and lower
"SELECT 
seller_city, 
UPPER(seller_city),
LOWER(seller_city)
FROM `sellers`"

//replace takes 3 parameters 
"SELECT 
seller_city, 
REPLACE(seller_city, "a", "i")
FROM `sellers`"

//concat 
"SELECT 
CONCAT(seller_city, "-", seller_state) as city_state
FROM `sellers`"

//================= date function ======================
"SELECT 
order_delivered_customer_date,
DAY(order_delivered_customer_date),
DAYNAME(order_delivered_customer_date),
MONTH(order_delivered_customer_date),
MONTHNAME(order_delivered_customer_date),
YEAR(order_delivered_customer_date)
FROM `orders`"

//datediff() takes two parameters
"SELECT 
order_delivered_customer_date,
DATEDIFF(order_delivered_customer_date,order_estimated_delivery_date) as diffdate
FROM `orders`"

//=========================MISC===================================
//is null
"SELECT 
payment_value
FROM `payments` where payment_type is null"

//====================== GROUP BY, HAVING and ORDER BY==================
"SELECT 
order_status, count(order_status) as order_freq
FROM `orders` 
GROUP BY order_status
ORDER BY order_freq DESC"

"SELECT 
payment_type,
ROUND(AVG(payment_value),2) as avg_payment
FROM `payments`
GROUP BY payment_type
ORDER BY avg_payment DESC"

//having used in aggregate function instead of where
"SELECT 
payment_type,
ROUND(AVG(payment_value),2) as avg_payment
FROM `payments`
GROUP BY payment_type
HAVING avg_payment >=100"

//Note: aggregate value pe WHERE ka istemaal nahi kar sakte, so there we will use having

//================================== all types of JOIN ================================
"SELECT customers.customer_id, orders.order_status
from customers JOIN orders ON
customers.customer_id = orders.customer_id"

"SELECT customers.customer_id, orders.order_status
from customers JOIN orders ON
customers.customer_id = orders.customer_id
WHERE order_status = 'canceled'"

"SELECT
YEAR(orders.order_purchase_timestamp) years,
ROUND(SUM(payments.payment_value),2) as total_pays
FROM orders JOIN payments ON
orders.order_id = payments.order_id
GROUP BY years
ORDER BY years"

//================================= jab mediater ke jariye 3rd table jodna ho to ===========
"SELECT 
products.product_category,
payments.payment_value
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id"

//===================================sub query ========================
"SELECT 
(products.product_category) category,
SUM(payments.payment_value) sales
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id
GROUP BY category ORDER BY sales DESC LIMIT 1"
//this whole query becomes table as t1 where we're fetching category only.

"SELECT category FROM
(SELECT 
(products.product_category) category,
SUM(payments.payment_value) sales
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id
GROUP BY category ORDER BY sales DESC LIMIT 1) as t1"

//we can also write t1 as
"WITH t1 as (SELECT 
(products.product_category) category,
SUM(payments.payment_value) sales
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id
GROUP BY category ORDER BY sales DESC LIMIT 1)"

// now we can use t1 independently
"SELECT category FROM t1"

//====================================== case operator =======================
"WITH t1 as (SELECT 
(products.product_category) category,
SUM(payments.payment_value) sales
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id
GROUP BY category ORDER BY sales DESC LIMIT 1)

SELECT *, CASE
WHEN sales <= 5000 THEN "low"
WHEN sales >=100000 THEN "high"
else "medium"
END as sales_type FROM t1"
 
//========================================= create virtual table ===================
"CREATE VIEW prod_cate_sales AS 
(SELECT 
(products.product_category) category, 
SUM(payments.payment_value) sales
FROM products JOIN order_items
ON products.product_id = order_items.product_id
JOIN payments
ON payments.order_id = order_items.order_id
GROUP BY category ORDER BY sales DESC LIMIT 1)"


//windows function reh gya hai... ye function kuch cumulative value nikalne ki aate hai.

