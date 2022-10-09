@section('styles')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

<div>
    <div class="card mt-3 card-success">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0 pb-0">Data Users</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control form-control-sm" placeholder="Search..." type="search" wire:model="search" >
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formUser">Add Data</a>
                </div>
            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="search"></div>
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
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->username}}</td>
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
                            @endforeach
                        @else
                            <tr>
                                <td>No matching records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $data->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Form User Modal -->
    <div class="modal fade" id="formUser" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content chat border-0">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title">Form add users</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label>Akses Menu</label>
                            <table class="table table-bordered dataTable border-primary">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-start">Accees Menu</th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-create">
                                                    <label for="all-create" class="custom-control-label mt-1">C</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-read">
                                                    <label for="all-read" class="custom-control-label mt-1">R</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-update">
                                                    <label for="all-update" class="custom-control-label mt-1">U</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-delete">
                                                    <label for="all-delete" class="custom-control-label mt-1">D</label>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td class="text-start">User</td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-create">
                                                    <label for="checkbox-user-create" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-read">
                                                    <label for="checkbox-user-read" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-update">
                                                    <label for="checkbox-user-update" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-delete">
                                                    <label for="checkbox-user-delete" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="text-center">
                                        <td class="text-start">Situs</td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-create">
                                                    <label for="checkbox-situs-create" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-read">
                                                    <label for="checkbox-situs-read" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-update">
                                                    <label for="checkbox-situs-update" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-delete">
                                                    <label for="checkbox-situs-delete" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="d-flex align-items-center">
                                <span class="me-2">Access Site</span>
                                <span class="badge badge-primary">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="d-flex SumoSelect-group">
                                <select class="form-control SlectBox" placeholder="Please select one site.">
                                    @foreach ($situs as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    <option disabled selected ></option>
                                </select>
                                <button class="btn br-ts-0 br-bs-0 SumoSelect-group-action" type="button" data-bs-toggle="collapse" href="#collSite-0">
                                    <i class="fe fe-eye"></i>
                                    <i class="fe fe-eye-off"></i>
                                </button>

                            </div>
                        </div>
                        <div class="collapse" id="collSite-0">
                            Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <script>
        $(".SlectBox").SumoSelect({
            csvDispCount: 3,
            selectAll: !0,
            search: !0,
            searchText: "Enter here.",
            okCancelInMulti: !0,
            captionFormatAllSelected: "Yeah, OK, so everything.",
        })
    </script>

@endsection
