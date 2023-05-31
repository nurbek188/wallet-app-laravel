SELECT sum(amount)
FROM transactions
WHERE reason = 'refund'
  AND created_at > CURRENT_DATE - 7;
