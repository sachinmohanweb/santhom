SELECT 
    fm.id AS member_id,
    fm.name AS member_name,
    f.family_name AS family_name,
    pg.group_name AS prayer_group_name,
    fm.company_name
FROM 
    family_members fm
JOIN 
    families f ON fm.family_id = f.id
JOIN 
    prayer_groups pg ON f.prayer_group_id = pg.id
WHERE
    pg.group_name='St. Antony'

ORDER BY 
    pg.group_name,f.family_name,fm.name;





UPDATE family_members
SET company_name = CASE 
    WHEN member_id = 62 THEN 'abcd'
    WHEN member_id = 63 THEN 'ererere'
END
WHERE member_id IN (62, 63);