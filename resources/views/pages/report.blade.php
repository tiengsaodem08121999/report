@extends('layout.body')
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
                    <th scope="col" class="px-0 text-muted">
                      Assigned
                    </th>
                    <th scope="col" class="px-0 text-muted">Name</th>
                    <th scope="col" class="px-0 text-muted">
                      Priority
                    </th>
                    <th scope="col" class="px-0 text-muted text-end">
                      Budget
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-0">
                      <div class="d-flex align-items-center">
                        <img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40"
                          alt="flexy" />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">Sunil Joshi</h6>
                          <span class="text-muted">Web Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0">Elite Admin</td>
                    <td class="px-0">
                      <span class="badge bg-info">Low</span>
                    </td>
                    <td class="px-0 text-dark fw-medium text-end">
                      $3.9K
                    </td>
                  </tr>
                  <tr>
                    <td class="px-0">
                      <div class="d-flex align-items-center">
                        <img src="./assets/images/profile/user-5.jpg" class="rounded-circle" width="40"
                          alt="flexy" />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">
                            Andrew McDownland
                          </h6>
                          <span class="text-muted">Project Manager</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0">Real Homes WP Theme</td>
                    <td class="px-0">
                      <span class="badge text-bg-primary">Medium</span>
                    </td>
                    <td class="px-0 text-dark fw-medium text-end">
                      $24.5K
                    </td>
                  </tr>
                  <tr>
                    <td class="px-0">
                      <div class="d-flex align-items-center">
                        <img src="./assets/images/profile/user-6.jpg" class="rounded-circle" width="40"
                          alt="flexy" />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">
                            Christopher Jamil
                          </h6>
                          <span class="text-muted">SEO Manager</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0">MedicalPro WP Theme</td>
                    <td class="px-0">
                      <span class="badge bg-warning">Hight</span>
                    </td>
                    <td class="px-0 text-dark fw-medium text-end">
                      $12.8K
                    </td>
                  </tr>
                  <tr>
                    <td class="px-0">
                      <div class="d-flex align-items-center">
                        <img src="./assets/images/profile/user-7.jpg" class="rounded-circle" width="40"
                          alt="flexy" />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">Nirav Joshi</h6>
                          <span class="text-muted">Frontend Engineer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0">Hosting Press HTML</td>
                    <td class="px-0">
                      <span class="badge bg-danger">Low</span>
                    </td>
                    <td class="px-0 text-dark fw-medium text-end">
                      $2.4K
                    </td>
                  </tr>
                  <tr>
                    <td class="px-0">
                      <div class="d-flex align-items-center">
                        <img src="./assets/images/profile/user-8.jpg" class="rounded-circle" width="40"
                          alt="flexy" />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">Micheal Doe</h6>
                          <span class="text-muted">Content Writer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0">Helping Hands WP Theme</td>
                    <td class="px-0">
                      <span class="badge bg-success">Low</span>
                    </td>
                    <td class="px-0 text-dark fw-medium text-end">
                      $9.3K
                    </td>
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
          class="pe-1 text-primary text-decoration-underline">Wrappixel.com</a> Distributed by <a href="https://themewagon.com" target="_blank" >ThemeWagon</a></p>
    </div>
  </div>
</div>
@endsection