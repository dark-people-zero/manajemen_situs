@section('title', 'Form Element')

@section('styles')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

<div id="content-form-element">
    <div class="card mt-3 card-success">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0 pb-0">Form Element</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control form-control-sm" placeholder="Search..." type="search" wire:model="search" >
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formElement" wire:click="showForm(true)">Add Data</a>
                </div>
            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="search"></div>
                <table class="table table-bordered dataTable border-primary">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Type</th>
                            <th>Placeholder</th>
                            <th class="text-center">Is Multiple</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count() > 0)
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            {{$item->typeElemen->name}}
                                        </span>
                                    </td>
                                    <td>{{$item->placeholder}}</td>
                                    <td class="text-center">
                                        <span class="badge badge-{{$item->is_multiple ? 'success' : 'danger'}}">
                                            <span class="op-7 text-white font-weight-bold">
                                                {{$item->is_multiple ? 'true' : 'false'}}
                                            </span>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="text-info me-2" wire:click="showForm(false,{{$item->id}})" data-bs-toggle="modal" data-bs-target="#formElement">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="text-danger" wire:click="deleteConfirm({{$item->id}})">
                                            <i class="fe fe-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No matching records found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $data->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Form User Modal -->
    <div class="modal fade" id="formElement" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content chat border-0">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title">{{$methodUpdate ? 'Update' : 'Add'}} Form Element</h6>
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
                            <label for="type">Type Element</label>
                            <div wire:ignore>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" placeholder="Please select one type">
                                    @foreach ($typeElement as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    <option selected disabled="disabled"></option>
                                </select>
                            </div>
                            @error('type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if ($type == 6)
                            <div class="form-group">
                                <label for="switch_on">Title Switch On</label>
                                <input type="text" class="form-control @error('switch_on') is-invalid @enderror" id="switch_on" placeholder="Enter Tittle Switch On" wire:model="switch_on" value="{{$switch_on}}">
                                @error('switch_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="switch_off">Title Switch Off</label>
                                <input type="text" class="form-control @error('switch_off') is-invalid @enderror" id="switch_off" placeholder="Enter Tittle Switch Off" wire:model="switch_off" value="{{$switch_off}}">
                                @error('switch_off')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        @if ($type == 3)
                            <div class="form-group">
                                <label for="option">Option</label>
                                <textarea id="option" class="form-control @error('option') is-invalid @enderror" placeholder="Enter option for select" style="font-size: 10px" wire:model="option">{{$option}}</textarea>
                                @error('option')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span>Example data:</span> <br>
                                <small>
                                    code => value, <br>
                                    code => value, <br>
                                    code => value, <br>
                                </small>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="placeholder">Placeholder</label>
                            <input type="text" class="form-control @error('placeholder') is-invalid @enderror" id="placeholder" placeholder="Enter Placeholder" wire:model="placeholder" value="{{$placeholder}}">
                            @error('placeholder')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <dic class="form-group">
                            <div class="checkbox me-2">
                                <div class="custom-checkbox custom-control cursor-pointer cursor-pointer">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input menuAccess" id="menuAccess" wire:model="isMultiple">
                                    <label for="menuAccess" class="custom-control-label cursor-pointer">Is Multiple</label>
                                </div>
                            </div>
                        </dic>
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

    <script src="{{ asset('assets/js-pages/page-form-element.js') }}"></script>

@endsection
