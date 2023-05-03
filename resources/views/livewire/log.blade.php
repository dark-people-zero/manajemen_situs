@section('title', 'Log')

@section('styles')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">
    <style>
       .table-body {
        /* width: 100%; */
        height: 62vh;
        overflow: auto;
    }
    .table tbody tr td {
        font-size:10px
    }

    .table-body .table thead tr th{
        border-top: 1px solid #404353 !important;
    }


    </style>

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

            </div>
            <div class="mt-4 position-relative">
                <div class="lds-dual-ring position-absolute w-100 h-100 justify-content-center align-items-center " style="background: #97939314; display: none" wire:loading.flex wire:target="search"></div>
                {{-- <div class="table-responsive"> --}}
                <div class="table-body">

                    <table class="table table-bordered dataTable border-primary" style="border-collapse: separate; border-spacing: 0;">
                        <thead class="sticky-top " style=" background-color: #edecec; ">
                            {{-- class="text-center" --}}
                            <tr >
                                <th >Class</th>
                                <th>Name Activity</th>
                                <th>Data Ip</th>
                                <th>Data Location</th>
                                <th>Data User</th>
                                <th>Data Before</th>
                                <th>Data After</th>
                                <th>Keterangan</th>
                                <th>Create At</th>
                                <th>Update At</th>
                            </tr>
                        </thead>
                        <tbody >
                            {{-- {{ dd($dataLog) }} --}}
                            @if($data->count() > 0) 
                                @foreach($data as $log)
                                    <tr>
                                        {{-- {{ dd(strlen($log->data_before)) }} --}}
                                        <td>{{$log->class}}</td>
                                        <td>{{$log->name_activity}}</td>
                                        <td>{{$log->data_ip}}</td>
                                        <td>{{$log->data_location}}</td>
                                        <td>{{$log->data_user}}</td>
                                        <td>{{$log->data_before}}</td>
                                        <td>{{$log->data_after}}</td>
                                        <td>{{$log->keterangan}}</td>
                                        <td>{{$log->created_at}}</td>
                                        <td>{{$log->updated_at}}</td>

                                    </tr>
                                @endforeach

                            @endif

                        </tbody>
                    </table>
                </div>  

            </div>
            {{ $data->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

</div>

@section('scripts')
    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <script src="{{ asset('assets/js-pages/page-user.js') }}"></script>

@endsection
