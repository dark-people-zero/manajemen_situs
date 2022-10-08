<div>
    <div class="card mt-3 card-success">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0 pb-0">Data Users</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control form-control-sm" placeholder="Search..." type="search">
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm">Add Data</a>
                </div>
            </div>
            <div class="mt-4">
                <table class="table table-bordered dataTable border-primary">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Access</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count() > 0)
                            <tr>
                                <td>Admin</td>
                                <td>admin</td>
                                <td>
                                    <span class="badge badge-primary">All Access</span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="text-info me-2">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="text-danger">
                                        <i class="fe fe-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>No matching records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    <span>Showing 1 to 10 of 57 entries</span>
                </div>
                <div>
                    <ul class="pagination pagination-sm pagination-primary mg-sm-b-0">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">
                                <i class="icon ion-ios-arrow-back"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0);">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">
                                <i class="icon ion-ios-arrow-forward"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
      </div>
</div>
