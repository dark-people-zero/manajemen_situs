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
    <div class="modal fade" id="formUser" tabindex="-1" role="dialog"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" wire:ignore.self>
        <div class="modal-dialog modal-dialog-right" role="document">
            <div class="modal-content chat border-0">
                <div class="modal-header border-bottom">
                    <h6 class="modal-title">Form add users</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalFormUser">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" wire:model="name" value="{{$name}}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter Username" wire:model="username" value="{{$username}}">
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
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-create" wire:model="all_c" {{$all_c ? 'checked' : ''}}>
                                                    <label for="all-create" class="custom-control-label mt-1">C</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-read" wire:model="all_r" {{$all_r ? 'checked' : ''}}>
                                                    <label for="all-read" class="custom-control-label mt-1">R</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-update" wire:model="all_u" {{$all_u ? 'checked' : ''}}>
                                                    <label for="all-update" class="custom-control-label mt-1">U</label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="all-delete" wire:model="all_d" {{$all_d ? 'checked' : ''}}>
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
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-create" wire:model="user_c" {{$user_c ? 'checked' : ''}}>
                                                    <label for="checkbox-user-create" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-read" wire:model="user_r" {{$user_r ? 'checked' : ''}}>
                                                    <label for="checkbox-user-read" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-update" wire:model="user_u" {{$user_u ? 'checked' : ''}}>
                                                    <label for="checkbox-user-update" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-user-delete" wire:model="user_d" {{$user_d ? 'checked' : ''}}>
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
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-create" wire:model="situs_c" {{$situs_c ? 'checked' : ''}}>
                                                    <label for="checkbox-situs-create" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-read" wire:model="situs_r" {{$situs_r ? 'checked' : ''}}>
                                                    <label for="checkbox-situs-read" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-update" wire:model="situs_u" {{$situs_u ? 'checked' : ''}}>
                                                    <label for="checkbox-situs-update" class="custom-control-label mt-1"></label>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="checkbox">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-delete" wire:model="situs_d" {{$situs_d ? 'checked' : ''}}>
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
                                <span class="badge badge-primary" wire:click="addAccessSite">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </label>
                        </div>
                        @foreach ($dataAccessSite as $i => $item)
                            <livewire:access-site :index="$item" :wire:key="$i">
                        @endforeach
                    </form>
                </div>
                <div class="modal-header border-top">
                    <a href="#" class="btn btn-primary">Simpan</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <script>
        var ps = new PerfectScrollbar('#modalFormUser', {
            useBothWheelAxes:true,
            suppressScrollX:true,
        });
        document.addEventListener('livewire:load', function () {
            runScriptAccessSite();

            document.addEventListener("access:site", e => runScriptAccessSite());
        })

        function runScriptAccessSite() {
            ps.update();
            for (let i = 0; i < $(".SlectBox").length; i++) {
                const element = $($(".SlectBox")[i]);
                if (!element.hasClass('SumoUnder')) {

                    element.SumoSelect({
                        csvDispCount: 3,
                        selectAll: !0,
                        search: !0,
                        searchText: "Enter here.",
                        okCancelInMulti: !0,
                        captionFormatAllSelected: "Yeah, OK, so everything.",
                    });

                    element.on('sumo:closed', function(sumo) {
                        var target =  $(sumo.target);
                        var index = target.data("index");
                        @this.addAccessSiteVal(index,'site',target.val());
                    });

                    element.on("sumo:opening", function(sumo) {
                        var target =  $(sumo.target);
                        var index = target.data("index");
                        var countChild = target.find('option').not(':last-child');

                        var selected = $(".SlectBox").not(`[data-index="${index}"]`).filter(e => {
                            console.log(e);
                            console.log(e.value);
                            return e.value != undefined;
                        });
                        console.log(selected);
                        // for (let i = 0; i < x.length; i++) {
                        //     for (let ii = 0; ii < countChild; ii++) {
                        //         x[i].sumo.enableItem(ii);
                        //     }
                        // }
                    })
                }
            }


            var collapseAll = document.querySelectorAll('.collapse');
            for (let i = 0; i < collapseAll.length; i++) {
                const element = collapseAll[i];
                element.addEventListener('show.bs.collapse', function (e) {
                    var tr = $(`[href="#${e.target.id}"]`).closest('.SumoSelect-group').addClass('collase-show');
                })

                element.addEventListener('hide.bs.collapse', function (e) {
                    var tr = $(`[href="#${e.target.id}"]`).closest('.SumoSelect-group').removeClass('collase-show');
                })
            }

            $('.checkFitur').change(function() {
                var id = $(this).data("id"),
                    type = $(this).data("type"),
                    index = $(this).data("index");

                var target = $(this).closest('tr');
                var data = {
                    [id]: {
                        id: id,
                        desktop: target.find('input[data-type="desktop"]').prop("checked"),
                        mobile: target.find('input[data-type="mobile"]').prop("checked")
                    }
                };

                @this.addAccessSiteVal(index,'fitur',data);
            })
        }
    </script>

@endsection
