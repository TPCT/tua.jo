<?php

use yii\db\Migration;

class m250309_222433_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
        $this->db->createCommand("DROP TABLE IF EXISTS `countries`")->execute();
        $this->createTable('countries', [
            'id' => $this->primaryKey(),
            'guid' => $this->string(50)->notNull(),
            'num_code' => $this->string(10)->notNull(),
            'alpha_2_code' => $this->string(4)->notNull(),
            'alpha_3_code' => $this->string(10)->notNull(),
            'en_short_name' => $this->string()->notNull(),
            'ar_short_name' => $this->string()->notNull(),
            'en_nationality' => $this->string()->notNull(),
            'ar_nationality' => $this->string()->notNull(),
        ]);

        $this->db->createCommand("
            INSERT INTO countries (guid, ar_short_name, en_short_name, num_code, alpha_2_code, alpha_3_code, ar_nationality, en_nationality) VALUES
            ('73984140-aa55-e711-94a7-00155d000316', 'لبنان', 'Lebanon', '961', 'LB', 'LBN', 'لبناني', 'Lebanese'),
            ('04690a64-8303-e911-94f5-00155d00d618', 'كندا', 'Canada', '1', 'CA', 'CAN', 'كندي', 'Canadian'),
            ('5f50c5fb-8303-e911-94f5-00155d00d618', 'السعودية', 'Saudi Arabia', '966', 'SA', 'SAU', 'سعودي', 'Saudi'),
            ('fb881e89-8703-e911-94f5-00155d00d618', 'قطر', 'Qatar', '974', 'QA', 'QAT', 'قطري', 'Qatari'),
            ('e8e08e17-8803-e911-94f5-00155d00d618', 'سيريلانكا', 'Sri Lanka', '94', 'LK', 'LKA', 'سريلانكي', 'Sri Lankan'),
            ('9b6d9038-8803-e911-94f5-00155d00d618', 'البحرين', 'Bahrain', '973', 'BH', 'BHR', 'بحريني', 'Bahraini'),
            ('1ea91b7c-8803-e911-94f5-00155d00d618', 'الكويت', 'Kuwait', '965', 'KW', 'KWT', 'كويتي', 'Kuwaiti'),
            ('d9bcd5dc-8803-e911-94f5-00155d00d618', 'العراق', 'Iraq', '964', 'IQ', 'IRQ', 'عراقي', 'Iraqi'),
            ('6a416494-8903-e911-94f5-00155d00d618', 'الولايات المتحدة الامريكية', 'United States of America', '1', 'US', 'USA', 'أمريكي', 'American'),
            ('e0ea24f7-8903-e911-94f5-00155d00d618', 'ايطاليا', 'Italy', '39', 'IT', 'ITA', 'إيطالي', 'Italian'),
            ('b9d2ad69-8a03-e911-94f5-00155d00d618', 'المانيا', 'Germany', '49', 'DE', 'DEU', 'ألماني', 'German'),
            ('dd201b4b-8b03-e911-94f5-00155d00d618', 'فرنسا', 'France', '33', 'FR', 'FRA', 'فرنسي', 'French'),
            ('47e5f276-8b03-e911-94f5-00155d00d618', 'هولندا', 'Holland', '31', 'NL', 'NLD', 'هولندي', 'Dutch'),
            ('107148ce-8b03-e911-94f5-00155d00d618', 'اورغواي', 'Uruguay', '598', 'UY', 'URY', 'أورغواني', 'Uruguayan'),
            ('91631420-8c03-e911-94f5-00155d00d618', 'اليمن', 'Yemen', '967', 'YE', 'YEM', 'يمني', 'Yemeni'),
            ('2542ac35-8c03-e911-94f5-00155d00d618', 'كوستاريكا', 'Costa Rica', '506', 'CR', 'CRI', 'كوستاريكي', 'Costa Rican'),
            ('dd48a7ae-8c03-e911-94f5-00155d00d618', 'السويد', 'Sweden', '46', 'SE', 'SWE', 'سويدي', 'Swedish'),
            ('60f4273c-8d03-e911-94f5-00155d00d618', 'عُمان', 'Oman', '968', 'OM', 'OMN', 'عماني', 'Omani'),
            ('eb014661-8d03-e911-94f5-00155d00d618', 'البرتغال', 'Portugal', '351', 'PT', 'PRT', 'برتغالي', 'Portuguese'),
            ('889f8270-8d03-e911-94f5-00155d00d618', 'ليبيا', 'Libya', '218', 'LY', 'LBY', 'ليبي', 'Libyan'),
            ('40cc59af-8d03-e911-94f5-00155d00d618', 'رومانيا', 'Romania', '40', 'RO', 'ROU', 'روماني', 'Romanian'),
            ('bdbf62cc-8d03-e911-94f5-00155d00d618', 'مصر', 'Egypt', '20', 'EG', 'EGY', 'مصري', 'Egyptian'),
            ('e8c09ec0-8f03-e911-94f5-00155d00d618', 'النمسا', 'Austria', '43', 'AT', 'AUT', 'نمساوي', 'Austrian'),
            ('815d2beb-8f03-e911-94f5-00155d00d618', 'الدنمارك', 'Denmark', '45', 'DK', 'DNK', 'دنماركي', 'Danish'),
            ('8ec28df1-8f03-e911-94f5-00155d00d618', 'هندوراس', 'Honduras', '504', 'HN', 'HND', 'هندوراسي', 'Honduran'),
            ('88d12e13-9003-e911-94f5-00155d00d618', 'اليابان', 'Japan', '81', 'JP', 'JPN', 'ياباني', 'Japanese'),
            ('8a8eddea-9003-e911-94f5-00155d00d618', 'السلفادور', 'El Salvador', '503', 'SV', 'SLV', 'سلفادوري', 'Salvadoran'),
            ('2ebdd575-9103-e911-94f5-00155d00d618', 'فنلندا', 'Finland', '358', 'FI', 'FIN', 'فنلندي', 'Finnish'),
            ('58195ba5-9103-e911-94f5-00155d00d618', 'تشيلي', 'Chile', '56', 'CL', 'CHL', 'تشيليني', 'Chilean'),
            ('535d03c5-9203-e911-94f5-00155d00d618', 'بوتان', 'Bhutan', '975', 'BT', 'BTN', 'بوتاني', 'Bhutanese'),
            ('8abfbfcb-9503-e911-94f5-00155d00d618', 'سلوفينيا', 'Slovenia', '386', 'SI', 'SVN', 'سلوفيني', 'Slovenian'),
            ('43d7a1c0-9703-e911-94f5-00155d00d618', 'هونغ كونغ', 'Hong Kong', '852', 'HK', 'HKG', 'هونغ كونغي', 'Hong Konger'),
            ('4a437ff7-1f04-e911-94f5-00155d00d618', 'جبل طارق', 'Gibraltar', '350', 'GI', 'GIB', 'جبل طارقي', 'Gibraltarian'),
            ('da486913-2204-e911-94f5-00155d00d618', 'سينغافورا', 'Singapore', '65', 'SG', 'SGP', 'سنغافوري', 'Singaporean'),
            ('00fbc7c5-2304-e911-94f5-00155d00d618', 'تركيا', 'Turkey', '90', 'TR', 'TUR', 'تركي', 'Turkish'),
            ('9926a00d-2404-e911-94f5-00155d00d618', 'منغوليا', 'Mongolia', '976', 'MN', 'MNG', 'منغولي', 'Mongolian'),
            ('e10f8edc-2404-e911-94f5-00155d00d618', 'الفليبين', 'Philippines', '63', 'PH', 'PHL', 'فلبيني', 'Filipino'),
            ('5f56493b-350f-e911-94f8-00155d00d61b', 'سويسرا', 'Switzerland', '41', 'CH', 'CHE', 'سويسري', 'Swiss'),
            ('1c163b34-284a-e911-80c8-00155d01d533', 'المغرب', 'Morocco', '212', 'MA', 'MAR', 'مغربي', 'Moroccan'),
            ('3f30853b-284a-e911-80c8-00155d01d533', 'الجزائر', 'Algeria', '213', 'DZ', 'DZA', 'جزائري', 'Algerian'),
            ('bf502a46-284a-e911-80c8-00155d01d533', 'تونس', 'Tunisia', '216', 'TN', 'TUN', 'تونسي', 'Tunisian'),
            ('eab66757-284a-e911-80c8-00155d01d533', 'كوريا الجنوبية', 'South Korea', '82', 'None', 'None', 'كوري جنوبي', 'South Korean'),
            ('289b7665-284a-e911-80c8-00155d01d533', 'كوريا الشمالية', 'North Korea', '850', 'None', 'None', 'كوري شمالي', 'North Korean'),
            ('efc00e75-284a-e911-80c8-00155d01d533', 'الأرجنتين', 'Argentina', '54', 'AR', 'ARG', 'أرجنتيني', 'Argentinian'),
            ('b7618e7c-284a-e911-80c8-00155d01d533', 'البرازيل', 'Brazil', '55', 'BR', 'BRA', 'برازيلي', 'Brazilian'),
            ('08b1509d-9d4f-e911-80c8-00155d01d533', 'التشيك', 'Czechia', '420', 'CZ', 'CZE', 'تشيكي', 'Czech'),
            ('4e9303c1-9d4f-e911-80c8-00155d01d533', 'جنوب افريقيا', 'South Africa', '27', 'ZA', 'ZAF', 'جنوب أفريقي', 'South African'),
            ('373f54e0-9d4f-e911-80c8-00155d01d533', 'روسيا البيضاء', 'Belarus', '375', 'BY', 'BLR', 'بيلاروسي', 'Belarusian'),
            ('f917bcff-9d4f-e911-80c8-00155d01d533', 'زيمبابوي', 'Zimbabwe', '263', 'ZW', 'ZWE', 'زيمبابوي', 'Zimbabwean'),
            ('3e95db26-9e4f-e911-80c8-00155d01d533', 'سلوفاكيا', 'Slovakia', '421', 'SK', 'SVK', 'سلوفاكي', 'Slovak'),
            ('d45f114e-9e4f-e911-80c8-00155d01d533', 'الغابون', 'Gabon', '241', 'GA', 'GAB', 'غابوني', 'Gabonese'),
            ('70cfa663-9e4f-e911-80c8-00155d01d533', 'غانا', 'Ghana', '233', 'GH', 'GHA', 'غاني', 'Ghanaian'),
            ('b14bcd6c-9e4f-e911-80c8-00155d01d533', 'غينيا الاستوائية', 'Equatorial Guinea', '240', 'GQ', 'GNQ', 'غيني استوائي', 'Equatoguinean'),
            ('1ea98688-9e4f-e911-80c8-00155d01d533', 'الكاميرون', 'Cameroon', '237', 'CM', 'CMR', 'كاميروني', 'Cameroonian'),
            ('07aa909c-9e4f-e911-80c8-00155d01d533', 'كرواتيا', 'Croatia', '385', 'HR', 'HRV', 'كرواتي', 'Croatian'),
            ('f47bfdc2-9e4f-e911-80c8-00155d01d533', 'الكونغو', 'Republic of the Congo', '242', 'CG', 'COG', 'كونغولي', 'Congolese'),
            ('005655d4-9e4f-e911-80c8-00155d01d533', 'ليتوانيا', 'Lithuania', '370', 'LT', 'LTU', 'ليتواني', 'Lithuanian'),
            ('bf5adf02-9f4f-e911-80c8-00155d01d533', 'المالديف', 'Maldives', '960', 'MV', 'MDV', 'مالديفي', 'Maldivian'),
            ('0016c533-9f4f-e911-80c8-00155d01d533', 'مدغشقر', 'Madagascar', '261', 'MG', 'MDG', 'مدغشقري', 'Malagasy'),
            ('91de4e57-9f4f-e911-80c8-00155d01d533', 'النرويج', 'Norway', '47', 'NO', 'NOR', 'نرويجي', 'Norwegian'),
            ('439b4c70-9f4f-e911-80c8-00155d01d533', 'نيجيريا', 'Nigeria', '234', 'NG', 'NGA', 'نيجيري', 'Nigerian'),
            ('1b469f7d-9f4f-e911-80c8-00155d01d533', 'هايتي', 'Haiti', '509', 'HT', 'HTI', 'هايتي', 'Haitian'),
            ('1b316b92-9f4f-e911-80c8-00155d01d533', 'اليونان', 'Greece', '30', 'GR', 'GRC', 'يوناني', 'Greek'),
            ('0c1011ca-9f4f-e911-80c8-00155d01d533', 'بوركينافاسو', 'Burkina Faso', '226', 'BF', 'BFA', 'بوركيني', 'Burkinabé'),
            ('e665dcf5-9f4f-e911-80c8-00155d01d533', 'فيتنام', 'Vietnam', '84', 'VN', 'VNM', 'فيتنامي', 'Vietnamese'),
            ('398e67b8-f021-e411-941e-00155d01f403', 'استراليا', 'Australia', '61', 'AU', 'AUS', 'أسترالي', 'Australian'),
            ('3fd036d1-1922-e411-941e-00155d01f403', 'الامارات العربية المتحدة', 'United Arab Emirates', '971', 'AE', 'ARE', 'إماراتي', 'Emirati'),
            ('a568b857-a62e-e411-9427-00155d01f403', 'الأردن', 'Jordan', '962', 'JO', 'JOR', 'أردني', 'Jordanian'),
            ('9b391cbb-90e5-e711-94ba-00155d01f427', 'فلسطين', 'Palestine', '970', 'PS', 'PSE', 'فلسطيني', 'Palestinian'),
            ('b39fa2f5-7a64-eb11-b92f-00155d821418', 'ايسلندا', 'Iceland', '354', 'IS', 'ISL', 'أيسلندي', 'Icelandic'),
            ('291b8a38-f4bf-e811-950a-00155d82d306', 'قبرص', 'Cyprus', '357', 'CY', 'CYP', 'قبرصي', 'Cypriot'),
            ('62463e28-2917-e911-80bf-00155d82d31e', 'مكسيك', 'Mexico', '52', 'MX', 'MEX', 'مكسيكي', 'Mexican'),
            ('66b0d4b3-284a-e911-80e1-00155d82d338', 'السودان', 'Sudan', '249', 'SD', 'SDN', 'سوداني', 'Sudanese'),
            ('aafa9a44-294a-e911-80e1-00155d82d338', 'الهند', 'India', '91', 'IN', 'IND', 'هندي', 'Indian'),
            ('498b0456-294a-e911-80e1-00155d82d338', 'روسيا', 'Russia', '7', 'RU', 'RUS', 'روسي', 'Russian'),
            ('d016cade-9b4f-e911-80e1-00155d82d338', 'بولندا', 'Poland', '48', 'PL', 'POL', 'بولندي', 'Polish'),
            ('cc2792ee-9b4f-e911-80e1-00155d82d338', 'هنغاريا', 'Hungary', '36', 'HU', 'HUN', 'مجري', 'Hungarian'),
            ('5d3f9b14-9c4f-e911-80e1-00155d82d338', 'جورجيا', 'Georgia', '995', 'GE', 'GEO', 'جورجي', 'Georgian'),
            ('1bdcd31d-9c4f-e911-80e1-00155d82d338', 'اذربيجان', 'Azerbaijan', '994', 'AZ', 'AZE', 'أذربيجاني', 'Azerbaijani'),
            ('ef096233-9c4f-e911-80e1-00155d82d338', 'ارمينيا', 'Armenia', '374', 'AM', 'ARM', 'أرميني', 'Armenian'),
            ('a3046443-9c4f-e911-80e1-00155d82d338', 'اسبانيا', 'Spain', '34', 'ES', 'ESP', 'إسباني', 'Spanish'),
            ('61038e4c-9c4f-e911-80e1-00155d82d338', 'اريتيريا', 'Eritrea', '291', 'ER', 'ERI', 'إريتري', 'Eritrean'),
            ('f6c4b555-9c4f-e911-80e1-00155d82d338', 'استونيا', 'Estonia', '372', 'EE', 'EST', 'إستوني', 'Estonian'),
            ('d6ea5160-9c4f-e911-80e1-00155d82d338', 'افغانستان', 'Afghanistan', '93', 'AF', 'AFG', 'أفغاني', 'Afghan'),
            ('cb2b4f66-9c4f-e911-80e1-00155d82d338', 'الاكوادور', 'Ecuador', '593', 'EC', 'ECU', 'إكوادوري', 'Ecuadorian'),
            ('0974066f-9c4f-e911-80e1-00155d82d338', 'البانيا', 'Albania', '355', 'AL', 'ALB', 'ألباني', 'Albanian'),
            ('d3637378-9c4f-e911-80e1-00155d82d338', 'اندونيسيا', 'Indonesia', '62', 'ID', 'IDN', 'إندونيسي', 'Indonesian'),
            ('e5a63283-9c4f-e911-80e1-00155d82d338', 'ايران', 'Iran', '98', 'IR', 'IRN', 'إيراني', 'Iranian'),
            ('b86b2f95-9c4f-e911-80e1-00155d82d338', 'باراغواي', 'Paraguay', '595', 'PY', 'PRY', 'باراغواياني', 'Paraguayan'),
            ('e7fd02a1-9c4f-e911-80e1-00155d82d338', 'باكستان', 'Pakistan', '92', 'PK', 'PAK', 'باكستاني', 'Pakistani'),
            ('8dd236b3-9c4f-e911-80e1-00155d82d338', 'بلغاريا', 'Bulgaria', '359', 'BG', 'BGR', 'بلغاري', 'Bulgarian'),
            ('dd9db8c3-9c4f-e911-80e1-00155d82d338', 'بنغلادش', 'Bangladesh', '880', 'BD', 'BGD', 'بنغلادشي', 'Bangladeshi'),
            ('4a4610cd-9c4f-e911-80e1-00155d82d338', 'بروناي', 'Brunei', '673', 'BN', 'BRN', 'بروناوي', 'Bruneian'),
            ('a261add5-9c4f-e911-80e1-00155d82d338', 'بنما', 'Panama', '507', 'PA', 'PAN', 'بنمي', 'Panamanian'),
            ('9fa513de-9c4f-e911-80e1-00155d82d338', 'باهاماس', 'The Bahamas', '1-242', 'BS', 'BHS', 'باهامي', 'Bahamian'),
            ('ec4819ea-9c4f-e911-80e1-00155d82d338', 'البوسنة و الهرسك', 'Bosnia and Herzegovina', '387', 'BA', 'BIH', 'بوسني', 'Bosnian'),
            ('19fe0af1-9c4f-e911-80e1-00155d82d338', 'بوليفيا', 'Bolivia', '591', 'BO', 'BOL', 'بوليفي', 'Bolivian'),
            ('bfb494fa-9c4f-e911-80e1-00155d82d338', 'بيرو', 'Peru', '51', 'PE', 'PER', 'بيري', 'Peruvian'),
            ('d66cad01-9d4f-e911-80e1-00155d82d338', 'تايلاند', 'Thailand', '66', 'TH', 'THA', 'تايلاندي', 'Thai'),
            ('2be1fb11-9d4f-e911-80e1-00155d82d338', 'تركمانستان', 'Turkmenistan', '993', 'TM', 'TKM', 'تركماني', 'Turkmen'),
            ('cc0d2c19-9d4f-e911-80e1-00155d82d338', 'تشاد', 'Chad', '235', 'TD', 'TCD', 'غير معروف', 'Unknown'),
            ('d00d2c19-9d4f-e911-80e1-00155d82d338', 'توغو', 'Togo', '228', 'TG', 'TGO', 'غير معروف', 'Unknown'),
            ('154a4224-9d4f-e911-80e1-00155d82d338', 'تنزانيا', 'Tanzania', '255', 'TZ', 'TZA', 'غير معروف', 'Unknown'),
            ('f37b5dae-9d4f-e911-80e1-00155d82d338', 'جامايكا', 'Jamaica', '1-876', 'JM', 'JAM', 'غير معروف', 'Unknown'),
            ('98f84fd6-9d4f-e911-80e1-00155d82d338', 'الرأس الاخضر', 'Cape Verde', '238', 'None', 'None', 'غير معروف', 'Unknown'),
            ('64c910ed-9d4f-e911-80e1-00155d82d338', 'زامبيا', 'Zambia', '260', 'ZM', 'ZMB', 'غير معروف', 'Unknown'),
            ('19917705-9e4f-e911-80e1-00155d82d338', 'ساحل العاج', 'Côte dIvoire', '225', 'None', 'None', 'غير معروف', 'Unknown'),
            ('67fc903c-9e4f-e911-80e1-00155d82d338', 'سوريا', 'Syria', '963', 'SY', 'SYR', 'غير معروف', 'Unknown'),
            ('411e865e-9e4f-e911-80e1-00155d82d338', 'غامبيا', 'The Gambia', '220', 'GM', 'GMB', 'غير معروف', 'Unknown'),
            ('29171a6b-9e4f-e911-80e1-00155d82d338', 'غينيا', 'Guinea', '224', 'GN', 'GIN', 'غير معروف', 'Unknown'),
            ('ec837d7e-9e4f-e911-80e1-00155d82d338', 'جزر القمر', 'Comoros', '269', 'KM', 'COM', 'غير معروف', 'Unknown'),
            ('118c5e8d-9e4f-e911-80e1-00155d82d338', 'كوبا', 'Cuba', '53', 'CU', 'CUB', 'غير معروف', 'Unknown'),
            ('89644ebb-9e4f-e911-80e1-00155d82d338', 'لوكسمبورغ', 'Luxembourg', '352', 'LU', 'LUX', 'غير معروف', 'Unknown'),
            ('3ceaafca-9e4f-e911-80e1-00155d82d338', 'ليبيريا', 'Liberia', '231', 'LR', 'LBR', 'غير معروف', 'Unknown'),
            ('a1d81dfa-9e4f-e911-80e1-00155d82d338', 'ليختنشتاين', 'Liechtenstein', '423', 'LI', 'LIE', 'غير معروف', 'Unknown'),
            ('41630b67-d1a0-e611-9481-00155d850a00', 'المملكة المتحدة البريطانية', 'United Kingdom', '44', 'GB', 'GBR', 'غير معروف', 'Unknown'),
            ('f6e11fe4-72d2-eb11-b823-00155d851526', 'غير محدد', 'Other', 'Unknown', 'GB', 'GBR', 'غير معروف', 'Unknown'),
            ('27b98f90-294a-e911-80c6-00155d85d41f', 'اوكرانيا', 'Ukraine', '380', 'UA', 'UKR', 'غير معروف', 'Unknown'),
            ('7a888a11-2a4a-e911-80c6-00155d85d41f', 'الصين', 'China', '86', 'CN', 'CHN', 'غير معروف', 'Unknown'),
            ('1e1e00da-374a-e911-80c6-00155d85d41f', 'ايرلندا', 'Ireland', '353', 'IE', 'IRL', 'غير معروف', 'Unknown'),
            ('16dd7eef-374a-e911-80c6-00155d85d41f', 'نيوزيلندا', 'New Zealand', '64', 'NZ', 'NZL', 'غير معروف', 'Unknown'),
            ('8224720e-384a-e911-80c6-00155d85d41f', 'بورتوريكو', 'Puerto Rico', '1-787', 'PR', 'PRI', 'غير معروف', 'Unknown'),
            ('4e2c6bb8-284a-e911-9501-00155d85d423', 'الصومال', 'Somalia', '252', 'SO', 'SOM', 'غير معروف', 'Unknown'),
            ('6abada36-294a-e911-9501-00155d85d423', 'فنزويلا', 'Venezuela', '58', 'VE', 'VEN', 'غير معروف', 'Unknown'),
            ('4de00b50-294a-e911-9501-00155d85d423', 'ماليزيا', 'Malaysia', '60', 'MY', 'MYS', 'غير معروف', 'Unknown'),
            ('68c8eadf-374a-e911-9501-00155d85d423', 'بلجيكا', 'Belgium', '32', 'BE', 'BEL', 'غير معروف', 'Unknown'),
            ('b401c0fe-374a-e911-9501-00155d85d423', 'كازاخستان', 'Kazakhstan', '7', 'KZ', 'KAZ', 'غير معروف', 'Unknown'),
            ('95e90227-9f4f-e911-9501-00155d85d423', 'مالطا', 'Malta', '356', 'MT', 'MLT', 'غير معروف', 'Unknown'),
            ('fc663846-9f4f-e911-9501-00155d85d423', 'موزمبيق', 'Mozambique', '258', 'MZ', 'MOZ', 'غير معروف', 'Unknown'),
            ('9a7dd568-9f4f-e911-9501-00155d85d423', 'نيبال', 'Nepal', '977', 'NP', 'NPL', 'غير معروف', 'Unknown'),
            ('e10c3c78-9f4f-e911-9501-00155d85d423', 'النيجر', 'Niger', '227', 'NE', 'NER', 'غير معروف', 'Unknown'),
            ('5c992fb8-9f4f-e911-9501-00155d85d423', 'كينيا', 'Kenya', '254', 'KE', 'KEN', 'غير معروف', 'Unknown'),
            ('0e80ebd8-9f4f-e911-9501-00155d85d423', 'صربيا', 'Serbia', '381', 'RS', 'SRB', 'غير معروف', 'Unknown');
        ")->execute();
        $this->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250309_222433_create_countries_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250309_222433_create_countries_table cannot be reverted.\n";

        return false;
    }
    */
}
