-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 11, 2016 at 06:49 PM
-- Server version: 5.5.42
-- PHP Version: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hd_stores`
--

-- --------------------------------------------------------

--
-- Table structure for table `store_info`
--

CREATE TABLE `store_info` (
  `store_id` int(11) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `province` char(2) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `x_coordinate` float DEFAULT NULL,
  `y_coordinate` float DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4403 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_info`
--

INSERT INTO `store_info` (`store_id`, `banner`, `store_name`, `address`, `city`, `province`, `postal_code`, `tel`, `x_coordinate`, `y_coordinate`) VALUES
(405, 'YIG', 'Browns YIG', '1251 Main Street', 'Stittsville', 'ON', 'K2S 2E5', '6138319268', 45.2581, -75.9206),
(408, 'YIG', 'Baxtrom''s YIG', '31 Ninth Street East', 'Cornwall', 'ON', 'K6H6R3', '6139388040', 45.0305, -74.7344),
(421, 'YIG', 'Barnabe''s YIG', '80 Dufferin Street', 'Perth', 'ON', 'K7H 3A7', '6132676763', 44.9079, -76.2652),
(434, 'YIG', 'Neil''s YIG', '5200 Highway 69 N', 'Hanmer', 'ON', 'P3P 1Z3', '7059694474', 46.6528, -80.9851),
(444, 'YIG', 'Allan''s YIG', '1900 Dixie Road', 'Pickering', 'ON', 'L1V 1V4', '9058315632', 43.8422, -79.1052),
(450, 'YIG', 'Wilson''s YIG', '2681 Alta Vista Drive', 'Ottawa', 'ON', 'K1V 7T5', '6137332311', 45.3731, -75.6634),
(458, 'YIG', 'Battistelli''s  YIG', '65 Regional Road   #24', 'Lively', 'ON', 'P3Y 1C3', '7056923514', 46.4212, -81.1418),
(459, 'YIG', 'Winkel''s YIG', '745 Centre Street', 'Espanola', 'ON', 'P5E 1S8', '7058690284', 46.2506, -81.7636),
(467, 'YIG', 'Dessureault YIG', '1619 Orleans Avenue', 'Gloucester', 'ON', 'K1C 7E2', '6138306880', 45.4608, -75.5243),
(473, 'YIG', 'Dewe''s YIG', '400 Dundas Street E', 'Belleville', 'ON', 'K8N 1E8', '6139683888', 44.1669, -77.358),
(476, 'YIG', 'Grants YIG', '832 Tenth Street', 'Hanover', 'ON', 'N4N 1S3', '5193644661', 44.1556, -81.0071),
(486, 'YIG', 'Chartrand''s YIG', '55 Scott Street', 'New Liskeard', 'ON', 'P0J 1P0', '7056478844', 47.51, -79.684),
(490, 'YIG', 'Hartmans YIG', '296 Bank St.', 'OTTAWA', 'ON', 'K2P 1X8', '6132348692', 45.4153, -75.6963),
(497, 'YIG', 'Pettenuzzo''s YIG', '15 McChesney Avenue', 'Kirkland Lake', 'ON', 'P2N 3R9', '7055674939', 48.146, -80.0423),
(500, 'Zehrs ', 'Zehrs Clairfiled', '1750 Gordon St.', 'Guelph', 'ON', 'N1L 0G6', '519-836-0760', 43.502, -80.1905),
(505, 'Zehrs ', 'Zehrs Bradford (OPEN 12/7/12)', '500 Holland St. West', 'Bradford', 'ON', 'L3Z 0A2', '90-577-81297', 44.1057, -79.5917),
(507, 'Zehrs ', 'Zehrs Essa Road', '11 Bryne Drive', 'Barrie', 'ON', 'L4N 8V8', '7057331119', 44.3577, -79.6963),
(509, 'Zehrs ', 'Zehrs Alliston', '30 King Street South', 'Alliston', 'ON', 'L9R 1H6', '7054349391', 44.1505, -79.8794),
(510, 'Zehrs ', 'Zehrs Cundles', '201 Cundles Rd East', 'Barrie', 'ON', 'L4M 4S5', '7057395002', 44.4117, -79.6881),
(513, 'Zehrs ', 'Zehrs Pioneer Park', '123 Pioneer Park', 'Kitchener', 'ON', 'N2P 1K8', '5197484222', 43.394, -80.432),
(515, 'Zehrs ', 'Zehrs Hiway Centre', '1375 Weber St. East', 'Kitchener', 'ON', 'N2A 2Y7', '5197484570', 43.4321, -80.4411),
(519, 'Zehrs ', 'Zehrs Caledonia', '322 Argyle Street South', 'Caledonia', 'ON', 'N3W 1K8', '9057658207', 43.0625, -79.9604),
(520, 'Zehrs ', 'Zehrs Keswick', '24018 Woodbine Ave Rr # 2', 'Keswick', 'ON', 'L4P 3E9', '9054761318', 44.2272, -79.448),
(521, 'Zehrs ', 'Zehrs  Malden Road', '5890 Malden Road', 'Windsor', 'ON', 'N9H 1S4', '5199666030', 42.2472, -83.0584),
(522, 'Zehrs ', 'Zehrs Pen Centre', '221 Glendale Ave (At Hwy 406)', 'St. Catharines', 'ON', 'L2T 2K9', '9059843420', 43.1339, -79.2234),
(523, 'Zehrs ', 'Zehrs Stanley Park', '1005 Ottawa Street', 'Kitchener', 'ON', 'N2A 1H1', '5198937930', 43.4493, -80.4447),
(524, 'Zehrs ', 'Zehrs Beechwood', '450 Erb St. West', 'Waterloo', 'ON', 'N2T 1H4', '5198864900', 43.453, -80.5559),
(525, 'Zehrs ', 'Zehrs Glenridge', '315 Lincoln Road', 'Waterloo', 'ON', 'N2J 4H7', '5198851360', 43.483, -80.5063),
(528, 'Zehrs ', 'Zehrs Conestoga', '555 Davenport Road', 'Waterloo', 'ON', 'N2L 6L2', '5197460125', 43.4969, -80.5251),
(529, 'Zehrs ', 'Zehrs Parkway Mall', '7201 Tecumseh Rd East', 'Windsor', 'ON', 'N8T 3K4', '5199741000', 42.3117, -82.9385),
(531, 'Zehrs ', 'Zehrs Hartsland', '160 Kortright Road West', 'Guelph', 'ON', 'N1G 4W2', '5197637995', 43.5136, -80.2183),
(532, 'Zehrs ', 'Zehrs Goderich', '35400D Huron Road ', 'Goderich', 'ON', 'N7A 4C6', '5195242229', 43.7313, -81.6886),
(533, 'Zehrs ', 'Zehrs Cambridge Cntr', '400 Conestoga Blvd.', 'Cambridge', 'ON', 'N1R 7L7', '5196201376', 43.3916, -80.3159),
(535, 'Zehrs ', 'Zehrs Listowel', '600 Mitchell Rd Hwy 23 South', 'Listowel', 'ON', 'N4W 3T1', '5192915515', 43.7302, -80.9697),
(536, 'Zehrs ', 'Zehrs Geneva Street', 'Fairview Mall  285 Geneva St.', 'St Catharines', 'ON', 'L2N 2G1', '9056467671', 43.1777, -79.2445),
(537, 'Zehrs ', 'Zehrs Niagara', '6940 Morrison Street', 'Niagara Falls', 'ON', 'L2E 7K5', '9053585544', 43.1029, -79.1151),
(538, 'Zehrs ', 'Zehrs Eramosa', '297 Eramosa Road', 'Guelph', 'ON', 'N1E 2M7', '5197634550', 43.5589, -80.2481),
(539, 'Zehrs ', 'Zehrs Fergus', '800 Tower Street South', 'Fergus', 'ON', 'N1M 2R3', '5198435500', 43.698, -80.3685),
(540, 'Zehrs ', 'Zehrs Fairview', '410 Fairview Drive', 'Brantford', 'ON', 'N3R 7V7', '5197544932', 43.1698, -80.2489),
(543, 'Zehrs ', 'Zehrs King George', '290 King George Rd Nth/Hiway24', 'Brantford', 'ON', 'N3R 5L8', '5197518988', 43.1826, -80.2802),
(545, 'Zehrs ', 'Zehrs Hespeler', '180 Holiday Inn Drive', 'Cambridge', 'ON', 'N3C 3Z4', '5196584689', 43.4158, -80.3237),
(546, 'Zehrs ', 'Zehrs Bayfield', '472 Bayfield Street', 'Barrie', 'ON', 'L4M 5A2', '7057356689', 44.4116, -79.7132),
(550, 'Zehrs ', 'Zehrs Welland', '821 Niagara St. North', 'Welland', 'ON', 'L3C 1M4', '9057329377', 43.0172, -79.2518),
(552, 'Zehrs ', 'Zehrs Uxbridge', '323 Toronto St.S', 'Uxbridge', 'ON', 'L9P 1N2', '9058521212', 44.0897, -79.1307),
(554, 'Zehrs ', 'Zehrs Orangeville', ' 50 4th Ave', 'Orangeville', 'ON', 'L9W 1L0', '5199424223', 43.9258, -80.0914),
(555, 'Zehrs ', 'Zehrs Kincardine', '3-665 Philip Place', 'Kincardine', 'ON', 'N2Z 2Y8', '5193963474', 44.181, -81.6165),
(557, 'Zehrs ', 'Zehrs Stratford', '865 Ontario Street', 'Stratford', 'ON', 'N5A 7Y2', '5192736164', 43.3691, -80.9517),
(558, 'Zehrs ', 'Zehrs Bolton', '487 Queen St. S', 'Bolton', 'ON', 'L7E 2B4', '9059519555', 43.8715, -79.7244),
(559, 'Zehrs ', 'Zehrs Imperial', '1045 Paisely Road', 'Guelph', 'ON', 'N1K 1X6', '5198260080', 43.5226, -80.2894),
(560, 'Zehrs ', 'Zehrs Laurentian', '750 Ottawa St South', 'Kitchener', 'ON', 'N2E 1B6', '5197445981', 43.4238, -80.4875),
(563, 'Zehrs ', 'Zehrs Owen Sound', '1150 16th Street East', 'Owen Sound', 'ON', 'N4K 1Z3', '5193711196', 44.5754, -80.9239),
(565, 'Zehrs ', 'Zehrs Big Bay Point', '620 Yonge Street', 'Barrie', 'ON', 'L4N 4E6', '7057352390', 44.3553, -79.6486),
(570, 'Zehrs ', 'Zehrs Tillsonburg', '400 Simcoe Street', 'Tillsonburg', 'ON', 'N4G 4X1', '5198429031', 42.8552, -80.6906),
(572, 'Zehrs ', 'Zehrs Kingsville', '300 Main St. E', 'Kingsville', 'ON', 'N9Y 3S9', '5197336556', 42.0394, -82.7261),
(573, 'Zehrs ', 'Zehrs St Clair Beach', '400 Manning Road', 'Windsor', 'ON', 'N8N 4Z4', '5197353774', 42.3141, -82.8667),
(576, 'Zehrs ', 'Zehrs - South Cambridge', '200 Frankliin Blvd', 'Cambridge', 'ON', 'N1R 5S2', '5196248170', 43.3566, -80.2878),
(579, 'Zehrs ', 'Zehrs Woodstock', '969 Dundas Street', 'Woodstock', 'ON', 'N4S 1H2', '5194213411', 43.1355, -80.7313),
(580, 'Zehrs ', 'Zehrs Orillia', '289 Coldwater Road', 'Orillia', 'ON', 'L3V 6J3', '7053255777', 44.6083, -79.4378),
(806, 'YIG', 'Jonsson''s YIG', 'Kemptville Mall Hwy. 43 W.', 'Kemptville', 'ON', 'K0G 1J0', '6132585966', 45.0164, -75.646),
(810, 'YIG', 'Davis'' YIG', '20 Jocelyn Road', 'Port Hope', 'ON', 'L1A 3V5', '9058851867', 43.9606, -78.3206),
(812, 'YIG', 'Larabie''s YIG', '55 Brunetville Road', 'Kapuskasing', 'ON', 'P5N 2E8', '7053374909', 49.4202, -82.4156),
(816, 'YIG', 'Robinson''s YIG', '131 Howland Drive', 'Huntsville', 'ON', 'P1H 2P7', '7057896972', 45.3448, -79.227),
(817, 'YIG', 'Todd''s YIG', '5121 Country Road #21', 'Haliburton', 'ON', 'K0M 1S0', '7054559775', 45.046, -78.5346),
(818, 'YIG', 'Gagnon''s YIG', '270 Wellington Street', 'Bracebridge', 'ON', 'P1L 1B9', '7056461412', 45.0428, -79.3227),
(819, 'YIG', 'Ross'' YIG', '3777 Strandherd Drive', 'Nepean', 'ON', 'K2J 4B1', '6138439413', 45.2681, -75.7472),
(820, 'YIG', 'Laurin YIG', '1560 Cameron Street', 'Hawkesbury', 'ON', 'K6A 3S5', '6136329215', 45.5933, -74.6017),
(823, 'YIG', 'Andress'' YIG', '25 Ferrara Drive', 'Smiths Falls', 'ON', 'K7A5K6', '6132832999', 44.8925, -76.0268),
(825, 'YIG', 'Steve''s YIG', '455 McNeely Avenue', 'CARLETON PLACE', 'ON', 'K7C 4S6', '6132536206', 45.134, -76.1214),
(827, 'YIG', 'Embrun YIG', '753 Notre Dame Street', 'Embrun', 'ON', 'K0A 1W0', '6134433064', 45.2676, -75.3037),
(831, 'YIG', 'O''Reilly''s YIG', '150 Prescott Centre Drive', 'Prescott', 'ON', 'K0E 1T0', '6139254625', 44.7244, -75.5206),
(835, 'YIG', 'Vos'' YIG', '1893 Scugog Street', 'Port Perry', 'ON', 'L9L 1H9', '9059859772', 44.1028, -78.9373),
(839, 'YIG', 'Fisher''s YIG', 'B30 Beaver Avenue', 'Beaverton', 'ON', 'L0K 1A0', '7054262598', 44.4281, -79.1251),
(847, 'YIG', 'Moncion''s  YIG', '685 River Road', 'Ottawa', 'ON', 'K1V 2G2', '6138224749', 45.2702, -75.6982),
(866, 'YIG', 'King''s YIG', '5911 Perth St.', 'Richmond', 'ON', 'K0A 2Z0', '613-838-7255', 45.2031, -75.8289),
(870, 'YIG', 'Robinson''s YIG', '1160 Beaverwood Road P.O. Box 517', 'Manotick', 'ON', 'K4M 1A5', '6136922828', 45.2235, -75.6847),
(878, 'YIG', 'Morello''s YIG', '400 Lansdowne Street East', 'Peterborough', 'ON', 'K9L 0B2', '7057409365', 44.2928, -78.29),
(881, 'YIG', 'Bissonnette''s YIG ', '596 Montreal Road', 'Ottawa', 'ON', 'K1K 0T9', '6137450778', 45.4423, -75.6432),
(885, 'YIG', 'Terry''s YIG', '290 First Street North', 'Gravenhurst', 'ON', 'P1P 1H3', '7056870554', 44.9217, -79.3724),
(889, 'YIG', 'Patrice''s YIG', '401 Ottawa Street', 'Almonte', 'ON', 'K0A 1A0', '6132562080', 45.2339, -76.1822),
(891, 'YIG', 'Grenon''s YIG', '2737 Laurier Street', 'Rockland', 'ON', 'K4K 1A3', '613-446-7273', 45.5417, -75.2993),
(894, 'YIG', 'McDaniel''s YIG', '200 Grant Carman', 'Nepean', 'ON', 'K2E 7Z8', '6137271672', 45.3513, -75.7307),
(895, 'YIG', 'Hansen''s YIG', '62 Thames Road East', 'Exeter', 'ON', 'N0M 1S3', '5192356131', 43.3634, -81.4812),
(896, 'YIG', 'Dumas'' YIG', '82 Lorne Street', 'Sudbury', 'ON', 'P3C 4N8', '7056713051', 46.4902, -81.0021),
(1000, 'Loblaws    ', 'LSL Queen & Portland', '585 Queen Street West', 'Toronto', 'ON', 'M5V 2B7', '416-703-3419', 43.6474, -79.4019),
(1001, 'Loblaws    ', 'LSL Pickering Market', '1792 Liverpool Road', 'Pickering', 'ON', 'L1V 1V9', '9058316301', 43.8323, -79.0914),
(1003, 'Loblaws    ', 'LSL Heartland Market', '5970 Mclaughlin Road', 'Mississauga', 'ON', 'L5R 3X9', '9055688551', 43.6147, -79.6886),
(1004, 'Loblaws    ', 'LSL Leslie  &  Lakeshore', '17 Leslie Street', 'Toronto', 'ON', 'M4M 3H9', '4164692897', 43.661, -79.3283),
(1007, 'Loblaws    ', 'LSL Maple Leaf Gardens', '60 Carlton Street', 'Toronto', 'ON', 'M5B 1J2', '416-593-6154', 43.662, -79.3802),
(1010, 'Loblaws    ', 'LSL Empress Market', '5095 Yonge Street', 'NORTH YORK', 'ON', 'M2N 6Z4', '4165129430', 43.7687, -79.4121),
(1011, 'Loblaws    ', 'LSL Glen Erin Market', '5010 Glen Erin Drive', 'Mississauga', 'ON', 'L5M 6J3', '9056070580', 43.5547, -79.715),
(1014, 'Loblaws    ', 'LSL Vanier Market', '100 McArthur Road', 'Ottawa', 'ON', 'K1L 6P9', '6137440705', 45.4294, -75.6647),
(1016, 'Loblaws    ', 'LSL Wonderland Market', '3040 Wonderland Road South', 'London', 'ON', 'N6L 1A6', '5196680719', 42.9382, -81.2782),
(1019, 'Loblaws    ', 'LSL Bayview Village', '2877 Bayview Village', 'TORONTO', 'ON', 'M2K 2S3', '4167331783', 43.7696, -79.3875),
(1021, 'Loblaws    ', 'LSL Victoria Park Market', '50 Musgrave Street', 'Toronto', 'ON', 'M4E 3W2', '4166943838', 43.6885, -79.2883),
(1022, 'Loblaws    ', 'LSL Lindsay', '400 Kent Street West', 'Lindsay', 'ON', 'K9V 6K2', '7058784605', 44.3492, -78.7636),
(1023, 'Loblaws    ', 'LSL Nepean Robertson', '2065A Robertson Road', 'Napean', 'ON', 'K2H 5H9', '6138299770', 45.3245, -75.8325),
(1027, 'Loblaws    ', 'LSL Fanshawe Market', '1740 Richmond Street North', 'London', 'ON', 'N5X 2S7', '5196736111', 43.0282, -81.2822),
(1028, 'Loblaws    ', 'LSL Richmond Hill', '301 High Tec Road', 'Richmond Hill', 'ON', 'L4B 4R2', '9057711066', 43.8432, -79.4108),
(1029, 'Loblaws    ', 'LSL Dupont & Christie', '650 Dupont Street', 'Toronto', 'ON', 'M6G 4B1', '4165883756', 43.6721, -79.421),
(1032, 'Loblaws    ', 'LSL Mccowan Market Markham', '200 Bullock Drive', 'Markham', 'ON', 'L3P 1W2', '9052944922', 43.8743, -79.2848),
(1035, 'Loblaws    ', 'LSL Barrhaven', '3201 Greenbank Road', 'Ottawa', 'ON', 'K2J 4H9', '6138250812', 45.268, -75.7436),
(1040, 'Loblaws    ', 'LSL Princess Market', '1100 Princess Street', 'Kingston', 'ON', 'K7L 5G8', '6135303861', 44.2428, -76.5185),
(1050, 'Loblaws    ', 'LSL College Square Market', '1980 Baseline Road', 'Ottawa', 'ON', 'K2C 0C6', '6137233200', 45.352, -75.7595),
(1051, 'Loblaws    ', 'LSL Gloucester (New)', '1980 Ogilvie Rd.', 'Ottawa', 'ON', 'K1J 9L3', '6137465724', 45.4325, -75.6103),
(1064, 'Loblaws    ', 'LSL Bowmanville Market', '2375 Highway #2', 'Bowmanville', 'ON', 'L1C 5A3', '9056232600', 43.9084, -78.7109),
(1066, 'Loblaws    ', 'LSL Burnhamthorpe Market', '380 The East Mall', 'Etobicoke', 'ON', 'M9B 6L5', '4166958990', 43.6439, -79.5601),
(1079, 'Loblaws    ', 'LSL Queens Quay Market', '10 Lower Jarvis Street', 'Toronto', 'ON', 'M5E 1Z2', '4163040611', 43.6443, -79.3698),
(1082, 'Loblaws    ', 'LSL Merivale', '1460 Merivale Road', 'Ottawa', 'ON', 'K2E 5P2', '6132266001', 45.3619, -75.7354),
(1083, 'Loblaws    ', 'LSL Cataraqui Market Kingston', '1048 Midland Avenue', 'Kingston', 'ON', 'K7P 2X9', '6133895339', 44.2611, -76.572),
(1090, 'Loblaws    ', 'LSL Port Credit', '250 Lakeshore Road West', 'Port Credit', 'ON', 'L5H 1G6', '9052719925', 43.5468, -79.5945),
(1092, 'Loblaws    ', 'LSL Millwood & Laird', '11 Redway Road', 'TORONTO', 'ON', 'M4H 1P6', '4164255516', 43.6992, -79.3597),
(1095, 'Loblaws    ', 'LSL Isabella', '64 Isabella Street', 'Ottawa', 'ON', 'K1S 1V4', '6132324128', 45.4105, -75.6859),
(1099, 'Loblaws    ', 'LSL Humbercrest Market', '3671 Dundas Street West', 'Etobicoke', 'ON', 'M6S 2T3', '4167697171', 43.6654, -79.4959),
(1114, 'Loblaws    ', 'LSL Kanata', '200 Earl Grey Drive', 'Ottawa', 'ON', 'K2T 1B6', '6135999934', 45.3095, -75.9145),
(1127, 'Loblaws    ', 'LSL Collingwood Market', '12 Hurontario Street', 'Collingwood', 'ON', 'L9Y 2L6', '7054451431', 44.5024, -80.2181),
(1132, 'Loblaws    ', 'LSL Carlingwood', '2085 Carling Avenue', 'Ottawa', 'ON', 'K2A 1H2', '6137223227', 45.3723, -75.7676),
(1142, 'Loblaws    ', 'LSL St. Clair Market', '12 St. Clair Avenue East', 'Toronto', 'ON', 'M4T 1L7', '4169608108', 43.6885, -79.3938),
(1154, 'Loblaws    ', 'LSL Dundas & Bloor', '2280 Dundas Street  West', 'Toronto', 'ON', 'M6R 1X3', '4165334078', 43.6551, -79.4494),
(1155, 'Loblaws    ', 'LSL Bayview & Moore', '301 Moore Avenue', 'Toronto', 'ON', 'M4G 1E1', '4164250604', 43.6964, -79.3707),
(1170, 'Loblaws    ', 'LSL Rideau & Nelson', '363 Rideau Street', 'Ottawa', 'ON', 'K1N 5Y6', '6137893330', 45.43, -75.6837),
(1174, 'Loblaws    ', 'LSL Humbertown', '270 The Kingsway', 'Etobicoke', 'ON', 'M9A 3T7', '4162310931', 43.6618, -79.5197),
(1179, 'Loblaws    ', 'LSL Broadview', '720 Broadview Avenue', 'Toronto', 'ON', 'M4K 2P1', '4167788762', 43.6751, -79.3584),
(1188, 'Loblaws    ', 'LSL South Keys', '2210C Bank Street', 'OTTAWA', 'ON', 'K1V 1J5', '6137331377', 45.3568, -75.6552),
(1194, 'Loblaws    ', 'LSL Yonge & Yonge', '3501 Yonge Street', 'North York', 'ON', 'M4N 2N5', '4164817753', 43.7354, -79.4042),
(1200, 'Loblaws    ', 'LSL Elmvale', '1910 St Laurent Blvd', 'Ottawa', 'ON', 'K1G 1A4', '6135210880', 45.399, -75.6241),
(1208, 'Loblaws    ', 'LSL Yonge & Bernard', '10909 Yonge Street', 'Richmond Hill', 'ON', 'L4C 3E3', '9057371222', 43.894, -79.4404),
(1212, 'Loblaws    ', 'LSL Forest Hill Market', '396 St. Clair Avenue West', 'Toronto', 'ON', 'M5P 3N3', '4166515166', 43.6842, -79.4154),
(2601, 'YIG', 'Wilkinson''s YIG', '227 Main Street', 'Delhi', 'ON', 'N4B 2N4', '5195820864', 42.8535, -80.4991),
(2608, 'YIG', 'Smylie''s YIG', '293 Dundas St E', 'Trenton', 'ON', 'K8V 1M1', '6133920297', 44.1038, -77.5539),
(2611, 'YIG', 'Chartrand''s YIG', '4764-17 Regional Road 15', 'Chelmsford', 'ON', 'P0M 1L0', '7058554588', 46.5706, -81.184),
(2614, 'YIG', 'McDonalds YIG', '780 Queen Street East PO Box 220', 'St Mary''s', 'ON', 'N4X 1B1', '5192841426', 43.2621, -81.1181),
(2624, 'YIG', 'Vrab''s YIG', '1836 Regent Street South', 'Sudbury', 'ON', 'P3E 3Z8', '7055227111', 46.4536, -81.0036),
(2628, 'YIG', 'Dailey''s YIG', '654 Algonquin Blvd East', 'Timmins', 'ON', 'P4N 8R4', '7052648233', 48.4779, -81.3156),
(2638, 'YIG', 'Rowland''s YIG', '1244 Goderich St.', 'Port Elgin', 'ON', 'N0H 2C0', '5193896800', 44.4533, -81.3754),
(2639, 'YIG', 'Parker''s YIG', '1 LAURENTIAN AVENUE', 'North Bay', 'ON', 'P1B 9P2', '7054728866', 46.3204, -79.4399),
(2640, 'YIG', 'Chartrand''s YIG', '420 Main Street South', 'Alexandria', 'ON', 'K0C 1A0', '6135252566', 45.2994, -74.6296),
(2648, 'YIG', 'Laura''s YIG', '300 Eagleson  Road', 'Kanata', 'ON', 'K2M 1C9', '6135923850', 45.3021, -75.8779),
(2653, 'YIG', 'Rocheleau YIG', '1521 Highway 11 West', 'Hearst', 'ON', 'P0L 1N0', '7053621168', 49.6913, -83.6826),
(2655, 'YIG', 'Heidi''s YIG', '4136 Petrolia Street', 'Petrolia', 'ON', 'N0N 1R0', '5198822211', 42.882, -82.1505),
(2656, 'YIG', 'McDonough''s YIG', '2241 Riverside Drive', 'Ottawa', 'ON', 'K1H 7X5', '613-733-1590', 45.3862, -75.6762),
(2682, 'YIG', 'Tremblett''s YIG', '273 King Street West', 'Ingersoll', 'ON', 'N5C 2K9', '519-425-4406', 43.0316, -80.8932),
(2683, 'YIG', 'Rome''s YIG', '44 Great Northern Road', 'Sault Ste. Marie', 'ON', 'P6B 4Y5', '705-253-1726', 46.524, -84.3172),
(4402, 'Zehrs ', 'Laurentian Learning Centre', '750 Ottawa St South', 'Kitchener', 'ON', 'N2E 1B6', '519 7442741', 43.4238, -80.4875);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store_info`
--
ALTER TABLE `store_info`
  ADD PRIMARY KEY (`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store_info`
--
ALTER TABLE `store_info`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4403;