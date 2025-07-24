@extends('layouts.app')
@section('title', 'Show Customer Contact Details')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Show Customer Contact Details</h1>
            <a href="{{ route('contacts.index') }}" class="btn btn-success mb-3">
                Customer Contact List
            </a>
            <div class="form-group col-md-4">
                <label>Name : </label> {{ $contact->name }}
            </div>
            <div class="form-group col-md-4">
                <label>Phone : </label> {{ $contact->phone }}
            </div>
            <div class="form-group col-md-4">
                <label>Created : </label> {{ $contact->created_at->format('m/d/Y') }}
            </div>
            <div class="form-group col-md-4">
                <label>Updated : </label> {{$contact->updated_at->format('m/d/Y') }}
            </div>
            
        </div>
    </div>
</div>
@endsection