@extends('layouts.app')
@section('title', 'Create Customer Contact Details')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Contacts</h1>
            <a href="{{ route('contacts.create') }}" class="btn btn-success mb-3">
                Add New Contact
            </a>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}">
                </div>
                <div class="form-group col-md-4">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" name="phone" placeholder="Enter Contact No" value="{{ old('phone') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <button type="submit">Submit</button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection