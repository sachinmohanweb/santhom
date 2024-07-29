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



1.St. Antony 131-37-44
=======================

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


2.St. Benedict-784-132-135
======================


UPDATE family_members
SET company_name = CASE 
    WHEN id = 654 THEN 'St.Marys Pattom'
    WHEN id = 658 THEN 'Weatherford'
    WHEN id = 662 THEN 'Christ Nagar'
    WHEN id = 673 THEN 'Mar Ivanios College'
    WHEN id = 674 THEN 'Mar Ivanios College'
    WHEN id = 675 THEN 'C-DAC  Trivandrum'
    WHEN id = 676 THEN 'Mar Ivanios College'
    WHEN id = 684 THEN 'Mar Ivanios College'
    WHEN id = 685 THEN 'Sarvodaya Vidyalaya'
    WHEN id = 686 THEN 'MSC'
    WHEN id = 687 THEN 'St.Gorettis H S ,Nalanchira'
    WHEN id = 708 THEN 'Dufrain UK Data Co.'
    WHEN id = 711 THEN 'Deloitte'
    WHEN id = 712 THEN 'C-DIT'
    WHEN id = 726 THEN 'KWA'
    WHEN id = 727 THEN 'St Marys HSS Pattom'
    WHEN id = 728 THEN 'St Johns M.C ,Banglore '
    WHEN id = 729 THEN 'St Johns M.C ,Banglore '
    WHEN id = 730 THEN 'Tracco Cabbo Thiruvalla'
    WHEN id = 731 THEN 'Director Metro Scans'
    WHEN id = 732 THEN 'Radiologist Metroscan'
    WHEN id = 733 THEN 'General Surgeon'
    WHEN id = 734 THEN 'Asia Infrastructure Advisory Service'
    WHEN id = 743 THEN 'SBI'
    WHEN id = 746 THEN 'Standard Charterd Bank'
    WHEN id = 747 THEN 'Indian Railways'
    WHEN id = 750 THEN 'CBSE'
    WHEN id = 767 THEN 'Kerala Legislative Secretariat'
    WHEN id = 768 THEN 'St Marys Pattom'
    WHEN id = 771 THEN 'Trivandrum City Corporation'
END
WHERE id IN (654, 658,662,673,674,675,676,684,685,686,687,708,711,712,726,727,728,729,730,731,732,733,734,743,746,747,750,767,768,771);



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
    pg.group_name='St. George'

ORDER BY 
    pg.group_name,f.family_name,fm.name;


3.St. George-1261-135-70
======================


UPDATE family_members
SET company_name = CASE 
    WHEN id = 1128 THEN 'UK'
    WHEN id = 1129 THEN 'UK'
    WHEN id = 1135 THEN 'Mar Ivanios College'
    WHEN id = 1136 THEN 'Mar Ivanios College'
    WHEN id = 1138 THEN 'BSNL'
    WHEN id = 1139 THEN 'Sree Chitra Institute of BMT'
    WHEN id = 1143 THEN 'National Bank of Abudhabi'
    WHEN id = 1144 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1145 THEN 'Mar Baselios'
    WHEN id = 1146 THEN 'Lourdes Mount'
    WHEN id = 1155 THEN 'BSNL'
    WHEN id = 1157 THEN 'Australia'
    WHEN id = 1159 THEN 'Chennai'
    WHEN id = 1160 THEN 'IAF'
    WHEN id = 1166 THEN 'Mar Ivanios College'
    WHEN id = 1167 THEN 'St. Johns HSS'
    WHEN id = 1170 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1171 THEN 'Nie Dax'
    WHEN id = 1174 THEN 'Gulf Model School, Dubai'
    WHEN id = 1175 THEN 'Conway, USA'
    WHEN id = 1178 THEN 'GG Hospital'
    WHEN id = 1179 THEN 'St. Marys HSS, Kottarakkara'
    WHEN id = 1186 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1187 THEN 'Sarvodaya'
    WHEN id = 1188 THEN 'Canada'
    WHEN id = 1189 THEN 'Canada'
    WHEN id = 1196 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1197 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1198 THEN 'Indian Army'
    WHEN id = 1199 THEN 'IGMC Nagpur'
    WHEN id = 1200 THEN 'NHM'
    WHEN id = 1212 THEN 'Private'
    WHEN id = 1213 THEN 'St.Marys TTC'
    WHEN id = 1214 THEN 'Mar Ivanios College'
    WHEN id = 1216 THEN 'NRI'
    WHEN id = 1220 THEN 'St. Marys HSS, Pattom'
    WHEN id = 1221 THEN 'Sarvodaya Vidyalaya'
    WHEN id = 1223 THEN 'U.K'
    WHEN id = 1224 THEN 'St.Marys HSS, Pattom'
    WHEN id = 1225 THEN 'Sarvodaya'
    WHEN id = 1229 THEN 'GHSS Palayamkunnu'
    WHEN id = 1230 THEN 'Mar Ivanios College'
    WHEN id = 1236 THEN 'ManuLife'
    WHEN id = 1237 THEN 'Inoan Infotech Canada'
    WHEN id = 1240 THEN 'KSHDC Ltd.'
    WHEN id = 1246 THEN 'Food Service'
    WHEN id = 1255 THEN 'Navajeevan Vidyalaya'
    WHEN id = 1257 THEN 'Infosys'
END
WHERE id IN (1128, 1129,1135,1136,1138,1139,1143,1144,1145,1146,1155,1157,1159,1160,1166,1167,1170,1171,1174,1175,
             1178,1179,1186,1187,1188,1189,1196,1197,1198,1199,1200,1212,1213,1214,1216,1220,1221,1223,1224,1225,1229,1230,
             1236,1237,1240,1246,1255,1257);


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
    pg.group_name='St. Jude'

ORDER BY 
    pg.group_name,f.family_name,fm.name;




4.St. Jude-2473-147-13
======================


UPDATE family_members
SET company_name = CASE 
    WHEN id = 2343 THEN 'University of Kerala'
    WHEN id = 2344 THEN 'HSA Govt. H.S'
    WHEN id = 2352 THEN 'MIC Co.Op.Society'
    WHEN id = 2253 THEN 'Sarvodaya Vidyalaya'
    WHEN id = 2254 THEN 'Engineering field'
    WHEN id = 2358 THEN 'Govt. School'
    WHEN id = 2360 THEN 'St. Johns College, Anchal'
    WHEN id = 2366 THEN 'Mar Ivanios College'
    WHEN id = 2367 THEN 'Mar Ivanios College'
    WHEN id = 2376 THEN 'NRI'
    WHEN id = 2379 THEN 'IT Field'
    WHEN id = 2380 THEN 'IT Field'
    WHEN id = 2384 THEN 'USA Medical College'
    WHEN id = 2386 THEN 'Australia'
    WHEN id = 2387 THEN 'Australia'
    WHEN id = 2393 THEN 'State Bank of India'
    WHEN id = 2394 THEN 'Government'
    WHEN id = 2395 THEN 'Mar Labs Ernakulam'
    WHEN id = 2396 THEN 'Government'
    WHEN id = 2399 THEN 'Infosys'
    WHEN id = 2400 THEN 'Aided college'
    WHEN id = 2401 THEN 'Aided college'
    WHEN id = 2402 THEN 'Memori Makers'
    WHEN id = 2406 THEN 'Education'
    WHEN id = 2407 THEN 'Education'
    WHEN id = 2408 THEN 'Education'
    WHEN id = 2409 THEN 'BPO'
    WHEN id = 2411 THEN 'Police'
    WHEN id = 2449 THEN 'Nava Kerala Mission'
    WHEN id = 2451 THEN 'Business Plus'
    WHEN id = 2452 THEN 'Sarvodaya Vidyalaya'
    WHEN id = 2453 THEN 'SCMS, Ernakulam'
    WHEN id = 2454 THEN 'Sarvodaya Central Vidyalaya'
    WHEN id = 2460 THEN 'Sarvodaya Vidyalaya'
    WHEN id = 2463 THEN 'Mar Ivanios College'
    WHEN id = 2464 THEN 'Mar Ivanios College'
    WHEN id = 2470 THEN 'Dubai Petroleum'
    WHEN id = 2471 THEN 'St. Johns Model HSS, Nalanchira'
END
WHERE id IN (2343, 2344,2352,2253,2254,2358,2360,2366,2367,2376,2379,2380,2384,2386,2387,2393,2394,2395,2396,
            2399,2400,2401,2402,2406,2407,2408,2409,2411,2449,2451,2452,2453,2454,2460,2463,2464,2470,2471);


===============================================================================
