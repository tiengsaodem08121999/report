@extends('layout.body')
@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('members.store') }}" method="post" id="memberForm">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="key">Key</label>
                                            <input type="text" name="key" id="key" class="form-control">
                                            @error('key')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="key">Project</label>
                                            <select name="project_id" id="project_id" class="form-control">
                                                <option value="">Select Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->project_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                                                <th scope="col" class="px-0 text-muted">
                                                    project
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
                                                    <td class="px-0">{{ data_get($member, 'project.project_name', '') }}
                                                    </td>
                                                    <td class="px-0">
                                                        <i class="fa-regular fa-pen-to-square edit-member"
                                                            data-id={{ $member->id }}></i>
                                                        <i class="fa-solid fa-trash-can delete-member"
                                                            data-id={{ $member->id }}></i>
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
    <script>
        $(document).on('click', '.edit-member', function() {
            let memberId = $(this).data('id');

            $('#name').val($(this).closest('tr').find('td:eq(0)').text().trim());
            $('#key').val($(this).closest('tr').find('td:eq(1)').text().trim());

            let projectName = $(this).closest('tr').find('td:eq(2)').text().trim();
            $('#project_id option').each(function() {
                $(this).prop('selected', $(this).text().trim() === projectName);
            });

            let updateUrl = "{{ route('members.update', ':id') }}".replace(':id', memberId);
            $('#memberForm').attr('action', updateUrl);
          
            $('button[type=submit]').text('Update');
            $('#memberForm').append('<button type="button" id="cancelEdit" class="btn btn-danger mt-2">Cancel</button>');
        });
        $(document).on('click', '#cancelEdit', function() {
            $('#name').val('');
            $('#key').val('');
            $('#project_id').val('');
            $('#memberForm').attr('action', "{{ route('members.store') }}");
            $('button[type=submit]').text('Create');
            $(this).remove();
        });
    </script>
@endpush
