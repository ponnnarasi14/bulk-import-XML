<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::paginate(10);
     
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|unique:contacts,phone|max:20'
        ]);
        try
        {
            Contact::create([
                'name'  => $validated['name'],
                'phone' => $validated['phone']
            ]);
            return redirect()->route('contacts.index')->with(['success' => 'Contact Added Successfully']);
          
        }
        catch(\Exception $e)
        {
            return redirect()-back()->withInput()->with('error', 'faild to add contact:' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
       $contact = Contact::findOrFail($id);
       return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:contacts,phone,'.$id
        ]);
        try{
            $contact = Contact::findOrFail($id);

            $contact->update($validated);

            return redirect()->route('contacts.index')->with(['success', 'Contact Updated Successfully']);
        }catch(\Exception $e)
        {
            return redirect()->back()->withInput()->with(['error', 'Failed to Update Contact:' .$e->getMessage()]);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->route('contacts.index')->with('success', 'Contact Deleted Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to Delete contact:' .$e->getMessage());
        }
       
    }

    public function showImportForm()
    {
        return view('contacts.import');
    }

    public function import(Request $request)
    {
        // Step 1: Basic Validation
        $validator = Validator::make($request->all(), [
            'xml_file' => [
                'required',
                'file',
                'max:2048', // 2MB
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    if ($extension !== 'xml') {
                        $fail('The file must be a .xml file.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Step 2: XML Content Validation
        try {
            $xml = simplexml_load_file($request->file('xml_file')->path());
            
            if ($xml === false) {
                throw new \Exception('Invalid XML format');
            }

            if (!isset($xml->contact)) {
                throw new \Exception('XML must contain <contact> elements');
            }

            // Step 3: Process Contacts
            $importedCount = 0;
            $duplicateCount = 0;
            $errors = [];

            foreach ($xml->contact as $index => $contact) {
                try {
                    // Validate individual contact
                    if (empty($contact->name) || empty($contact->phone)) {
                        throw new \Exception("Missing name or phone in contact #" . ($index + 1));
                    }

                    if (Contact::where('phone', $contact->phone)->exists()) {
                        $duplicateCount++;
                        continue; // Skip without error
                    }

                    Contact::create([
                        'name' => (string)$contact->name,
                        'phone' => (string)$contact->phone,
                    ]);

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }

            // Prepare response
            if ($importedCount > 0) {
                $message = "Successfully imported {$importedCount} contacts";
                
                if (!empty($errors)) {
                    $message .= ". Issues found: " . implode(', ', array_slice($errors, 0, 3));
                    if (count($errors) > 3) {
                        $message .= ' and '.(count($errors) - 3).' more';
                    }
                }
                
                return redirect()->route('contacts.index')
                    ->with('success', $message);
            }

            return back()->with('error', 'No contacts imported. '.implode(', ', $errors));

        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }
}
