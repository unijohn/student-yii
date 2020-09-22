<?php

namespace tests\unit\models;

use app\models\FormFields;

class FormFieldsTest extends \Codeception\Test\Unit
{
    public $justRight   = "Just Right Enough";
    public $tooLong     = "Tooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo";
      
        
    public function testAddFormField()
    {
        $formField = new FormFields();
       
        $formField->scenario     = FormFields::SCENARIO_INSERT;

        // Everything correct
        $formField->form_field  = FormFields::TYPE_FIELD_SELECT;
        $formField->type        = FormFields::FIELD_ACTIVE;
        $formField->type_str    = "Is-Active";
        $formField->description = $this->justRight;
        $formField->value       = 2;
        $formField->value_str   = "";
        
        $formField->is_active   = FormFields::STATUS_ACTIVE;
        $formField->is_visible  = FormFields::STATUS_VISIBLE;

        expect_that($saveResult = $formField->save());
        
        // Type is below MIN
        $formField->type        = FormFields::FIELD_FORM_MIN - 100;
        expect_not($saveResult  = $formField->save());
    
        // Type is above MAX
        $formField->type        = FormFields::FIELD_FORM_MAX + 100;
        expect_not($saveResult  = $formField->save());

        // Type is just right
        $formField->type        = FormFields::FIELD_TERM;
        expect($saveResult      = $formField->save());
        
        // Form_Field is below MIN
        $formField->form_field  = FormFields::TYPE_FIELD_MIN - 100;
        expect_not($saveResult  = $formField->save());

        // Form_Field is above MAX
        $formField->type        = FormFields::FIELD_VISIBLE;
        $formField->form_field  = FormFields::TYPE_FIELD_MAX + 100;
        expect_not($saveResult  = $formField->save());
        
        // Form_Field is just right
        $formField->form_field  = FormFields::TYPE_FIELD_SELECT;
        expect($saveResult      = $formField->save());

        // type_str is too long
        $formField->type_str = $this->tooLong;
        expect_not($saveResult  = $formField->save());
        
        // type_str is just right
        $formField->type_str = $this->justRight;
        expect($saveResult      = $formField->save());

        // value_str is too long
        $formField->value_str = $this->tooLong;
        expect_not($saveResult  = $formField->save());
        
        // type_str is just right
        $formField->value_str = $this->justRight;
        expect($saveResult      = $formField->save());
        
        // Description is too long
        $formField->description = $this->tooLong;
        expect_not($saveResult  = $formField->save());
        
        // Description is just right
        $formField->description = $this->justRight;
        expect($saveResult      = $formField->save());
        
        // is_active is below MIN
        $formField->is_active   = FormFields::STATUS_VISIBLE_MIN - 100;
        expect_not($saveResult  = $formField->save());
        
        // is_active is above MAX
        $formField->is_active   = FormFields::STATUS_ACTIVE_MAX + 100;
        expect_not($saveResult  = $formField->save());

        // is_active is wrong kind of data
        $formField->is_active   = $this->tooLong;
        expect_not($saveResult  = $formField->save());
        
        // is_active is just right
        $formField->is_active   = FormFields::STATUS_ACTIVE;
        expect($saveResult      = $formField->save());
        
        // is_visible is below MIN
        $formField->is_visible  = FormFields::STATUS_ACTIVE_MIN + 100;
        expect_not($saveResult  = $formField->save());
        
        // is_visible is above MAX
        $formField->is_visible  = FormFields::STATUS_ACTIVE_MAX + 100;
        expect_not($saveResult  = $formField->save());

        // is_active is wrong kind of data
        $formField->is_visible   = $this->tooLong;
        expect_not($saveResult  = $formField->save());

        // is_visible is just right
        $formField->is_visible  = FormFields::STATUS_HIDDEN;
        expect($saveResult      = $formField->save());
    }
    
    public function testExistsFieldByProperties()
    {
        //public static function existsFieldByProperties($form_field = -1, $type = -1, $type_str = '', $description = '', $value_str = '', $value = -1)
    
        /** Valid: expect_that **/
        // All valid values
        $this->assertTrue($formField = FormFields::existsFieldByProperties(1, 1, 'Form-Field', 'Checkbox', '', 3) );

        // All valid values except $value
        expect_that($formField = FormFields::existsFieldByProperties(1, 1, 'Form-Field', 'Radio'));
        
        // Valid values except $type_str, $value
        $this->assertTrue($formField = FormFields::existsFieldByProperties(2, 2, '', 'Active'));
        
        /** NOT Valid: expect_not **/
        // No values
        expect_not($formField = FormFields::existsFieldByProperties());
        
        // No valid values
        expect_not($formField = FormFields::existsFieldByProperties(1000, 1000, 'ERROR-HERE', 'ERROR-HERE', 'ERROR-HERE', -1000));
        
        // Wrong $description for that type
        expect_not($formField = FormFields::existsFieldByProperties(1, 3, '', 'Active'));
    }
    
    
    public function testGetFieldOptions()
    {
        //  public static function getFieldOptions($form_field = -1, $type = -1, $type_str = "", $prompt = false)
        
        /** Valid: expect_that **/
        // All valid values
        expect_that($formField = FormFields::getFieldOptions(1, 1, 'Form-Field', true));
        
        // All valid values except $type_str
        expect_that($formField = FormFields::getFieldOptions(1, 1, '', true));
        
        // All valid values except $type
        expect_that($formField = FormFields::getFieldOptions(1, -1, 'Form-Field', false));
        
        /** NOT Valid: expect_not **/
        // No values
        expect_not($formField = FormFields::getFieldOptions());
        
        // No valid values
        expect_not($formField = FormFields::existsFieldByProperties(1000, -1000, 'ERROR-HERE', 2020));
        
        // Wrong $type_str for that type
        expect_not($formField = FormFields::existsFieldByProperties(0, 1, 'Active', true));
        
        // Wrong data types everywhere
        expect_not($formField = FormFields::existsFieldByProperties('true', $this->tooLong, decoct(264), 'ERROR-HERE'));
    }
    
    
    public function testGetSelectOptions()
    {
        // getSelectOptions($type= -1, $type_str = "", $prompt = false)
        
        /** Valid: expect_that **/
        // All valid values
        expect_that($formField = FormFields::getSelectOptions(2, FormFields::IS_ACTIVE_TYPE_STR, true));
        
        // All valid values except $type_str
        expect_that($formField = FormFields::getSelectOptions(2, '', true));
        
        // All valid values except $type
        expect_that($formField = FormFields::getSelectOptions(-1, 'Visa-Type', false));

        // Wrong $type_str for that type BUT SQL logic is ( $type OR $type_str )
        expect_that($formField = FormFields::getSelectOptions(2, 'Term', false));
        
        /** NOT Valid: expect_not **/
        // No values
        expect_not($formField = FormFields::getSelectOptions());
        
        // No valid values
        expect_not($formField = FormFields::getSelectOptions(10000, "ERROR-HERE", true));
        
        // Wrong data types everywhere
        expect_not($formField = FormFields::getSelectOptions('true', decoct(264), 'ERROR-HERE'));
    }
    
    
    public function testGetFormFieldOptions()
    {
        // function getFormFieldOptions($type = -1, $type_str = "", $prompt = false)
        
        /** Valid: expect_that **/
        // All valid values
        expect_that($formField = FormFields::getFormFieldOptions(1, 'Form-Field', true));
        
        // All valid values except $type_str
        expect_that($formField = FormFields::getFormFieldOptions(1, '', false));
        
        // All valid values except $type
        expect_that($formField = FormFields::getFormFieldOptions(-1, 'Form-Field', true));

        /** NOT Valid: expect_not **/
        // No values
        expect_not($formField = FormFields::getFormFieldOptions());
        
        // No valid values
        expect_not($formField = FormFields::getFormFieldOptions(10000, "ERROR-HERE", false));
        
        // Wrong data types everywhere
        expect_not($formField = FormFields::getFormFieldOptions('true', decoct(264), 'ERROR-HERE'));
    }
    
    
    public function testMoveFormFields()
    {
        $row = FormFields::find()
            ->where(['id' => 7 ])
            ->one();
        
        // Starting position: id: 7
        // Is-Active, Active
        //
        // Start position: 2
        // Min position: 1
        // Max position: 3

        expect_that($row->movePrev());
        expect_not($row->movePrev());
        
        $this->assertTrue($row->getIsFirst());
        
        expect_that($row->moveNext());
        expect_that($row->moveNext());
        expect_not($row->moveNext());
        
        $this->assertTrue($row->getIsLast());

        expect_that($row->moveFirst());
        expect_that($row->moveLast());
        
        // Too far; invalid positioning
        expect_not($row->moveToPosition(3000));
    }
}
