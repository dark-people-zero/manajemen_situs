@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <iframe src="/zia_togel_mobile" id="iframe-preview" class="iframe-preview iframe-preview--mobile" width="100%"></iframe>
@endsection

@section('scripts')
    <script>
        $(".header-icon-svgs-prev").click(function() {
            var url = $(this).data("url");
            $("#iframe-preview").attr("src", url)
            $(".header-icon-svgs-prev").removeClass("active");
            $(this).addClass("active");
        })
    </script>
@endsection
