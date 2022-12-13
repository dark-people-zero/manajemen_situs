@section('title', 'Data User')

@section('styles')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

<div id="content-user">
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
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formUser" wire:click="addAccessSite">Add Data</a>
                </div>
            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="search"></div>
                <table class="table table-bordered dataTable border-primary">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Access Site</th>
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
                                        @if (in_array($item->role->role_id, [1,4]))
                                            <span class="badge badge-primary">All Access</span>
                                        @else
                                            @foreach ($item->aksesSitus as $val)
                                                <span class="badge badge-primary">{{$val->situs->name}}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $edit = true;
                                            $hapus = true;
                                            if (in_array($item->id_role, [1,2]) && Auth::user()->id_role != 1) {
                                                $edit = false;
                                                $hapus = false;
                                            }
                                        @endphp
                                        @if ($edit)
                                            <a href="javascript:void(0);" class="text-info me-2" wire:click="setUpdate({{$item->id}})" data-bs-toggle="modal" data-bs-target="#formUser">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        @endif
                                        @if ($hapus)
                                            <a href="javascript:void(0);" class="text-danger" wire:click="deleteConfirm({{$item->id}})">
                                                <i class="fe fe-trash"></i>
                                            </a>
                                        @endif
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
    <div class="modal fade" id="formUser" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content chat border-0">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title">Form {{$methodUpdate ? 'update' : 'add'}} users</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button" wire:click="resetForm">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalFormUser">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" wire:model="name" value="{{$name}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Enter Username" wire:model="username" value="{{$username}}">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div wire:ignore>
                                <select class="form-control @error('role') is-invalid @enderror" id="role" placeholder="Please select one role">
                                    @foreach ($roleAll as $item)
                                        @if ($item->id == 1 && Auth::user()->role->role_id == 1)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                    <option selected disabled="disabled"></option>
                                </select>
                            </div>
                            @error('role')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if (count($menuAccessDefault) > 0)
                            <div id="aksesMenuAndSite">
                                <div class="form-group">
                                    <label>
                                        Menu Access
                                    </label>
                                    @error('aksesMenu')
                                        <span class="invalid-feedback d-block mt-0 mb-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="d-flex">
                                        @foreach ($menuAccessDefault as $i => $item)
                                            <div class="checkbox me-2">
                                                <div class="custom-checkbox custom-control cursor-pointer cursor-pointer">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input menuAccess" id="menuAccess{{$i}}" wire:change="ChangeMenuAccess({{$i}})" {{$item['status'] ? 'checked' : ''}}>
                                                    <label for="menuAccess{{$i}}" class="custom-control-label cursor-pointer">{{$item['name']}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-flex align-items-center">
                                        <span class="me-2">Site Access</span>
                                        <span class="badge badge-primary cursor-pointer" wire:click="addAccessSite">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </label>
                                    @error('aksesSite')
                                        <span class="invalid-feedback d-block mt-0 mb-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @foreach ($dataAccessSite as $i => $item)
                                    @livewire('access-site', [
                                        'index' => $item,
                                        'data' => isset($accessSite[$item]) ? $accessSite[$item] : null
                                    ], key($i))

                                    @error($item)
                                        <span class="invalid-feedback d-block mt-0 my-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @endforeach
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-header border-top">
                    <a href="#" class="btn btn-primary" wire:click="saveData">Simpan</a>
                </div>

                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="saveData"></div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <script src="{{ asset('assets/js-pages/page-user.js') }}"></script>

@endsection
