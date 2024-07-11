<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailNotification;

class FormController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a paginated list of forms ordered by creation date.
     *
     * Retrieves forms, including soft deleted ones, ordered by creation date
     * in descending order and paginates them with 5 forms per page. Renders
     * the 'admin.form' view with the paginated list of forms.
     *
     * @return \Illuminate\View\View The rendered view displaying the forms list.
     * 
     * @author Seethal Prasad
     */
    public function formsList()
    {
        $forms = Form::withTrashed()->orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.form', ['forms' => $forms]);
    }
    /**
     * Display the form creation page.
     *
     * This method returns the view 'admin.create', which contains form creation. It is typically used to create a new form.
     *
     * @return \Illuminate\View\View The view for creating a new resource.
     * 
     * @author seethal prasad
     */
    public function create()
    {
        return view('admin.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * This method validates the incoming request data, creates a new form record
     * in the database, and saves associated form fields. It also dispatches an
     * email notification job for each form field creation. After processing,
     * it redirects the user to the 'dashboard' page with a status message.
     * Note: Uncomment the email notification job code below, and ensure valid Mailtrap credentials are set in the .env file. Run 'php artisan queue:work' to process queued jobs.
     * @param \Illuminate\Http\Request $request The HTTP request instance containing form data.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the dashboard with status message.
     * 
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     * @throws \Throwable If an error occurs during database operations.
     * 
     * @author Seethal Prasad
     */
    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'form_name' => ['required'],
            'fieldTypes.*' => ['required'],
            'questions.*' => ['required'],
            'options.*' => ['required']
        ]);
         // Get the authenticated user
        $user = Auth::guard('web')->user();
        try {
            // Create a new form record in the database
            $form = Form::create([
                'name' => $request->form_name,
                'created_by' => $user->id,
            ]);
            // Save associated form fields
            foreach ($request->fieldTypes as $index => $fieldType) {
                $formField = new FormField();
                $formField->form_id = $form->id;
                $formField->input_element_id = $fieldType;
                $formField->question = $request->questions[$index];
                $formField->option_fields = ($request->options !== null && !empty($request->options[$index])) 
                ? json_encode(explode(',', $request->options[$index])) : null;
                $formField->is_required = !empty($request->is_required[$index]) ? true : false;
                $formField->save();
                // Dispatch an email notification job - Start
                // Define the email details
                // $recipientEmail = 'test@gmail.com';
                // $subject = 'Test Email Subject';
                // $message = 'Test Email Message.';
                // $fromEmail = 'test@gmail.com'; 
                // $fromName = 'Test User'; 
                // SendEmailNotification::dispatch($recipientEmail, $subject, $message, $fromEmail, $fromName);
                // Dispatch an email notification job - End
            }

            $status = 'success';
            $msg = 'Form: ' . $request->form_name . ' has been published!!';
        } catch (\Throwable $th) {
            $status = 'fail';
            $msg = 'Form: ' . $request->form_name . ' could not be published!!';
        }

        return redirect('dashboard')->with('status', $status)->with('msg', $msg);
    }
    /**
     * Edit form data based on submitted request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Seethal Prasad
     */
    public function editData(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'form_name' => ['required'],
            'fieldTypes.*' => ['required'],
            'questions.*' => ['required'],
            'options.*' => ['required']
        ]);
        // Get the authenticated user
        $user = Auth::guard('web')->user();
        try {
            $form = Form::find($request->hidden_form_id)->update([
                'name' => $request->form_name,
                'created_by' => $user->id,
            ]);
            
            foreach ($request->fieldTypes as $index => $fieldType) {
                // Retrieve form field ID from request
                $formFieldId=$request->form_field_id[$index];
                
               // Check if the form field exists
               $formField = FormField::find($formFieldId);

               if ($formField) {
                // Update existing form field
                 $formField->form_id = $request->hidden_form_id;
                 $formField->input_element_id = $fieldType;
                 $formField->question = $request->questions[$index];
                 $formField->option_fields = ($request->options !== null && !empty($request->options[$index])) ? json_encode(explode(',', $request->options[$index])) : null;
                 $formField->is_required = !empty($request->is_required[$index]) ? true : false;
                 $formFieldUpdate = $formField->update();
               } else {
                // Create new form field if ID doesn't exist
                $formField = new FormField();
                $formField->form_id = $request->hidden_form_id;
                $formField->input_element_id = $fieldType;
                    
                $formField->question = $request->questions[$index];
                $formField->option_fields = ($request->options !== null && !empty($request->options[$index])) 
                    ? json_encode(explode(',', $request->options[$index])) : null;
                $formField->is_required = !empty($request->is_required[$index]) ? true : false;
                // Save the new form field
                $formField->save();
               }
            }

            $status = 'success';
            $msg = 'Form: ' . $request->form_name . ' has been published!!';
        } catch (\Throwable $th) {
            $status = 'fail';
            $msg = 'Form: ' . $request->form_name . ' could not be published!!';
        }
        return redirect('dashboard')->with('status', $status)->with('msg', $msg);
    }
    /**
     * Display the form for editing a specific form and its associated fields.
     *
     * @param int $id The ID of the form to edit
     * @return \Illuminate\View\View
     * @author Seethal Prasad
     */
    public function edit($id)
    {
        // Retrieve the form data including its associated form fields and input elements
        $formData = Form::with(['formFields.inputElements'])->find($id);
        return view('admin.edit',['formData' => $formData]);
    }
    /**
     * Permanently delete a form and its associated data from the database.
     *
     * @param int $id The ID of the form to be deleted permanently
     * @return \Illuminate\Http\RedirectResponse
     * @author Seethal Prasad
     */
    public function destroyPermanently($id)
    {
        // Find the form with the given ID, including soft-deleted forms
        Form::withTrashed()->find($id)->forceDelete();
        return back()->with('success', 'Form deleted successfully!!');
    }
    /**
     * Display the welcome view with a paginated list of forms, including soft-deleted forms.
     * @return \Illuminate\View\View
     * @author Seethal Prasad
     */
    public function welcomeView()
    {
        // Retrieve a paginated list of forms, including soft-deleted forms, ordered by creation date in descending order
        $forms = Form::withTrashed()->orderBy('created_at', 'DESC')->paginate(5);
        return view('welcome', ['forms' => $forms]);
    }
}
