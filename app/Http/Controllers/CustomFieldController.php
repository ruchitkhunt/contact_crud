<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomField;


class CustomFieldController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'field_name' => 'required|string',
            'field_type' => 'required'
        ]);

        CustomField::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Custom field added successfully!');
    }
}
