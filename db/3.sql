SELECT login
FROM users
WHERE id IN (
    SELECT user_id
    FROM orders
    GROUP BY user_id
    Having COUNT(user_id) > 2)