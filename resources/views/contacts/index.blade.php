@extends('layouts.app')
@section('title', 'list Customer contact Details')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Contacts Manager</h1>
            <a href="{{ route('contacts.create') }}" class="btn btn-success mb-3">
                Add Contact
            </a>
            <a href="{{ route('contacts.import.form') }}" class="btn btn-success mb-3">
                Import XML
            </a>
            
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                        <tr>
                            <td>{{ $loop->iteration + ($contacts->currentPage() - 1) * $contacts->perPage() }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>
                                <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> Show
                                </a>
                                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No contacts found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection