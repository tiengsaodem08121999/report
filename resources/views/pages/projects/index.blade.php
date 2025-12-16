@extends('layout.body')
@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('projects.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Project Name</label>
                                            <input type="text" name="project_name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-4">
                                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="px-0 text-muted">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-0 text-muted">
                                                    Menbers
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projectAll as $project)
                                                <tr>
                                                    <td>
                                                        {{ $project->project_name }}
                                                    </td>
                                                    <td>
                                                        @foreach ($project->members as $member)
                                                            <form action="{{ route('project.deleteMember') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="member_id"
                                                                    value="{{ $member->id }}">
                                                                <div>
                                                                    <button type="submit" class="btn"> <i
                                                                            class="fa-regular fa-trash-can"></i>
                                                                    </button>
                                                                    {{ $member->name }}
                                                                </div>
                                                            </form>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Design and Developed by <a href="#"
                            class="pe-1 text-primary text-decoration-underline">Wrappixel.com</a> Distributed by <a
                            href="https://themewagon.com" target="_blank">ThemeWagon</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
