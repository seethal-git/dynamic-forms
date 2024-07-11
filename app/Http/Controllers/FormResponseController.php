<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class FormResponseController extends Controller
{
    /**
     * Display a specific form and its associated fields.
     *
     * @param Form $form The form model instance
     * @return \Illuminate\View\View
     * @author seethal prasad
     */
    public function index(Form $form)
    {
        // Retrieve the form data including its associated form fields based on the given form instance
        $formData = $form::with(['formFields'])->find($form->id);
        return view('form-show', ['formData' => $formData]);
    }
    /**
     * Handle the submission of form responses and store them in the database.
     *
     * @param Form $form The form model instance
     * @param \Illuminate\Http\Request $request The incoming request instance
     * @return \Illuminate\Http\RedirectResponse
     * @author seethal prasad
     */
    public function store(Form $form, Request $request)
    {
        // Retrieve the form data including its associated form fields based on the given form instance
        $form = $form::with(['formFields'])->find($form->id);
        // Initialize an array to hold validation rules
        $validationRules = [];
        foreach ($form->formFields as $formField) {
            $validationRules[$formField->inputElements->type . '.' . ($formField->id) . ''] = ($formField->is_required) ? ['required'] : [];
        }
        
        $request->validate($validationRules);
        $responseArr = [];
        foreach ($request->all() as $each) {
            if (is_array($each)) {
                foreach ($each as $field => $val) {
                    $question = $form->formFields->filter(
                        fn ($k) =>
                        $k->id == $field
                    )->first()->question;
                    $responseArr[$question] = $val;
                }
            }
        }
        try {
            FormResponse::create([
                'form_id' => $form->id,
                'responses' => json_encode($responseArr)
            ]);
        } catch (\Throwable $th) {
        }

        if($form->is_auth_required)
        {
            return redirect()->back()->with('success', 'Your response submitted successfully.');        }
       
    }
}
