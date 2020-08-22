<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class M200821143444TblFormFields
 */
class m200821_143444_tbl_FormFields extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $created_at = $this->_time;
  
        if ($this->_db->getTableSchema(self::getTblFormFieldsName(), true) === null) {
            $this->createTable(
                self::getTblFormFieldsName(),
                [
                    'id'            => $this->primaryKey(),
                    'type'          => $this->integer()->notNull(),     // select, checkbox, radio
                    'grouping'      => $this->integer()->notNull(),     // TYPE_ITEM_ACTIVE, TYPE_ITEM_HIDDEN
                    'grouping_name' => $this->string(64)->notNull(),    // is_active, is_hidden
                    'description'   => $this->string(64)->notNull(),    // 'Active', 'Inactive', 'Visible', 'Hidden'
                    'value'         => $this->string(64),
                    'value_int'     => $this->integer(),
                    
                    'is_active'     => $this->integer()->notNull(),
                    'is_visible'    => $this->integer()->notNull(),
                                   
                    'created_at'    => $this->integer()->notNull(),
                    'updated_at'    => $this->integer(),
                    'deleted_at'    => $this->integer(),
                ],
                $this->_tableOptions
            );
         
            $this->createIndex('idx_FormFields_type', self::getTblFormFieldsName(), 'type');
        }
        
        $columns   = [ 'type', 'grouping', 'grouping_name', 'description', 'value', 'value_int', 'is_active', 'is_visible', 'created_at' ];

        $fieldRows =
        [
            // is_active
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'is_active', 'Select Status', '', self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'is_active', 'Inactive',      '', self::STATUS_INACTIVE, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'is_active', 'Active',        '', self::STATUS_ACTIVE,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            
            // is_hidden
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_HIDDEN, 'is_visible', 'Select Status', '', self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_HIDDEN, 'is_visible', 'Hidden',        '', self::STATUS_HIDDEN,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_HIDDEN, 'is_visible', 'Visible',       '', self::STATUS_VISIBLE,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            
            // us_citizen
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'us_citizen', 'Select US Citizenship Status', '',   self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'us_citizen', 'No',       '', self::CITIZEN_US_NO,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'us_citizen', 'Yes',      '', self::CITIZEN_US_YES, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            
            // visa_type
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'visa_type', 'Select Visa Status', '', self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'visa_type', 'Not Applicable', '', self::VISA_NO, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'visa_type', 'F-1',            '', self::VISA_F1, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'visa_type', 'F-2',            '', self::VISA_F2, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'visa_type', 'F-3',            '', self::VISA_F3, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
        ];
                
        $this->batchInsert(self::getTblFormFieldsName(), $columns, $fieldRows);
        
        $fieldRows =
        [
            // citizen_other
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Select Country of Citizenship', 'ZZZZ', -1, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Not Applicable', 'AAAA', 0, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Åland Islands', 'AX', 1, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Afghanistan', 'AF', 2, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Albania', 'AL', 3, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Algeria', 'DZ', 4, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'American Samoa', 'AS', 5, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Andorra', 'AD', 6, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Angola', 'AO', 7, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Anguilla', 'AI', 8, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Antarctica', 'AQ', 9, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Antigua and Barbuda', 'AG', 10, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Argentina', 'AR', 11, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Armenia', 'AM', 12, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Aruba', 'AW', 13, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Australia', 'AU', 14, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Austria', 'AT', 15, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Azerbaijan', 'AZ', 16, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bahamas', 'BS', 17, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bahrain', 'BH', 18, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bangladesh', 'BD', 19, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Barbados', 'BB', 20, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Belarus', 'BY', 21, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Belgium', 'BE', 22, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Belize', 'BZ', 23, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Benin', 'BJ', 24, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bermuda', 'BM', 25, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bhutan', 'BT', 26, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bolivia', 'BO', 27, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bosnia and Herzegovina', 'BA', 28, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Botswana', 'BW', 29, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bouvet Island', 'BV', 30, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Brazil', 'BR', 31, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'British Indian Ocean Territory', 'IO', 32, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'British Virgin Islands', 'VG', 33, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Brunei', 'BN', 34, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Bulgaria', 'BG', 35, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Burkina Faso', 'BF', 36, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Burundi', 'BI', 37, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cambodia', 'KH', 38, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cameroon', 'CM', 39, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Canada', 'CA', 40, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cape Verde', 'CV', 41, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cayman Islands', 'KY', 42, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Central African Republic', 'CF', 43, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Chad', 'TD', 44, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Chile', 'CL', 45, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'China', 'CN', 46, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Christmas Island', 'CX', 47, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cocos [Keeling] Islands', 'CC', 48, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Colombia', 'CO', 49, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Comoros', 'KM', 50, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Congo - Brazzaville', 'CG', 51, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Congo - Kinshasa', 'CD', 52, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cook Islands', 'CK', 53, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Costa Rica', 'CR', 54, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Croatia', 'HR', 55, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cuba', 'CU', 56, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Cyprus', 'CY', 57, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Czech Republic', 'CZ', 58, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Côte d’Ivoire', 'CI', 59, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Denmark', 'DK', 60, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Djibouti', 'DJ', 61, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Dominica', 'DM', 62, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Dominican Republic', 'DO', 63, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'East Germany', 'DD', 64, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Ecuador', 'EC', 65, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Egypt', 'EG', 66, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'El Salvador', 'SV', 67, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Equatorial Guinea', 'GQ', 68, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Eritrea', 'ER', 69, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Estonia', 'EE', 70, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Ethiopia', 'ET', 71, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Falkland Islands', 'FK', 72, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Faroe Islands', 'FO', 73, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Fiji', 'FJ', 74, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Finland', 'FI', 75, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'France', 'FR', 76, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'French Guiana', 'GF', 77, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'French Polynesia', 'PF', 78, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'French Southern Territories', 'TF', 79, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Gabon', 'GA', 80, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Gambia', 'GM', 81, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Georgia', 'GE', 82, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Germany', 'DE', 83, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Ghana', 'GH', 84, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Gibraltar', 'GI', 85, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Greece', 'GR', 86, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Greenland', 'GL', 87, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Grenada', 'GD', 88, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guadeloupe', 'GP', 89, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guam', 'GU', 90, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guatemala', 'GT', 91, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guernsey', 'GG', 92, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guinea', 'GN', 93, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guinea-Bissau', 'GW', 94, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Guyana', 'GY', 95, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Haiti', 'HT', 96, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Heard Island and McDonald Islands', 'HM', 97, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Honduras', 'HN', 98, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Hong Kong SAR China', 'HK', 99, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Hungary', 'HU', 100, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Iceland', 'IS', 101, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'India', 'IN', 102, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Indonesia', 'ID', 103, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Iran', 'IR', 104, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Iraq', 'IQ', 105, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Ireland', 'IE', 106, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Isle of Man', 'IM', 107, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Israel', 'IL', 108, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Italy', 'IT', 109, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Jamaica', 'JM', 110, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Japan', 'JP', 111, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Jersey', 'JE', 112, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Jordan', 'JO', 113, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Kazakhstan', 'KZ', 114, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Kenya', 'KE', 115, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Kiribati', 'KI', 116, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Kuwait', 'KW', 117, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Kyrgyzstan', 'KG', 118, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Laos', 'LA', 119, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Latvia', 'LV', 120, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Lebanon', 'LB', 121, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Lesotho', 'LS', 122, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Liberia', 'LR', 123, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Libya', 'LY', 124, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Liechtenstein', 'LI', 125, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Lithuania', 'LT', 126, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Luxembourg', 'LU', 127, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Macau SAR China', 'MO', 128, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Macedonia', 'MK', 129, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Madagascar', 'MG', 130, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Malawi', 'MW', 131, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Malaysia', 'MY', 132, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Maldives', 'MV', 133, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mali', 'ML', 134, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Malta', 'MT', 135, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Marshall Islands', 'MH', 136, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Martinique', 'MQ', 137, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mauritania', 'MR', 138, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mauritius', 'MU', 139, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mayotte', 'YT', 140, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Metropolitan France', 'FX', 141, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mexico', 'MX', 142, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Micronesia', 'FM', 143, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Moldova', 'MD', 144, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Monaco', 'MC', 145, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mongolia', 'MN', 146, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Montenegro', 'ME', 147, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Montserrat', 'MS', 148, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Morocco', 'MA', 149, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Mozambique', 'MZ', 150, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Myanmar [Burma]', 'MM', 151, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Namibia', 'NA', 152, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Nauru', 'NR', 153, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Nepal', 'NP', 154, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Netherlands', 'NL', 155, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Netherlands Antilles', 'AN', 156, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Neutral Zone', 'NT', 157, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'New Caledonia', 'NC', 158, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'New Zealand', 'NZ', 159, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Nicaragua', 'NI', 160, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Niger', 'NE', 161, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Nigeria', 'NG', 162, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Niue', 'NU', 163, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Norfolk Island', 'NF', 164, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'North Korea', 'KP', 165, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Northern Mariana Islands', 'MP', 166, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Norway', 'NO', 167, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Oman', 'OM', 168, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Pakistan', 'PK', 169, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Palau', 'PW', 170, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Palestinian Territories', 'PS', 171, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Panama', 'PA', 172, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Papua New Guinea', 'PG', 173, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Paraguay', 'PY', 174, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'People\s Democratic Republic of Yemen', 'YD', 175, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Peru', 'PE', 176, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Philippines', 'PH', 177, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Pitcairn Islands', 'PN', 178, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Poland', 'PL', 179, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Portugal', 'PT', 180, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Puerto Rico', 'PR', 181, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Qatar', 'QA', 182, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Romania', 'RO', 183, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Russia', 'RU', 184, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Rwanda', 'RW', 185, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Réunion', 'RE', 186, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Barthélemy', 'BL', 187, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Helena', 'SH', 188, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Kitts and Nevis', 'KN', 189, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Lucia', 'LC', 190, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Martin', 'MF', 191, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Pierre and Miquelon', 'PM', 192, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saint Vincent and the Grenadines', 'VC', 193, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Samoa', 'WS', 194, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'San Marino', 'SM', 195, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Saudi Arabia', 'SA', 196, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Senegal', 'SN', 197, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Serbia', 'RS', 198, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Serbia and Montenegro', 'CS', 199, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Seychelles', 'SC', 200, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Sierra Leone', 'SL', 201, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Singapore', 'SG', 202, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Slovakia', 'SK', 203, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Slovenia', 'SI', 204, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Solomon Islands', 'SB', 205, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Somalia', 'SO', 206, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'South Africa', 'ZA', 207, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'South Georgia and the South Sandwich Islands', 'GS', 208, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'South Korea', 'KR', 209, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Spain', 'ES', 210, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Sri Lanka', 'LK', 211, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Sudan', 'SD', 212, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Suriname', 'SR', 213, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Svalbard and Jan Mayen', 'SJ', 214, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Swaziland', 'SZ', 215, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Sweden', 'SE', 216, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Switzerland', 'CH', 217, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Syria', 'SY', 218, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'São Tomé and Príncipe', 'ST', 219, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Taiwan', 'TW', 220, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tajikistan', 'TJ', 221, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tanzania', 'TZ', 222, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Thailand', 'TH', 223, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Timor-Leste', 'TL', 224, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Togo', 'TG', 225, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tokelau', 'TK', 226, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tonga', 'TO', 227, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Trinidad and Tobago', 'TT', 228, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tunisia', 'TN', 229, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Turkey', 'TR', 230, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Turkmenistan', 'TM', 231, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Turks and Caicos Islands', 'TC', 232, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Tuvalu', 'TV', 233, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'U.S. Minor Outlying Islands', 'UM', 234, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'U.S. Virgin Islands', 'VI', 235, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Uganda', 'UG', 236, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Ukraine', 'UA', 237, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Union of Soviet Socialist Republics', 'SU', 238, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'United Arab Emirates', 'AE', 239, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'United Kingdom', 'GB', 240, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'United States', 'US', 241, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Uruguay', 'UY', 242, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Uzbekistan', 'UZ', 243, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Vanuatu', 'VU', 244, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Vatican City', 'VA', 245, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Venezuela', 'VE', 246, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Vietnam', 'VN', 247, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Wallis and Futuna', 'WF', 248, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Western Sahara', 'EH', 249, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Yemen', 'YE', 250, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Zambia', 'ZM', 251, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'citizen_other', 'Zimbabwe', 'ZW', 252, self::STATUS_ACTIVE, self::STATUS_VISIBLE, $created_at,
            ]
        ];

        $this->batchInsert(self::getTblFormFieldsName(), $columns, $fieldRows);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "M200821143444TblFormFields cannot be reverted.\n";

        $this->forceDropTable(self::getTblFormFieldsName());

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M200821143444TblFormFields cannot be reverted.\n";

        return false;
    }
    */
}
