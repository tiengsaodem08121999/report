@extends('layout.body')
@push('style')
    <style>
        .report-title {
            max-width: 600px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush
@section('content')

    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if (session('report_id'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ 'https://redmine.splus-software.com/issues/' . session('report_id') }}<br>
                                {{ 'em gui report ngày ' . now()->format('d/m/Y') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">Report {{ now()->format('d-m-Y') }}</h4>
                                </div>
                                <div class="ms-auto mt-3 mt-md-0">
                                    <form action="{{ route('report.index') }}" method="get" class="d-flex">
                                        @foreach (request()->query() as $key => $value)
                                            @if ($key !== 'date')
                                                <input type="hidden" name="{{ $key }}"
                                                    value="{{ $value }}">
                                            @endif
                                        @endforeach
                                        <input type="date" name="date"
                                            value="{{ request()->get('date') ?? date('Y-m-d') }}" class="form-control me-2">
                                        <button class="btn btn-outline-success me-2" type="submit">Search</button>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            Logtime
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-0 text-muted text-center">
                                                Developed
                                            </th>
                                            <th scope="col" class="px-0 text-muted text-center">
                                                Task
                                            </th>
                                            <th scope="col" class="px-0 text-center text-muted">
                                                Status
                                            </th>
                                            <th scope="col" class="px-0 text-muted text-center">
                                                Hours
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($memberForReports as $member)
                                            <tr>
                                                <td class="px-0">
                                                    {{ $member }}
                                                </td>
                                                @foreach ($reports as $develop => $dailyReport)
                                                    @if ($develop == $member)
                                                        @php
                                                            $developKey = null;
                                                            foreach ($members as $dev) {
                                                                if ($dev->name == $develop) {
                                                                    $developKey = $dev->key;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <td class="px-0">
                                                            @foreach ($dailyReport as $report)
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="ms-2 text-truncate-title d-flex align-items-center">
                                                                        <h6 class="mb-0 text-truncate report-title">
                                                                            {{ $report['title'] }}</h6>
                                                                        @if ($developKey)
                                                                            <form action="{{ route('logtime.delete') }}"
                                                                                id="form_delete_spent_time" method="POST"
                                                                                class="d-inline">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $report['id'] }}">
                                                                                <input type="hidden" name="dev"
                                                                                    value="{{ $developKey }}">
                                                                                <div class="mb-1 text-break">
                                                                                    <button type="submit" class="btn">
                                                                                        <i
                                                                                            class="fa-solid fa-trash trash-action"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($dailyReport as $report)
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-2 text-truncate-title">
                                                                        <h6 class="mb-0">{{ $report['status'] }}</h6>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            {{ collect($dailyReport)->sum('hours') }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                    data-bs-target="#confirmLogtimeModal">
                                    Create Report
                                </button>
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

    <!-- Modal logtime -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('logtime.store') }}" method="POST" class="modal-contents">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Logtime</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="task_id" class="form-label">Task ID</label>
                            <input type="text" class="form-control" id="task_id" name="task_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="task_id" class="form-label">Spent on</label>
                            <input type="date" class="form-control" id="spent_on" name="spent_on"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="task_id" class="form-label">User </label>
                            <select name="key" id="user" class="form-select" required>
                                @foreach ($members as $dev)
                                    <option value="{{ $dev->key }}">{{ $dev->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hours" class="form-label">Spent Time (hours)</label>
                            <input type="number" class="form-control" value="8" id="hours" name="hours"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Activity</label>
                            <select name="activity_id" class="form-select" required>
                                <option value="15">01_Study</option>
                                <option value="8">02_Design</option>
                                <option value="10" selected>03_Coding</option>
                                <option value="9">04_Unit Test</option>
                                <option value="17">05_Integration Test</option>
                                <option value="11">06_User Acceptance Test</option>
                                <option value="16">07_Review (code, doc)</option>
                                <option value="24">08_Correction (fix bug, doc)</option>
                                <option value="12">09_Translation</option>
                                <option value="14">10_Meeting</option>
                                <option value="20">11_Training</option>
                                <option value="31">12_System Test</option>
                                <option value="23">99_Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Logtime</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm modal -->
    <div class="modal fade" id="confirmLogtimeModal" tabindex="-1" aria-labelledby="confirmLogtimeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmLogtimeModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to create report?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('report.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="date" value="{{ request()->get('date') ?? date('Y-m-d') }}">
                        <input type="hidden" name="project" value="{{ request()->get('project') }}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // document.addEventListener("DOMContentLoaded", function () {
        //     var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        //     myModal.show();
        // });
    </script>
@endpush
