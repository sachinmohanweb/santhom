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
    WHEN id = 3 THEN 'EY'
    WHEN id = 7 THEN 'Federal Bank'
    WHEN id = 8 THEN 'Irrigation'
    WHEN id = 9 THEN 'IIT Chennai'
    WHEN id = 10 THEN 'LBS'
    WHEN id = 14 THEN 'Infosys'
    WHEN id = 15 THEN 'HLL Lifecare Ltd.'
    WHEN id = 24 THEN 'Own Business'
    WHEN id = 25 THEN 'Regional Inst. of Ophthalmology'
    WHEN id = 26 THEN 'Student'
    WHEN id = 27 THEN 'Student'
    WHEN id = 29 THEN 'BSNL'
    WHEN id = 30 THEN 'Mar Ivanios College'
    WHEN id = 31 THEN 'USA'
    WHEN id = 32 THEN 'USA'
    WHEN id = 35 THEN 'USA'
    WHEN id = 36 THEN 'Mar Ivanios College'
    WHEN id = 47 THEN 'Technopark'
    WHEN id = 48 THEN 'Sarvodaya'
    WHEN id = 49 THEN 'Sarvodaya'
    WHEN id = 51 THEN 'Etihad Airways'
    WHEN id = 71 THEN 'USA'
    WHEN id = 73 THEN 'USA'
    WHEN id = 78 THEN 'NRI'
    WHEN id = 79 THEN 'NRI'
    WHEN id = 87 THEN 'University of Kerala'
    WHEN id = 88 THEN 'St.Johns Model HSS'
    WHEN id = 89 THEN 'SRKMH'
    WHEN id = 90 THEN 'NIT, Calicut'
    WHEN id = 94 THEN 'Santhwana Hospital'
    WHEN id = 95 THEN 'Parsons International'
    WHEN id = 96 THEN 'City Centre Electronics'
    WHEN id = 97 THEN 'Birla Public School'
    WHEN id = 101 THEN 'IKEA'
    WHEN id = 123 THEN 'Medical College'
    WHEN id = 129 THEN 'Own Business'
    WHEN id = 131 THEN 'HDFC Bank'
END
WHERE id IN (3, 7,8,9,10,14,15,24,25,26,27,29,30,31,32,35,36,47,48,49,51,71,73,78,79,87,88,89,90,94,95,96,97,101,123,129,131);