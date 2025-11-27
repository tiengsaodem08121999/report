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
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('members.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="key">Key</label>
                                            <input type="text" name="key" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="key">Project</label>
                                            <select name="project_id" class="form-control" required>
                                                <option value="">Select Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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
                                                    Key
                                                </th>
                                                <th scope="col" class="px-0 text-muted text-end">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($members as $member)
                                                <tr>
                                                    <td class="px-0">{{ $member->name }}</td>
                                                    <td class="px-0">{{ $member->key }}</td>
                                                    <td class="px-0">
                                                        <a href="{{ route('members.edit', $member->id) }}"
                                                            class="btn btn-primary">Edit</a>
                                                        <a href="{{ route('members.destroy', $member->id) }}"
                                                            class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tr>
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
    @endsection
