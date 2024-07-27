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



St. Antony ---- madathil house
=============


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


UPDATE family_members
SET company_name = CASE 
    WHEN id = 6131 THEN 'High Court of Kerala'
    WHEN id = 6132 THEN 'Mar Gregorios Law College'
    WHEN id = 6135 THEN 'LMIHMCT'
    WHEN id = 6136 THEN 'St.Margaret GHSS Kollam'
    WHEN id = 6150 THEN 'Skyways'
    WHEN id = 6151 THEN 'B. Arch'
    WHEN id = 6159 THEN 'TATA'
END
WHERE id IN (6131, 6132,6135,6136,6150,6151,6159);



===============================================================================

SELECT name, family_id, COUNT(*) AS count 
FROM family_members 
GROUP BY name, family_id HAVING COUNT(*) > 1 
ORDER BY name ASC, family_id ASC;


DELETE FROM `family_members`
WHERE `deleted_at` IS NOT NULL;

-----92

delete FROM family_members WHERE id IN 
    (6165,6971,6972,6973,6974,6975,6976,6977,6978,6979,6980,6981,6982,6983,6984,6985,6993,6994,6995,
        6996,6997,6999,7000,7001,7002,7009,7010,7011,7013,7014,7015,7016,7017,7018,7019,7020,7021,7022,
        7023,7025,7026,7027,7028,7029,7030,7031,7032,7033,7034,7035,7036,7044,7051,7053,7054,7055,7056,
        7057,7058,7059,7060,7062,7063,7064,7066,7067,7068,7069,7070,7081,7082,7083,7084,7085,7086,7087,
        7088,7089,7092,7093,7094,7095,7096,7097,7098,7099,7100,7102,7104,7107,7108,7109,7110,7111,7112,
        7113,7114,7115,7116,7117,7118,7119,7120,7121,7122,7127,7128,7129,7130,7131,7133,7134,7135,7136,
        7137,7138,7140,7150,7151,7152,7165,7167,7168,7169,7170,7171,7172,7173,7174,7175,7176,7177,7178,
        7183,7184,7185,7186,7187,7188,7189,7190,7191,7192)

delete FROM family_members WHERE id IN (7012,6998,7103,6285,7194,6965,7193);

-----150

===============================================================================


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
    pg.group_name='St. Benedict'

ORDER BY 
    pg.group_name,f.family_name,fm.name;


St. Antony
=============