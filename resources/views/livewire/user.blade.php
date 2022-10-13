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
                                        @if ($item->id_role == 1)
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
                                        @if (!in_array($item->id, [1,2]) && Auth::user()->id_role == 2 || Auth::user()->id_role == 1)
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
                        <div id="aksesMenuAndSite" style="display: {{in_array($role, [2,3]) ? 'block' : 'none'}}">
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
                                    <div class="checkbox me-2" style="display: {{$role == 2 ? 'block' : 'none'}}">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="userSelect" wire:model="userSelect" {{$userSelect ? 'checked' : ''}}>
                                            <label for="userSelect" class="custom-control-label">User</label>
                                        </div>
                                    </div>
                                    <div class="checkbox me-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="siteSelect" wire:model="siteSelect" {{$siteSelect ? 'checked' : ''}}>
                                            <label for="siteSelect" class="custom-control-label">Site</label>
                                        </div>
                                    </div>
                                    <div class="checkbox me-2" style="display: {{$role == 2 ? 'block' : 'none'}}">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="siteDataSelect" wire:model="siteDataSelect" {{$siteDataSelect ? 'checked' : ''}}>
                                            <label for="siteDataSelect" class="custom-control-label">Site Data</label>
                                        </div>
                                    </div>
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

    <script>
        var ps = new PerfectScrollbar('#modalFormUser', {
            useBothWheelAxes:true,
            suppressScrollX:true,
        });

        document.addEventListener('livewire:load', function () {
            runScriptAccessSite();

            document.addEventListener("access:site", e => runScriptAccessSite());

            $("#role").SumoSelect({
                csvDispCount: 3,
                selectAll: !0,
                search: !0,
                searchText: "Enter here.",
                okCancelInMulti: !0,
                captionFormatAllSelected: "Yeah, OK, so everything.",
            });
            $("#role").on('sumo:closed', function(sumo) {
                @this.role = $(sumo.target).val();
                // if ($(sumo.target).val() == 1) {
                //     $("#aksesMenuAndSite").hide();
                // }else{
                //     $("#aksesMenuAndSite").show();
                //     if ($(sumo.target).val() == 3) {
                //         $("#userSelect").closest('.checkbox').hide();
                //         $("#siteDataSelect").closest('.checkbox').hide();
                //     }else{
                //         $("#userSelect").closest('.checkbox').show();
                //         $("#siteDataSelect").closest('.checkbox').show();
                //     }
                // }
            });
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

                        var target = $(".SlectBox");

                        var ind = [];
                        for (let i = 0; i < target.length; i++) {
                            const element = target[i];
                            var seIndex = element.selectedIndex;
                            var opt = element.children[seIndex];

                            if (opt.getAttribute("value") != "") ind.push(element.selectedIndex);
                        }
                        ind = [...new Set(ind)];

                        for (let i = 0; i < countChild.length; i++) sumo.target.sumo.enableItem(i);

                        ind.forEach(e => {
                            if(sumo.target.selectedIndex != e) sumo.target.sumo.disableItem(e);
                        });
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

            $('.checkFiturAll').change(function() {
                var type = $(this).data('type');
                $(`.checkFitur[data-type="${type}"]`).prop("checked", $(this).prop("checked")).trigger('change');
            })
        }

        document.addEventListener("modalClose", e => {
            $("#formUser").modal("hide");
        });

        document.addEventListener("sumo:role", e => {
            if (e.detail.type == "set") {
                $("#role")[0].sumo.selectItem(e.detail.val.toString());
                // if (e.detail.val == 1) {
                //     $("#aksesMenuAndSite").hide();
                // }
            }

            if (e.detail.type == "reset") {
                var tr = $("#role").find('option[disabled="disabled"]');
                if (tr.length > 0) {
                    tr.removeAttr("disabled");
                    $("#role")[0].sumo.selectItem(tr[0].index);
                    tr.attr("disabled", "disabled");
                }

                // $("#aksesMenuAndSite").show();
            }

        });

        document.addEventListener("sumo:site", e => {
            var data = e.detail.data;
            var index = e.detail.index;
            index.forEach(el => {
                var site = data[el].site;
                var target = $(`select[data-index="${el}"]`);
                target[0].sumo.selectItem(site.toString());
            });
        })
    </script>

@endsection
