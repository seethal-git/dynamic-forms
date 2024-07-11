<?php

namespace App\Livewire\Form;
use App\Models\InputElement;
use App\Models\FormField;
use Livewire\Component;

class EditDynamicFormFields extends Component
{
    public $createdFieldsArr = [];
    public $availableFieldsType;
    public $formId;
    public $inputElements;
    public function mount($formId = null)
    {
        $this->formId = $formId;
        // Fetch existing form fields for editing
        if ($this->formId) {
            $this->fetchFormFields();
        }
        // Fetch available input elements
        $this->availableFieldsType = InputElement::get();
        // Create initial field if none exists
        if (empty($this->createdFieldsArr)) {
            $this->createField();
        }
    }
    /**
     * Fetch form fields associated with the current form ID, including their input elements.
     * Populate the $createdFieldsArr with fetched form fields data.
     *
     * @return void
     */
    public function fetchFormFields()
    {
        // Fetch form fields with their input elements
        $formFields = FormField::where('form_id', $this->formId)
                               ->whereHas('inputElements')
                               ->with('inputElements')
                               ->get();

        // Initialize $createdFieldsArr with existing form fields data
        foreach ($formFields as $index => $formField) {
            $this->createdFieldsArr[$index + 1] = [
                'type' => $formField->inputElements->id,
                'template' => $formField->inputElements->template,
                'has_options' => $formField->inputElements->has_options,
                'question' => $formField->question,
                'options' => $formField->option_fields,
                'is_required' => (bool) $formField-> is_required, 
                'form_field_id' => $formField->id,
            ];
        }
    }
    public function render()
    {
        return view('livewire.form.edit-dynamic-form-fields');
    }
    /**
     * Fetches the template information for a specified field type and assigns it to the created fields array.
     *
     * @param int $fieldType The ID of the desired field type
     * @param int $indexVal The index value for the created fields array
     * @return void
     */
    public function fetchTemplate($fieldType, $indexVal)
    {
        // Retrieve the desired field type node from availableFieldsType collection
        $desiredNode = $this->availableFieldsType->firstWhere('id', $fieldType);
        // If the desired node is found, assign its template and options availability to the created fields array
        if ($desiredNode) {
            $this->createdFieldsArr[$indexVal]['type'] = $fieldType;
            $this->createdFieldsArr[$indexVal]['template'] = $desiredNode->template;
            $this->createdFieldsArr[$indexVal]['has_options'] = $desiredNode->has_options;
            $this->createdFieldsArr[$indexVal]['question'] = $desiredNode->question;
            $this->createdFieldsArr[$indexVal]['options'] = $desiredNode->options;
            $this->createdFieldsArr[$indexVal]['is_required'] = $desiredNode->is_required;
            $this->createdFieldsArr[$indexVal]['form_field_id'] = $desiredNode->form_field_id;
        }
    }
    /**
     * Add a new field to the dynamically created fields array.
     *
     * This method initializes a new field with default values based on the first available field type.
     * Each field is represented by an associative array in the `createdFieldsArr`.
     *
     * @return void
     */
    public function createField()
    {
        if ($this->availableFieldsType->isNotEmpty()) {
            $this->createdFieldsArr[array_key_last($this->createdFieldsArr) + 1] = [
                'type' => $this->availableFieldsType[0]->id,
                'template' => $this->availableFieldsType[0]->template,
                'has_options' => $this->availableFieldsType[0]->has_options,
                'question' => '', 
                'options' => '',
                'is_required' => false,
                'form_field_id' => '',
            ];
        }
    }
    /**
     * Delete a form field based on the provided index value and form field ID.
     *
     * @param int $indexVal The index value of the field to delete
     * @param int $formFieldId The ID of the form field to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteField($indexVal,$formFieldId)
    {
        if($formFieldId!=0){
            FormField::find($formFieldId)->delete();
             // Trigger Livewire refresh after deletion
         return redirect()->to(route('form.edit', ['id' => $this->formId]));
        }else{
            // Remove the created field from the array
            unset($this->createdFieldsArr[$indexVal]);
            // Re-index the array elements
            array_values($this->createdFieldsArr);
        }
        
    }
   
}
