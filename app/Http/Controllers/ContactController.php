<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\ContactCustomValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ContactController extends Controller
{

    public function index(Request $request)
    {
        $custom_fields = CustomField::all();
        return view('contacts.index', compact('custom_fields'));
    }

    public function list(Request $request)
    {
        $query = Contact::query();
        if ($request->name) $query->where('name', 'like', '%' . $request->name . '%');
        if ($request->email) $query->where('email', 'like', '%' . $request->email . '%');
        if ($request->gender) $query->where('gender', $request->gender);

        $contacts = $query->with('customValues')->get();
        return view('contacts.list', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'gender' => 'required|in:Male,Female',
            'profile_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'additional_file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:4096',
            'custom.*' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }



        $data = $request->only(['name', 'email', 'phone', 'gender']);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_uploads'), $imageName);
            $data['profile_image'] = 'profile_uploads/' . $imageName;
        }

        if ($request->hasFile('additional_file')) {
            $image = $request->file('additional_file');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('additional_file'), $imageName);
            $data['additional_file'] = 'additional_file/' . $imageName;
        }

        $contact = Contact::create($data);

        if ($request->custom && is_array($request->custom)) {
            foreach ($request->custom as $fid => $val) {
                ContactCustomValue::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $fid,
                    'value' => $val,
                ]);
            }
        }

        return response()->json(['success' => true, 'value' => 1]);
    }

    public function edit($id)
    {
        $contact = Contact::with('customValues')->findOrFail($id);
        return response()->json(['contact' => $contact]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'gender' => 'required|in:Male,Female',
            'profile_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'additional_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:4096',
            'custom.*' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'gender']);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_uploads'), $imageName);
            $data['profile_image'] = 'profile_uploads/' . $imageName;
        }

        if ($request->hasFile('additional_file')) {
            $file = $request->file('additional_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('additional_file'), $fileName);
            $data['additional_file'] = 'additional_file/' . $fileName;
        }

        $contact->update($data);

        if ($request->custom && is_array($request->custom)) {
            foreach ($request->custom as $fid => $val) {
                ContactCustomValue::updateOrCreate(
                    ['contact_id' => $contact->id, 'custom_field_id' => $fid],
                    ['value' => $val]
                );
            }
        }

        return response()->json(['success' => true, 'value' => 2]);
    }

    public function destroy($id)
    {

        $contact = Contact::findOrFail($id);

        if ($contact->profile_image && File::exists(public_path($contact->profile_image))) {
            File::delete(public_path($contact->profile_image));
        }

        if ($contact->additional_file && File::exists(public_path($contact->additional_file))) {
            File::delete(public_path($contact->additional_file));
        }

        ContactCustomValue::where('contact_id', $contact->id)->delete();

        $contact->delete();

        return response()->json(['success' => true, 'message' => 'Contact deleted successfully.']);
    }
}
