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
          <div class="card-body">
            <div class="d-md-flex align-items-center">
              <div>
                <h4 class="card-title">Report {{now()->format('d-m-Y')}}</h4>
              </div>
              <div class="ms-auto mt-3 mt-md-0">
                <select class="form-select" aria-label="Default select example">
                  <option value="1">March 2025</option>
                  <option value="2">March 2025</option>
                  <option value="3">March 2025</option>
                </select>
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
                  @if(isset($reports))
                      @foreach ($reports as $develop => $dailyReport)
                        <tr>
                          <td class="px-0">
                            {{$develop}}
                          </td>
                          <td class="px-0">
                              @foreach ($dailyReport as $report)
                                  <div class="d-flex align-items-center">
                                      <div class="ms-2 text-truncate-title">
                                          <h6 class="mb-0 text-truncate report-title">{{$report['title']}}</h6>
                                      </div>
                                  </div>
                              @endforeach
                          </td>
                          <td>
                              @foreach ($dailyReport as $report)
                                  <div class="d-flex align-items-center">
                                      <div class="ms-2 text-truncate-title">
                                          <h6 class="mb-0">{{$report['status']}}</h6>
                                      </div>
                                  </div>
                              @endforeach
                          </td>
                          <td>
                              {{collect($dailyReport)->sum('hours')}}
                          </td>
                        </tr>
                      @endforeach
                    @endif
                      
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-6 px-6 text-center">
      <p class="mb-0 fs-4">Design and Developed by <a href="#"
          class="pe-1 text-primary text-decoration-underline">Wrappixel.com</a> Distributed by <a href="https://themewagon.com" target="_blank" >ThemeWagon</a></p>
    </div>
  </div>
</div>
@endsection