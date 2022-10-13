<div class="mt-2">
    <div class="form-group mb-0">
        <div class="d-flex SumoSelect-group">
            <select class="form-control SlectBox" placeholder="Please select one site." data-index="{{$index}}">
                @foreach ($situs as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
                <option disabled selected aria-placeholder></option>
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
                    <th class="text-center">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-type="desktop" class="custom-control-input checkFiturAll" id="checkboxAll-{{$index}}-desktop">
                                <label for="checkboxAll-{{$index}}-desktop" class="custom-control-label mt-1">Desktop</label>
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-type="mobile" class="custom-control-input checkFiturAll" id="checkboxAll-{{$index}}-mobile">
                                <label for="checkboxAll-{{$index}}-mobile" class="custom-control-label mt-1">Mobile</label>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fitur as $i => $item)
                @php
                    $checkDesktop = false;
                    $checkMobile = false;
                    if ($data != null) {
                        $f = isset($data["fitur"][$item->id]) ? $data["fitur"][$item->id] : null;
                        if ($f != null) {
                            $checkDesktop = $f["desktop"];
                            $checkMobile = $f["mobile"];
                        }
                    }
                @endphp
                    <tr>
                        <td>{{$item->name}}</td>
                        <td class="text-center">
                            <div class="checkbox">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-id="{{$item->id}}" data-type="desktop" data-index="{{$index}}" class="custom-control-input checkFitur" id="checkbox-{{$index}}-{{$i}}-desktop" {{$checkDesktop ? 'checked' : '' }}>
                                    <label for="checkbox-{{$index}}-{{$i}}-desktop" class="custom-control-label mt-1"></label>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="checkbox">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-id="{{$item->id}}" data-type="mobile" data-index="{{$index}}" class="custom-control-input checkFitur" id="checkbox-{{$index}}-{{$i}}-mobile" {{$checkMobile ? 'checked' : '' }}>
                                    <label for="checkbox-{{$index}}-{{$i}}-mobile" class="custom-control-label mt-1"></label>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
