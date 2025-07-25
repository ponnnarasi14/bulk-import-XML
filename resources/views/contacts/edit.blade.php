@extends('layouts.app')
@section('title', 'Edit Customer Contact Details')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Contacts</h1>
            <a href="{{ route('contacts.create') }}" class="btn btn-success mb-3">
                Add New Contact
            </a>
            <a href="{{ route('contacts.index') }}" class="btn btn-success mb-3">
                List  Contact
            </a>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contacts.update', $contact->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-md-4">
                    <label> Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label> Contact Number </label>
                    <input type="text" class="form-control" id="phone" name="phone"  value="{{ old('phone', $contact->phone) }}" required>
                </div>
                <div class="form-group col-md-4" style="margin-top: 10px;">
                <button type="submit">Update</button>
                <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection