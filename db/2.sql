select login
from users
where id not in (
    SELECT user_id
    FROM orders
    WHERE user_id IN (
        SELECT id
        FROM users)
    GROUP BY user_id
    Having COUNT(user_id) > 1)