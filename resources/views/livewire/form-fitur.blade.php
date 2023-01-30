@section('title', 'Form Fitur')

@section('styles')
    <!--Internal Sumoselect css-->
    {{-- <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.min.css')}}"> --}}

    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">


@endsection

<div id="content-form-element">
    <div class="card mt-3 card-success">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0 pb-0">Form Fitur</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control form-control-sm" placeholder="Search..." type="search" wire:model="search" >
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formFitur" wire:click="showForm(true)">Add Data</a>
                </div>
            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="search"></div>
                <table class="table table-bordered dataTable border-primary">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Fitur</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($typeFitur as $item)
                            <div>{{ $item }}</div>
                        @endforeach --}}
                        
                        @if ($data->count() > 0)
                            @foreach ($data->groupBy("typeFitur.name") as $key=> $item)
                                {{-- @foreach($item as $value) --}}
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$item->pluck('formElemen.name')->join(", ")}}</td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="text-info me-2" wire:click="showForm(false,{{$item[0]->id_fitur}})" data-bs-toggle="modal" data-bs-target="#formFitur">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-danger" wire:click="deleteConfirm({{$item[0]->id_fitur}})">
                                                <i class="fe fe-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                {{-- @endforeach --}}
                                
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

    <!-- Form User Modalx-->
    <div class="modal fade" id="formFitur" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
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
                            <div wire:ignore>
                                <select class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Please select one type">
                                    @foreach ($fitur as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    <option selected  disabled="disabled"></option>
                                </select>
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Type Element</label>
                            <div wire:ignore>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" placeholder="Please select one type" multiple>
                                    @foreach ($formElement as $item)
                                   
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

    <script src="{{ asset('assets/js-pages/page-form-fitur.js') }}"></script>

@endsection
