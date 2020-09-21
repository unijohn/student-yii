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
                    'form_field'    => $this->integer()->notNull(),     // select, checkbox, radio
                    'type'          => $this->integer()->notNull(),     // TYPE_ITEM_ACTIVE, TYPE_ITEM_HIDDEN
                    'type_str'      => $this->string(64)->notNull(),    // is_active, is_hidden
                    'description'   => $this->string(64)->notNull(),    // 'Active', 'Inactive', 'Visible', 'Hidden'
                    'value'         => $this->integer(),
                    'value_str'     => $this->string(64)->notNull(),
                    
                    'is_active'     => $this->integer()->notNull(),
                    'is_visible'    => $this->integer()->notNull(),
                    
                    'order_by'      => $this->integer()->notNull(),
                                   
                    'created_at'    => $this->integer()->notNull(),
                    'updated_at'    => $this->integer(),
                    'deleted_at'    => $this->integer(),
                ],
                $this->_tableOptions
            );
         
            $this->createIndex('idx_FormFields_form_field', self::getTblFormFieldsName(), 'form_field');
        }
        
        $columns   = [ 'form_field', 'type', 'type_str', 'description', 'value_str', 'value', 'is_active', 'is_visible', 'order_by', 'created_at' ];

        $fieldRows =
        [
            // form_field
            [
                self::TYPE_FIELD_NOT_SET, self::TYPE_ITEM_FORM_FIELD, 'Form-Field', 'Select Form Field Type', '', self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_NOT_SET, self::TYPE_ITEM_FORM_FIELD, 'Form-Field', 'Select / Dropdown',      '', self::TYPE_FIELD_SELECT,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_NOT_SET, self::TYPE_ITEM_FORM_FIELD, 'Form-Field', 'Checkbox',               '', self::TYPE_FIELD_CHECKBOX, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_NOT_SET, self::TYPE_ITEM_FORM_FIELD, 'Form-Field', 'Radio',                  '', self::TYPE_FIELD_RADIO,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
        
            // is_active
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'Is-Active', 'Select Status', '', self::TYPE_PROMPT_DEFAULT,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'Is-Active', 'Active',        '', self::STATUS_ACTIVE,         self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_ACTIVE, 'Is-Active', 'Inactive',      '', self::STATUS_INACTIVE,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            
            // is_hidden
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISIBLE, 'Is-Visible', 'Select Status', '', self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISIBLE, 'Is-Visible', 'Visible',       '', self::STATUS_VISIBLE,      self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISIBLE, 'Is-Visible', 'Hidden',        '', self::STATUS_HIDDEN,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            
            // us_citizen
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'US-Citizen', 'Select US Citizenship Status', '', self::TYPE_PROMPT_DEFAULT,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'US-Citizen', 'No',                           '', self::CITIZEN_US_NO,         self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_US_CITIZEN, 'US-Citizen', 'Yes',                          '', self::CITIZEN_US_YES,        self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            
            // visa_type
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'Visa-Type', 'Select Visa Status', '',  self::TYPE_PROMPT_DEFAULT,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'Visa-Type', 'Not Applicable', '',      self::VISA_NO,              self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'Visa-Type', 'F-1',            '',      self::VISA_F1,              self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'Visa-Type', 'F-2',            '',      self::VISA_F2,              self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_VISA_TYPE, 'Visa-Type', 'F-3',            '',      self::VISA_F3,              self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            
            // term
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Select Semester',   '',  self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Not Set',           '',  self::TERM_NOT_SET,        self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Spring',            '',  self::TERM_SPRING,         self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Maymester',         '',  self::TERM_MAYMESTER,      self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Summer',            '',  self::TERM_SUMMER,         self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'First Session',     '',  self::TERM_SESSION_ONE,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 6, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Second Session',    '',  self::TERM_SESSION_TWO,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 7, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_TERM, 'Term', 'Fall',              '',  self::TERM_FALL,           self::STATUS_ACTIVE, self::STATUS_VISIBLE, 8, $created_at,
            ],
            
            // month_two
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'Select Month',    '',  self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'Not Set',         '',  self::MONTH_TWO_NOT_SET,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'January',         '',  self::MONTH_TWO_JAN,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'February',        '',  self::MONTH_TWO_FEB,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'March',           '',  self::MONTH_TWO_MAR,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'April',           '',  self::MONTH_TWO_APR,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 6, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'May',             '',  self::MONTH_TWO_MAY,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 7, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'June',            '',  self::MONTH_TWO_JUN,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 8, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'July',            '',  self::MONTH_TWO_JUL,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 9, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'August',          '',  self::MONTH_TWO_AUG,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 10, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'September',       '',  self::MONTH_TWO_SEPT,      self::STATUS_ACTIVE, self::STATUS_VISIBLE, 11, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'October',         '',  self::MONTH_TWO_OCT,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 12, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'November',        '',  self::MONTH_TWO_NOV,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 13, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_MONTH_TWO, 'Calendar-Month-Two', 'December',        '',  self::MONTH_TWO_DEC,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 14, $created_at,
            ],
            
            // skill_strength
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'Select Strength',   '', self::TYPE_PROMPT_DEFAULT,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'Not Set',           '', self::SKILL_STR_NOT_SET,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'None',              '', self::SKILL_STR_NONE,       self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'Beginner',          '', self::SKILL_STR_BEGIN,      self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'Intermediate',      '', self::SKILL_STR_INTERMED,   self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_SKILL_STRENGTH, 'Skill-Strength', 'Expert',            '', self::SKILL_STR_EXPERT,     self::STATUS_ACTIVE, self::STATUS_VISIBLE, 6, $created_at,
            ],
            
            // pref_ranking
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', 'Select Preference',  '', self::TYPE_PROMPT_DEFAULT,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', 'Not Set',            '', self::PREF_NOT_SET,         self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '1',                  '', self::PREF_ONE,             self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '2',                  '', self::PREF_TWO,             self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '3',                  '', self::PREF_THREE,           self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '4',                  '', self::PREF_FOUR,            self::STATUS_ACTIVE, self::STATUS_VISIBLE, 6, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '5',                  '', self::PREF_FIVE,            self::STATUS_ACTIVE, self::STATUS_VISIBLE, 7, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '6',                  '', self::PREF_SIX,             self::STATUS_ACTIVE, self::STATUS_VISIBLE, 8, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '7',                  '', self::PREF_SEVEN,           self::STATUS_ACTIVE, self::STATUS_VISIBLE, 9, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_PREFERENCE_RANK, 'Pref-Ranking', '8',                  '', self::PREF_EIGHT,           self::STATUS_ACTIVE, self::STATUS_VISIBLE, 10, $created_at,
            ],
            
            // document
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_DOCUMENT, 'Document', 'Select Document Type',      '',  self::TYPE_PROMPT_DEFAULT, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_DOCUMENT, 'Document', 'Not Set',                   '',  self::DOCUMENT_NOT_SET,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_DOCUMENT, 'Document', 'Personal Statement',        '',  self::DOCUMENT_PERS_STMT,  self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_DOCUMENT, 'Document', 'Essay',                     '',  self::DOCUMENT_ESSAY,      self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_DOCUMENT, 'Document', 'Letter of Recommendation',  '',  self::DOCUMENT_LTR_REQ,    self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
        ];

        $this->batchInsert(self::getTblFormFieldsName(), $columns, $fieldRows);
        
        $fieldRows =
        [
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Select Country of Citizenship', 'ZZZZ', '-1', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Not Applicable', 'AAAA', '0', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Åland Islands', 'AX', '1', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Afghanistan', 'AF', '2', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Albania', 'AL', '3', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Algeria', 'DZ', '4', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 6, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'American Samoa', 'AS', '5', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 7, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Andorra', 'AD', '6', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 8, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Angola', 'AO', '7', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 9, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Anguilla', 'AI', '8', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 10, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Antarctica', 'AQ', '9', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 254, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Antigua and Barbuda', 'AG', '10', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 11, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Argentina', 'AR', '11', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 12, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Armenia', 'AM', '12', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 13, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Aruba', 'AW', '13', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 14, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Australia', 'AU', '14', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 15, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Austria', 'AT', '15', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 16, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Azerbaijan', 'AZ', '16', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 17, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bahamas', 'BS', '17', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 18, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bahrain', 'BH', '18', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 19, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bangladesh', 'BD', '19', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 20, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Barbados', 'BB', '20', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 21, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Belarus', 'BY', '21', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 22, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Belgium', 'BE', '22', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 23, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Belize', 'BZ', '23', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 24, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Benin', 'BJ', '24', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 25, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bermuda', 'BM', '25', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 26, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bhutan', 'BT', '26', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 27, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bolivia', 'BO', '27', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 28, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bosnia and Herzegovina', 'BA', '28', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 29, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Botswana', 'BW', '29', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 30, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bouvet Island', 'BV', '30', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 31, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Brazil', 'BR', '31', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 32, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'British Indian Ocean Territory', 'IO', '32', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 33, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'British Virgin Islands', 'VG', '33', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 34, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Brunei', 'BN', '34', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 35, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Bulgaria', 'BG', '35', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 36, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Burkina Faso', 'BF', '36', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 37, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Burundi', 'BI', '37', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 38, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cambodia', 'KH', '38', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 39, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cameroon', 'CM', '39', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 40, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Canada', 'CA', '40', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 41, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cape Verde', 'CV', '41', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 42, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cayman Islands', 'KY', '42', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 43, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Central African Republic', 'CF', '43', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 44, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Chad', 'TD', '44', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 45, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Chile', 'CL', '45', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 46, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'China', 'CN', '46', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 47, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Christmas Island', 'CX', '47', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 48, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cocos [Keeling] Islands', 'CC', '48', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 49, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Colombia', 'CO', '49', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 50, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Comoros', 'KM', '50', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 51, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Congo - Brazzaville', 'CG', '51', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 52, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Congo - Kinshasa', 'CD', '52', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 53, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cook Islands', 'CK', '53', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 54, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Costa Rica', 'CR', '54', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 55, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Croatia', 'HR', '55', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 56, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cuba', 'CU', '56', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 57, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Cyprus', 'CY', '57', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 58, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Czech Republic', 'CZ', '58', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 59, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Côte d’Ivoire', 'CI', '59', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 60, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Denmark', 'DK', '60', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 61, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Djibouti', 'DJ', '61', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 62, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Dominica', 'DM', '62', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 63, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Dominican Republic', 'DO', '63', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 64, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'East Germany', 'DD', '64', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 65, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Ecuador', 'EC', '65', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 66, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Egypt', 'EG', '66', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 67, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'El Salvador', 'SV', '67', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 68, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Equatorial Guinea', 'GQ', '68', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 69, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Eritrea', 'ER', '69', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 70, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Estonia', 'EE', '70', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 71, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Ethiopia', 'ET', '71', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 72, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Falkland Islands', 'FK', '72', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 73, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Faroe Islands', 'FO', '73', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 74, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Fiji', 'FJ', '74', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 75, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Finland', 'FI', '75', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 76, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'France', 'FR', '76', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 77, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'French Guiana', 'GF', '77', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 78, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'French Polynesia', 'PF', '78', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 79, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'French Southern Territories', 'TF', '79', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 80, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Gabon', 'GA', '80', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 81, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Gambia', 'GM', '81', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 82, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Georgia', 'GE', '82', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 83, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Germany', 'DE', '83', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 84, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Ghana', 'GH', '84', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 85, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Gibraltar', 'GI', '85', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 86, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Greece', 'GR', '86', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 87, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Greenland', 'GL', '87', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 88, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Grenada', 'GD', '88', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 89, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guadeloupe', 'GP', '89', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 90, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guam', 'GU', '90', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 91, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guatemala', 'GT', '91', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 92, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guernsey', 'GG', '92', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 93, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guinea', 'GN', '93', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 94, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guinea-Bissau', 'GW', '94', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 95, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Guyana', 'GY', '95', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 96, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Haiti', 'HT', '96', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 97, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Heard Island and McDonald Islands', 'HM', '97', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 98, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Honduras', 'HN', '98', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 99, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Hong Kong SAR China', 'HK', '99', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 100, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Hungary', 'HU', '100', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 101, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Iceland', 'IS', '101', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 102, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'India', 'IN', '102', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 103, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Indonesia', 'ID', '103', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 104, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Iran', 'IR', '104', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 105, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Iraq', 'IQ', '105', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 106, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Ireland', 'IE', '106', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 107, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Isle of Man', 'IM', '107', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 108, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Israel', 'IL', '108', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 109, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Italy', 'IT', '109', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 110, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Jamaica', 'JM', '110', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 111, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Japan', 'JP', '111', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 112, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Jersey', 'JE', '112', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 113, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Jordan', 'JO', '113', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 114, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Kazakhstan', 'KZ', '114', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 115, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Kenya', 'KE', '115', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 116, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Kiribati', 'KI', '116', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 117, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Kuwait', 'KW', '117', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 118, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Kyrgyzstan', 'KG', '118', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 119, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Laos', 'LA', '119', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 120, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Latvia', 'LV', '120', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 121, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Lebanon', 'LB', '121', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 122, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Lesotho', 'LS', '122', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 123, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Liberia', 'LR', '123', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 124, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Libya', 'LY', '124', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 125, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Liechtenstein', 'LI', '125', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 126, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Lithuania', 'LT', '126', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 127, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Luxembourg', 'LU', '127', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 128, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Macau SAR China', 'MO', '128', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 129, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Macedonia', 'MK', '129', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 130, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Madagascar', 'MG', '130', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 131, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Malawi', 'MW', '131', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 132, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Malaysia', 'MY', '132', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 133, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Maldives', 'MV', '133', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 134, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mali', 'ML', '134', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 135, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Malta', 'MT', '135', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 136, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Marshall Islands', 'MH', '136', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 137, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Martinique', 'MQ', '137', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 138, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mauritania', 'MR', '138', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 139, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mauritius', 'MU', '139', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 140, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mayotte', 'YT', '140', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 141, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Metropolitan France', 'FX', '141', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 142, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mexico', 'MX', '142', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 143, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Micronesia', 'FM', '143', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 144, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Moldova', 'MD', '144', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 145, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Monaco', 'MC', '145', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 146, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mongolia', 'MN', '146', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 147, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Montenegro', 'ME', '147', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 148, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Montserrat', 'MS', '148', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 149, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Morocco', 'MA', '149', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 150, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Mozambique', 'MZ', '150', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 151, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Myanmar [Burma]', 'MM', '151', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 152, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Namibia', 'NA', '152', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 153, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Nauru', 'NR', '153', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 154, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Nepal', 'NP', '154', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 155, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Netherlands', 'NL', '155', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 156, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Netherlands Antilles', 'AN', '156', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 157, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Neutral Zone', 'NT', '157', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 158, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'New Caledonia', 'NC', '158', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 159, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'New Zealand', 'NZ', '159', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 160, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Nicaragua', 'NI', '160', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 161, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Niger', 'NE', '161', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 162, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Nigeria', 'NG', '162', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 163, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Niue', 'NU', '163', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 164, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Norfolk Island', 'NF', '164', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 165, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'North Korea', 'KP', '165', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 166, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Northern Mariana Islands', 'MP', '166', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 167, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Norway', 'NO', '167', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 168, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Oman', 'OM', '168', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 169, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Pakistan', 'PK', '169', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 170, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Palau', 'PW', '170', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 171, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Palestinian Territories', 'PS', '171', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 172, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Panama', 'PA', '172', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 173, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Papua New Guinea', 'PG', '173', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 174, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Paraguay', 'PY', '174', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 175, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'People\s Democratic Republic of Yemen', 'YD', '175', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 176, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Peru', 'PE', '176', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 177, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Philippines', 'PH', '177', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 178, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Pitcairn Islands', 'PN', '178', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 179, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Poland', 'PL', '179', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 180, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Portugal', 'PT', '180', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 181, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Puerto Rico', 'PR', '181', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 182, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Qatar', 'QA', '182', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 183, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Romania', 'RO', '183', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 184, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Russia', 'RU', '184', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 185, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Rwanda', 'RW', '185', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 186, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Réunion', 'RE', '186', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 187, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Barthélemy', 'BL', '187', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 188, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Helena', 'SH', '188', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 189, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Kitts and Nevis', 'KN', '189', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 190, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Lucia', 'LC', '190', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 191, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Martin', 'MF', '191', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 192, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Pierre and Miquelon', 'PM', '192', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 193, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saint Vincent and the Grenadines', 'VC', '193', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 194, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Samoa', 'WS', '194', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 195, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'San Marino', 'SM', '195', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 196, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Saudi Arabia', 'SA', '196', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 197, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Senegal', 'SN', '197', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 198, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Serbia', 'RS', '198', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 199, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Serbia and Montenegro', 'CS', '199', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 200, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Seychelles', 'SC', '200', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 201, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Sierra Leone', 'SL', '201', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 202, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Singapore', 'SG', '202', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 203, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Slovakia', 'SK', '203', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 204, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Slovenia', 'SI', '204', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 205, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Solomon Islands', 'SB', '205', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 206, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Somalia', 'SO', '206', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 207, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'South Africa', 'ZA', '207', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 208, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'South Georgia and the South Sandwich Islands', 'GS', '208', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 209, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'South Korea', 'KR', '209', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 210, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Spain', 'ES', '210', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 211, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Sri Lanka', 'LK', '211', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 212, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Sudan', 'SD', '212', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 213, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Suriname', 'SR', '213', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 214, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Svalbard and Jan Mayen', 'SJ', '214', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 215, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Swaziland', 'SZ', '215', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 216, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Sweden', 'SE', '216', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 217, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Switzerland', 'CH', '217', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 218, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Syria', 'SY', '218', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 219, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'São Tomé and Príncipe', 'ST', '219', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 220, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Taiwan', 'TW', '220', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 221, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tajikistan', 'TJ', '221', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 222, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tanzania', 'TZ', '222', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 223, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Thailand', 'TH', '223', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 224, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Timor-Leste', 'TL', '224', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 225, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Togo', 'TG', '225', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 226, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tokelau', 'TK', '226', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 227, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tonga', 'TO', '227', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 228, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Trinidad and Tobago', 'TT', '228', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 229, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tunisia', 'TN', '229', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 230, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Turkey', 'TR', '230', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 231, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Turkmenistan', 'TM', '231', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 232, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Turks and Caicos Islands', 'TC', '232', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 233, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Tuvalu', 'TV', '233', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 234, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'U.S. Minor Outlying Islands', 'UM', '234', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 235, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'U.S. Virgin Islands', 'VI', '235', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 236, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Uganda', 'UG', '236', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 237, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Ukraine', 'UA', '237', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 238, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Union of Soviet Socialist Republics', 'SU', '238', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 239, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'United Arab Emirates', 'AE', '239', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 240, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'United Kingdom', 'GB', '240', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 241, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'United States', 'US', '241', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 242, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Uruguay', 'UY', '242', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 243, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Uzbekistan', 'UZ', '243', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 244, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Vanuatu', 'VU', '244', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 245, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Vatican City', 'VA', '245', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 246, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Venezuela', 'VE', '246', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 247, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Vietnam', 'VN', '247', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 248, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Wallis and Futuna', 'WF', '248', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 249, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Western Sahara', 'EH', '249', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 250, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Yemen', 'YE', '250', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 251, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Zambia', 'ZM', '251', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 252, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_CITIZEN_OTHER, 'Citizen-Other', 'Zimbabwe', 'ZW', '252', self::STATUS_ACTIVE, self::STATUS_VISIBLE, 253, $created_at,
            ],
        ];

        $this->batchInsert(self::getTblFormFieldsName(), $columns, $fieldRows);
        
        $fieldRows =
        [
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', 'Select Year', '', -1, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 1, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2030', '2030', 2030, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 2, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2029', '2029', 2029, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 3, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2028', '2028', 2028, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 4, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2027', '2027', 2027, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 5, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2026', '2026', 2026, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 6, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2025', '2025', 2025, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 7, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2024', '2024', 2024, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 8, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2023', '2023', 2023, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 9, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2022', '2022', 2022, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 10, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2021', '2021', 2021, self::STATUS_INACTIVE, self::STATUS_HIDDEN, 11, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2020', '2020', 2020, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 12, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2019', '2019', 2019, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 13, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2018', '2018', 2018, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 14, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2017', '2017', 2017, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 15, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2016', '2016', 2016, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 16, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2015', '2015', 2015, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 17, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2014', '2014', 2014, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 18, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2013', '2013', 2013, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 19, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2012', '2012', 2012, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 20, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2011', '2011', 2011, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 21, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2010', '2010', 2010, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 22, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2009', '2009', 2009, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 23, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2008', '2008', 2008, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 24, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2007', '2007', 2007, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 25, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2006', '2006', 2006, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 26, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2005', '2005', 2005, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 27, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2004', '2004', 2004, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 28, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2003', '2003', 2003, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 29, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2002', '2002', 2002, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 30, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2001', '2001', 2001, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 31, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '2000', '2000', 2000, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 32, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1999', '1999', 1999, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 33, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1998', '1998', 1998, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 34, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1997', '1997', 1997, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 35, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1996', '1996', 1996, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 36, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1995', '1995', 1995, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 37, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1994', '1994', 1994, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 38, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1993', '1993', 1993, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 39, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1992', '1992', 1992, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 40, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1991', '1991', 1991, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 41, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1990', '1990', 1990, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 42, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1989', '1989', 1989, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 43, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1988', '1988', 1988, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 44, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1987', '1987', 1987, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 45, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1986', '1986', 1986, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 46, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1985', '1985', 1985, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 47, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1984', '1984', 1984, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 48, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1983', '1983', 1983, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 49, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1982', '1982', 1982, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 50, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1981', '1981', 1981, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 51, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1980', '1980', 1980, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 52, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1979', '1979', 1979, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 53, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1978', '1978', 1978, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 54, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1977', '1977', 1977, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 55, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1976', '1976', 1976, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 56, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1975', '1975', 1975, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 57, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1974', '1974', 1974, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 58, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1973', '1973', 1973, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 59, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1972', '1972', 1972, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 60, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1971', '1971', 1971, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 61, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1970', '1970', 1970, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 62, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1969', '1969', 1969, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 63, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1968', '1968', 1968, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 64, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1967', '1967', 1967, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 65, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1966', '1966', 1966, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 66, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1965', '1965', 1965, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 67, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1964', '1964', 1964, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 68, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1963', '1963', 1963, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 69, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1962', '1962', 1962, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 70, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1961', '1961', 1961, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 71, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1960', '1960', 1960, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 72, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1959', '1959', 1959, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 73, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1958', '1958', 1958, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 74, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1957', '1957', 1957, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 75, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1956', '1956', 1956, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 76, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1955', '1955', 1955, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 77, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1954', '1954', 1954, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 78, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1953', '1953', 1953, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 79, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1952', '1952', 1952, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 80, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1951', '1951', 1951, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 81, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1950', '1950', 1950, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 82, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1949', '1949', 1949, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 83, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1948', '1948', 1948, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 84, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1947', '1947', 1947, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 85, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1946', '1946', 1946, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 86, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1945', '1945', 1945, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 87, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1944', '1944', 1944, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 88, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1943', '1943', 1943, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 89, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1942', '1942', 1942, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 90, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1941', '1941', 1941, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 91, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1940', '1940', 1940, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 92, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1939', '1939', 1939, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 93, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1938', '1938', 1938, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 94, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1937', '1937', 1937, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 95, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1936', '1936', 1936, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 96, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1935', '1935', 1935, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 97, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1934', '1934', 1934, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 98, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1933', '1933', 1933, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 99, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1932', '1932', 1932, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 100, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1931', '1931', 1931, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 101, $created_at,
            ],
            [
                self::TYPE_FIELD_SELECT, self::TYPE_ITEM_YEAR_FOUR, 'Calendar-Year-Four', '1930', '1930', 1930, self::STATUS_ACTIVE, self::STATUS_VISIBLE, 102, $created_at,
            ],
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
