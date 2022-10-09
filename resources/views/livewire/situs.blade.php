@section('styles')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

@endsection

<div>
    <div class="card mt-3 card-success">
        <div class="card-header pb-0">
            <h5 class="card-title mb-0 pb-0">Site Data</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <input class="form-control form-control-sm" placeholder="Search..." type="search" wire:model="search" >
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formSiteData" wire:click="shodModal(true)">Add Data</a>
                </div>
            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="search, previousPage, gotoPage, nextPage"></div>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable border-primary text-nowrap">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center">Site Name</th>
                                <th colspan="2" class="text-center">Status</th>
                                <th colspan="2" class="text-center">URL Development</th>
                                <th colspan="2" class="text-center">URL Production</th>
                                <th rowspan="2" class="text-center align-middle">Action</th>
                            </tr>
                            <tr class="text-center">
                                <th>Desktop</th>
                                <th>Mobile</th>
                                <th>Desktop</th>
                                <th>Mobile</th>
                                <th>Desktop</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{$item->status_desktop ? 'primary' : 'danger'}}">{{$item->status_desktop ? 'Active' : 'Not Active'}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{$item->status_mobile ? 'primary' : 'danger'}}">{{$item->status_mobile ? 'Active' : 'Not Active'}}</span>
                                        </td>
                                        <td>
                                            <a href="{{$item->url_desktop_dev}}" target="_blank">{{$item->url_desktop_dev}}</a>
                                        </td>
                                        <td>
                                            <a href="{{$item->url_mobile_dev}}" target="_blank">{{$item->url_mobile_dev}}</a>
                                        </td>
                                        <td>
                                            <a href="{{$item->url_desktop_prod}}" target="_blank">{{$item->url_desktop_prod}}</a>
                                        </td>
                                        <td>
                                            <a href="{{$item->url_mobile_prod}}" target="_blank">{{$item->url_mobile_prod}}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="text-info me-2" data-bs-toggle="modal" data-bs-target="#formSiteData" wire:click="shodModal(false,{{$item->id}})">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-danger delete" wire:click="deleteConfirm({{$item->id}})">
                                                <i class="fe fe-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No matching records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $data->onEachSide(0)->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <!-- Form User Modal -->
    <div class="modal fade" id="formSiteData" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content chat border-0 position-relative">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title">Form {{$idUpdate ? 'update' : 'add'}} site data</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveData">
                        <div class="form-group">
                            <label for="name">Site Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Site Name" wire:model="name" autofocus required value="{{$name}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="d-flex align-items-center">
                                <div class="checkbox me-3">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="statusDesktop" wire:model="d_status" {{$d_status ? 'checked' : ''}} >
                                        <label for="statusDesktop" class="custom-control-label mt-1">Desktop</label>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="statusMobile" wire:model="m_status" {{$m_status ? 'checked' : ''}}>
                                        <label for="statusMobile" class="custom-control-label mt-1">Mobile</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>URL Development</label>
                            <div class="d-flex">
                                <div class="me-1 w-100">
                                    <input type="text" class="form-control @error('url_d_desktop') is-invalid @enderror" placeholder="URL Development Desktop" wire:model="url_d_desktop" value="{{$url_d_desktop}}">
                                    @error('url_d_desktop')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="w-100">
                                    <input type="text" class="form-control @error('url_d_mobile') is-invalid @enderror" placeholder="URL Development Mobile" wire:model="url_d_mobile" value="{{$url_d_mobile}}">
                                    @error('url_d_mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>URL Production</label>
                            <div class="d-flex">
                                <div class="me-1 w-100">
                                    <input type="text" class="form-control @error('url_p_desktop') is-invalid @enderror" placeholder="URL Production Desktop" wire:model="url_p_desktop" value="{{$url_p_desktop}}">
                                    @error('url_p_desktop')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="w-100">
                                    <input type="text" class="form-control @error('url_p_mobile') is-invalid @enderror" placeholder="URL Production Mobile" wire:model="url_p_mobile" value="{{$url_p_mobile}}">
                                    @error('url_p_mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-outline-primary w-100" type="submit">Save</button>
                    </form>
                </div>

                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center" style="background: #97939314; display: none" wire:loading.flex wire:target="saveData"></div>
            </div>
        </div>
    </div>

    @if ($closeModal)
        <script>
            $("#formSiteData").modal("hide");
        </script>
    @endif
</div>

@section('scripts')
    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".SlectBox").SumoSelect({
            csvDispCount: 3,
            selectAll: !0,
            search: !0,
            searchText: "Enter here.",
            okCancelInMulti: !0,
            captionFormatAllSelected: "Yeah, OK, so everything.",
        })

        document.addEventListener('livewire:load', function () {
            document.getElementById('formSiteData').addEventListener('hidden.bs.modal', event => {
                @this.closeModal = false;
            })
        })

        document.addEventListener("swal:confirm", e => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('deleteData', e.detail.id);
                }
            })
        })
    </script>

@endsection
