SELECT
    email
FROM
    users
GROUP BY
    email
Having
        COUNT(email) > 1