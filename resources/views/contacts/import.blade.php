@extends('layouts.app')
@section('title', 'Import XML')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Contacts</h1>
           
            <a href="{{ route('contacts.index') }}" class="btn btn-success mb-3">
                list  Contact
            </a>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contacts.import.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-4">
                    <label>Import User Contact</label>
                    <input type="file" class="form-control" name="xml_file" accept=".xml" required>
                    <small class="form-text text-muted">Upload an XML file with contacts data (max 2MB)</small>
                </div>
                <div class="form-group col-md-4">
                    <button type="submit">Import XML</button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

