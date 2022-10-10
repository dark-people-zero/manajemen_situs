<div class="mt-2">
    <div class="form-group mb-0">
        <div class="d-flex SumoSelect-group">
            <select class="form-control SlectBox" placeholder="Please select one site.">
                @foreach ($situs as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
                <option disabled selected ></option>
            </select>
            <button class="btn br-ts-0 br-bs-0 SumoSelect-group-action hideshow" type="button" data-bs-toggle="collapse" href="#collSite-{{$index}}">
                <i class="fe fe-eye"></i>
                <i class="fe fe-eye-off"></i>
            </button>
            @if ($index != "no1")
                <button class="btn br-ts-0 br-bs-0 SumoSelect-group-action" type="button" wire:click="$emitUp('removeAccessSite', '{{$index}}')">
                    <i class="fe fe-trash-2 text-danger"></i>
                </button>
            @endif

        </div>
    </div>
    <div class="collapse" id="collSite-{{$index}}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th class="text-center">Desktop</th>
                    <th class="text-center">Mobile</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Popup APK
                    </td>
                    <td class="text-center">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-situs-delete">
                                <label for="checkbox-situs-delete" class="custom-control-label mt-1"></label>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
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
</div>

@section('scripts')
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
