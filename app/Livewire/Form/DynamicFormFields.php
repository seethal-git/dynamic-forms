<?php

namespace App\Livewire\Form;
use App\Models\InputElement;
use Livewire\Component;

class DynamicFormFields extends Component
{
    public $createdFieldsArr = [];
    public $availableFieldsType;
    /**
     * The mount method is called when the component is initialized.
     * It retrieves the available input elements and initializes a form field.
     *
     * @return void
     */
    public function mount()
    {
        // Retrieve all available input elements and store them in the component property
        $this->availableFieldsType = InputElement::get();
        // Initialize a new form field
        $this->createField();
    }
    public function render()
    {
        return view('livewire.form.dynamic-form-fields');
    }
    /**
     * Fetch the template for a specified field type and store it in the created fields array.
     *
     * @param int $fieldType The ID of the field type to fetch the template for
     * @param int $indexVal The index value to store the fetched template in the created fields array
     * @return void
     */
    public function fetchTemplate($fieldType, $indexVal)
    {
        // Find the desired field type from the available fields collection
        $desiredNode = $this->availableFieldsType->filter(
            fn ($k) =>
            $k->id == $fieldType
        )->first();
        // Store the fetched template information in the created fields array
        $this->createdFieldsArr[$indexVal] = [
            'type' => $fieldType,
            'template' => $desiredNode->template,
            'has_options' => $desiredNode->has_options
        ];
    }
    /**
     * Add a new field to the created fields array in a Livewire component.
     *
     * @return void
     */
    public function createField()
    {
       // Add a new field to the end of the created fields array with default values
        $this->createdFieldsArr[array_key_last($this->createdFieldsArr)+1] = [
            'type' => $this->availableFieldsType[0]->id,
            'template' => $this->availableFieldsType[0]->template,
            'has_options' => $this->availableFieldsType[0]->has_options
        ];
        
    }
    /**
     * Delete a field from the createdFieldsArr array based on the provided index value.
     *
     * @param int $indexVal The index value of the field to delete
     * @return void
     */
    public function deleteField($indexVal)
    {
        // Remove the field from the createdFieldsArr array using unset
        unset($this->createdFieldsArr[$indexVal]);
        // Reindex the array elements to ensure continuous numeric keys
        array_values($this->createdFieldsArr);
    }
}
