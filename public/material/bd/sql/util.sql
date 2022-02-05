-- Qtd Prj por utilizador
SELECT 
	u.id, u.username, count(p.id) as qtd_prj
FROM projeto p
RIGHT JOIN utilizador u ON u.id = p.reg_utilizador_id
GROUP BY u.id, u.username
ORDER BY count(p.id) DESC;